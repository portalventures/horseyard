<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Pipeline;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;
use App\Http\Controllers\Route;
use App\helpers;
use App\Models\ContactEnquiries;
use App\Models\ListingMaster;
use App\Models\ListingReports;
use App\CustomClass\ListingMetaData;
use App\Models\ListingMeta;
use App\CustomClass\AdsData;
use App\Http\Traits\EmailTrait;

class AdminLoginController extends Controller
{
    use EmailTrait;
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login_view(Request $request)
    {
        return view('admin.login.login');
    }

    public function authenticate(Request $request)
    {
        $getauthuser_details = User::where('email', $request->email)->first();

        if (!empty($getauthuser_details) && ($getauthuser_details->isSuperAdmin() || $getauthuser_details->isAdmin())) {
            // if($getauthuser_details->is_verifed == 0)
            // {
            //   return back()->with('error','Your account is not verifed');
            // }
            if ($getauthuser_details->is_active == 0) {
                return back()->with('error', 'Your account is deactivated');
            } else {
                $user_data = array(
                    'email'  => $request->email,
                    'password' => $request->password
                );

                if (Auth::attempt($user_data)) {
                    $current_page = 'dashboard';
                    return redirect('admin/dashboard')->with('current_page');
                } else {
                    return back()->with('error', 'Wrong credentials!');
                }
            }
        } else {
            return back()->with('error', 'Account not found');
        }
    }

    public function view_dashboard(Request $request)
    {
        $current_page = 'dashboard';

        // generating the message list
        $enquiryLst = ContactEnquiries::where('email', '<>', "")->orderBy('created_at', 'desc')->limit(5)->get();

        //generating listing meta data
        $cntPendingAds = ListingMaster::where([['is_approved', '=', '0'], ['is_active', '=', '1'], ['is_blocked', '=', '0']])->count();
        $cntActiveAds = ListingMaster::where([['is_approved', '=', '1'], ['is_active', '=', '1'], ['is_blocked', '=', '0']])->count();
        $cntBlockedAds = ListingMaster::where('is_blocked', '=', '1')->count();
        $cntReportedAds = ListingReports::select('listing_master_id')->distinct()->count();
        $uCount = User::count();

        $listingMetaData = new ListingMetaData;

        $listingMetaData->cntActiveAds = $cntActiveAds;
        $listingMetaData->cntBlockedAds = $cntBlockedAds;
        $listingMetaData->cntPendingAds = $cntPendingAds;
        $listingMetaData->cntReportedAds = $cntReportedAds;
        $listingMetaData->cntTotalUsers = $uCount;

        //generating listing most viewed
        $listingMeta = ListingMeta::orderBy('number_of_views', 'desc')->limit(5)->get();

        $idarry = [];
        $listingData = collect();

        if (!empty($listingMeta)) {
            $i = 0;
            foreach ($listingMeta as $rec) {

                $adsData = new AdsData;
                $adsData->cntMostViewed = $rec->number_of_views;
                $adsData->listing = ListingMaster::find($rec->listing_master_id);

                $listingData->push($adsData);
            }
        }

        return view('admin.dashboard', compact('current_page', 'enquiryLst', 'listingMetaData', 'listingData'));
    }

    public function verify_account_code(Request $request)
    {
        $getauthuser_details = User::where('token', $request->token)->first();

        if ($getauthuser_details->verification_code == $request->verification_code && ($getauthuser_details->isSuperAdmin() || $getauthuser_details->isAdmin())) {
            return redirect("admin_changepassword/" . $getauthuser_details->token);
        } else {
            return back()->with('error', 'Wrong verification code');
        }
    }

    public function forgot_password_email(Request $request)
    {
        return view('admin.login.forgot_password_email_verify');
    }

    public function forgot_password_verify_emailaddress(Request $request)
    {
        $getauthuser_details = User::where('email', $request->email)->first();

        if (!empty($getauthuser_details) && ($getauthuser_details->isSuperAdmin() || $getauthuser_details->isAdmin())) {
            $forgot_code = substr(str_shuffle("0123456789"), 0, 5);
            $update_user_details = User::where('email', $request->email)
                ->update(['verification_code' => $forgot_code]);
            $getauthuser_details = User::where('email', $request->email)->first();
            //$email_response = $this->user->send_verification_code($getauthuser_details,'');

            $message = "your verification code = " . $getauthuser_details->verification_code;
            $toAddr = $getauthuser_details->email;
            $subj = "Verification Code from : " . config('app.name');
            $email_response =  $this->sendMail("", $toAddr, $subj, $message);

            return view('admin.login.verify_code', compact('getauthuser_details'));
        } else {
            return back()->with('error', 'Account not found');
        }
    }

    public function changepassword_view(Request $request)
    {
        $getauthuser_details = User::where('token', $request->token)->first();

        if ($getauthuser_details->verification_code != "" && ($getauthuser_details->isSuperAdmin() || $getauthuser_details->isAdmin())) {
            return view('admin.login.update_password', compact('getauthuser_details'));
        } else {
            return redirect('siteadmin');
        }
    }

    public function changepassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
            "confpassword" => 'required|same:password',
        ]);

        $getauthuser_details = User::where('token', $request->token)->first();
        if (!empty($getauthuser_details) && ($getauthuser_details->isSuperAdmin() || $getauthuser_details->isAdmin())) {
            $update_user = User::where('token', $request->token)
                ->update([
                    'password' => Hash::make($request->password),
                    'verification_code' => ''
                ]);
            return redirect('siteadmin')->with('success' . 'Password change successfully');
        } else {
            return redirect('siteadmin')->with('error' . 'Something went wrong');
        }
    }

    public function admin_change_password_view($value = '')
    {
        $current_page = 'change_password';
        return view('admin.change_password.change_password', compact('current_page'));
    }

    public function admin_update_password(Request $request)
    {
        $user = User::findOrFail(Auth()->user()->id);

        $this->validate($request, [
            'new_password' => 'required',
            "confpassword" => 'required|same:new_password',
        ]);

        if (Hash::check($request->oldpassword, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            return back()->with('success', 'Password changed');
        } else {
            return back()->with('error', 'Password does not match');
        }
    }
}
