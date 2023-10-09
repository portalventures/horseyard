<?php

namespace App\Http\Controllers\Admin;
Use Response;
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
use App\Http\Traits;
use App\Http\Traits\EmailTrait;
use GuzzleHttp\Promise\Create;
use App\Models\ListingMaster;

class AdminUsersController extends Controller
{
  use EmailTrait;
  public function manage_admin_view(Request $request)
  {
    $current_page = "manage_admin";
    $adminUser = User::where('role',  '=',  'admin')->paginate(25);
    return view('admin.user.manage_admin',compact('adminUser', 'current_page'));
  }

  public function add_admin_view(Request $request)
  {

    $current_page = "manage_admin";
    $adminUser = User::paginate(1);
    return view('admin.user.add_admin',compact('current_page'));
  }

  public function checkEmail(Request $request)
  {
    if($request->get('email'))
    {
      $email = $request->get('email');
      $adminUser = DB::table("users")
      ->where('email', $email)
      ->count();
      if($adminUser > 0)
      {
      echo 'not_unique';
      }
      else
      {
        echo 'unique';
      }
    }
  }

  public function checkMobile(Request $request)
  {
    if($request->get('mobile'))
    {
      $mobile = $request->get('mobile');
      $adminUser = DB::table("users")
      ->where('phone_number', $mobile)
      ->count();
      if($adminUser > 0)
      {
        echo 'not_unique';
      }
      else
      {
        echo 'unique';
      }
    }
  }

  public function edit_admin_view(Request $request, $userId)
  {
    $current_page = "manage_admin";
    $adminUser = User::where('id', '=', $userId)->first();
    return view('admin.user.edit_admin',compact('adminUser', 'current_page'));
  }

  public function save_admin_user(Request $request)
  {
    $current_page = "manage_admin";

    $validated = $request->validate([
      'role' => 'required',
      'first_name' => 'required',
      'last_name' => 'required',
      'email' => 'required|email|unique:users,email',
      'passwd' => 'required',
      'confpass' => 'required',
      'mobile' => 'required',
    ]);

    if($request->passwd != $request->confpass) {
      return back()->with('error','Password and confirmation password do not match.');
    }

    $adminUser = User::create([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'email'  => $request->email,
      'phone_number' => $request->mobile,
      'password' => Hash::make($request->passwd),
      'token' => Str::random(32),
      'country' => $request->country,
      'is_active' => '1',
      'is_verifed' => '1',
      'is_blocked' => '0',
      'role' => 'admin',
      'gender' => $request->gender,
    ]);
    
    $subj = "Horseyard password";
    $message = "Your horseyard password = " . $request->passwd;
    $toAddr = $request->email;      
    $email_response =  $this->sendMail("", $toAddr, $subj, $message);

    $adminUser = User::where('role',  '=',  'superadmin')->orWhere('role',  '=',  'admin')->orWhere('role',  '=',  'editor')->paginate(25);
    return view('admin.user.manage_admin',compact('adminUser', 'current_page'));
  }

  public function update_admin_user(Request $request)
  {
    $current_page = "manage_admin";

    if(empty($request->first_name)){
      return back()->with('error','First name cannot be empty');
    }

    if(empty($request->last_name)){
      return back()->with('error','Last name cannot be empty');
    }


    $chgPass = false;

    if(!empty($request->passwd)) {
      if($request->passwd != $request->confpass) {
        return back()->with('error','Password and confirmation password do not match.');
      } else {
        $chgPass = true;
      }
    }

    if(empty($request->idfield)){
      return back()->with('error','Record not found.');
    }

    try {
      $adminUser = User::find($request->idfield);

      $adminUser->first_name = $request->first_name;
      $adminUser->last_name = $request->last_name;
      $adminUser->phone_number = $request->phone_number;
      $adminUser->gender = $request->gender;
      if($chgPass) {
        $adminUser->password = Hash::make($request->passwd);
      }

      $adminUser->save();
    } catch (\Exception $e) {
      dd($e);
    }


    $adminUser = User::Where('role',  '=',  'admin')->orWhere('role',  '=',  'editor')->paginate(25);
    return view('admin.user.manage_admin',compact('adminUser', 'current_page'));
  }

  public function admin_delete_user(Request $request)
  {
    $user_data = User::where('token', $request->user_token)->update(['is_delete' => '1']);
    $update_listings = ListingMaster::where('user_id',$request->user_id)->update(['is_delete' => '1']);
  }
}
