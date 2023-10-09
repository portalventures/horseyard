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
use App\Http\Traits\EmailTrait;

class ContactEnquiriesController extends Controller
{
  use EmailTrait;
  public function contact_enquiries_view(Request $request)
  {
    $current_page = "contact_enquiries";
    $enquiryLst = ContactEnquiries::where('email', '<>', "")->paginate(25);
    
    return view('admin.contact_enquiries',compact('enquiryLst', 'current_page'));
  }

  public function contact_enquiry_detail_view(Request $request, $eId)
  {
    $current_page = "contact_enquiries";
    $enqObj = ContactEnquiries::find($eId);
    $respObj = ContactEnquiries::where('parent_id', '=', $eId)->first();

    return view('admin.contact_enquiry_detail',compact('enqObj', 'respObj', 'current_page'));
  }

  public function contact_enquiry_send_response(Request $request)
  {
    $current_page = "contact_enquiries";

    $enqObj = ContactEnquiries::find($request->idfield);

    ContactEnquiries::create([
      'email' => $request->email,
      'phone' => $request->mobile,
      'message' => $request->response_text,
      'user_id' => Auth()->user()->id,
      'parent_id' => $request->idfield,
      'is_active' => '1',
    ]);

    // update the responding user id to original message, this will also update the last update date
    $enqObj->user_id = Auth()->user()->id;
    $enqObj->save();

    $eMessage = "You have received an response to your query via contact form of the website. Please login to your account to view the response.";
    $toAddr = $request->email;
    $subj = "Response to your email...on Horseyard Website";
    $email_response =  $this->sendMail("", $toAddr, $subj, $eMessage);

    return redirect('admin/contact-enquiries')->with('message', 'Response sent successfully!!!');
  }

  public function delete_contact_enquiry(Request $request, $uid)
  {
    $current_page = "manage_contact_enquiries";

    if(empty($uid)){
      return back()->with('error','Record not found.');
    }

    try {
      $contact = ContactEnquiries::find($uid);

      if($contact->is_active == '1') {
        $contact->is_active = '0';
      } else {
        $contact->is_active = '1';
      }
  
  
      $contact->save();
    } catch (\Exception $e) {
      dd($e);
    }
    
    return back()->with('success','Enquiry updated successfully');
  }
}