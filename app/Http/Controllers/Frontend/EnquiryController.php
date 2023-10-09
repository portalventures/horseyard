<?php

namespace App\Http\Controllers\Frontend;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\EmailTrait;
use App\Models\ContactEnquiries;

class EnquiryController extends Controller
{
    use EmailTrait;

    protected $user_modal;
    protected $message_modal;
    protected $message_attachment;
    public $response;

    public function save_send_message(Request $request)
    {

        $this->validate($request, [
            'fullname' => 'required',
            'email' => 'required',
            'message'    => 'required',
            
          ]);

          ContactEnquiries::create([
            'name' => $request->fullname,
            'company' => $request->company,
            'email' => $request->email,
            'phone' => $request->mobile,
            'message' => $request->message,
            'is_active' => '1',
          ]);

          try{
            $toAddr = getenv('ADMIN_EMAIL_ADDR');
            $fromAddr = getenv('SENDGRID_SERDER_ADDRESS');
            $subj = "Enquiry from website...";
            $mbody = "Received the following details...\n";
            $mbody = $mbody . "Name : " . $request->fullname . "\n";
            $mbody = $mbody . "Company : " . $request->company . "\n";
            $mbody = $mbody . "email : " . $request->email . "\n";
            $mbody = $mbody . "phone : " . $request->phone . "\n";
            $mbody = $mbody . "message : " . $request->message . "\n";
            $mbody = $mbody . "\nThank you\n";

            $this->sendMail($fromAddr, $toAddr, $subj, $mbody);
          } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
          }
          return redirect('/advertise#hyContact');   
    }
}
