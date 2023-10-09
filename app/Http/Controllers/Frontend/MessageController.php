<?php

namespace App\Http\Controllers\Frontend;

use Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Pipeline;
use App\Http\Controllers\Controller;
use App\Models\User as userModal;
use App\Models\CustomerMessage as customerMessage;
use App\Models\CustomerMessageAttachment as customerMessageAttachment;
use App\Models\ResponseModal as responseModal;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Route;
use App\helpers;
use App\Http\Traits\EmailTrait;
use App\Models\BlockUser;
use GrahamCampbell\ResultType\Success;
use Illuminate\Foundation\Auth\User;

class MessageController extends Controller
{
    use EmailTrait;

    protected $user_modal;
    protected $message_modal;
    protected $message_attachment;
    public $response;

    public function __construct(userModal $user_modal, customerMessage $message_modal, customerMessageAttachment $message_attachment, responseModal  $response)
    {
        $this->user_modal = $user_modal;
        $this->message_modal = $message_modal;
        $this->message_attachment = $message_attachment;
        $this->response = $response;
    }

    //getting inbox tab view
    public function inbox_view(Request $request)
    {
        $data['current_page'] = 'inbox';
        $data['list'] = $this->inbox_list_view($request);
        return view('front.account.message.inbox', $data);
    }

    //getting inbox tab's message listing view
    public function inbox_list_view(Request $request)
    {
        $data['list'] = Auth()->user()->user_messages();
        $data['page'] = $request->page;
        // dd($data['list']->total);
        return view('front.account.message.inbox_list_partial', $data);
    }

    //getting compose tab's view
    public function compose_view(Request $request)
    {
        $current_page = 'compose';
        return view('front.account.message.compose', compact('current_page'));
    }

    //getting message tab's detai view
    public function message_detail_view(Request $request)
    {
        $data['current_page'] = 'message_detail';
        $data['detail'] = $this->message_detail_partial($request);
        return view('front.account.message.mail_detail', $data);
    }

    //getting message tab's detail partial view
    public function message_detail_partial(Request $request)
    {
        $messageDetails = array();
        $userId = $request->userId;
        $data['senderDetail'] = $this->sender_detail($userId);
        $detail = Auth()->user()->user_messages_detail($request->id);
        if ($detail == "block") {
            return Redirect::to("inbox");
        }
        $attachment = $this->message_attachememt($request->id);
        array_push($messageDetails, [$detail, $attachment]);
        $replayDetail = Auth()->user()->user_reply_detail($request->id);

        //replay detail
        if ($replayDetail != null) {
            foreach ($replayDetail as $replay) {
                $replayAttachmetn = $this->message_attachememt($replay->id);
                array_push($messageDetails, [[$replay], $replayAttachmetn]);
            }
        }
        $data['messageDetails'] = $messageDetails;
        return view('front.account.message.mail_detail_partial', $data);
    }

    //download attachment file in message
    public function message_attachememt($requestId)
    {
        return  Auth()->user()->user_attachment($requestId);
    }

    //block user listing tab view
    public function block_user_list(Request $request)
    {
        $data['current_page'] = 'block_user_list';
        $data['detail'] = BlockUser::get_blocK_usr();
        return view('front.account.message.block_user', $data);
    }


    public function sender_detail($userId)
    {
        return $this->user_modal->where("id", $userId)->get();
    }

    public function search_user(Request $request)
    {
        $search_value = $request->query('term')['term'];
        $user_detail = $this->user_modal::leftJoin('block_user', function ($user_detail) {
            $user_detail
                ->where(function ($user_detail) {
                    $user_detail->On('block_user.from_user', '=', "users.id")
                        ->where('block_user.to_user', '=', Auth()->user()->id);
                })
                ->orWhere(function ($user_detail) {
                    $user_detail->where('block_user.from_user', '=', Auth()->user()->id)
                        ->on('block_user.to_user', '=', "users.id");
                });
        })
            ->whereNull("block_user.id")
            ->where(function ($user_detail) use ($search_value) {
                $user_detail->where("email", 'like', $search_value . '%')
                    ->orWhere("first_name", 'like', $search_value . '%')
                    ->orWhere("last_name", 'like', $search_value . '%');
            })
            ->where([
                ["role", "=", "user"],
                ["is_verifed", "=", "1"],
                ["is_active", "=", "1"],
                ["is_delete", "=", "0"]
            ])
            ->orderBy('users.created_at', 'desc')
            ->select("users.id", "first_name", "last_name", "email")->take(10)->get();
        return $user_detail;
    }

    public function send_message(Request $request)
    {
        $user = explode(',', $request->mailTo);
        $files = $request->attachment;
        $inserted = array();
        for ($i = 0; $i < count($user); $i++) {
            $this->response = $this->message_modal->AddMessageDetail($request, $user[$i]);

            if ($this->response->error_no != 0) {
                return $this->response;
            }
            array_push($inserted, $this->response->message);
        }

        //attaching file to message
        if ($request->hasFile('attachment')) {
            $this->response = $this->message_attachment->AddMessageAttachment($request, $inserted);
        }
        return 0;

        //sending notification mail to user
        if ($this->response->error_no == 0) {
            $fromMailId = Auth()->user()->email;
            $fromName = Auth()->user()->first_name . " " . Auth()->user()->last_name;
            $usersId = $request->composeTo;

            if (Auth()->user()->first_name == "" || Auth()->user()->first_name == null) {
                $fromName = (explode("@", $fromMailId)[0]);
            }

            foreach ($usersId as $id) {
                $subject = "New Message Arrived In HorseYard ";
                $message = "New Message Arrived. " . $fromName;
                $toMail = $this->message_modal->GetUserMail($id);

                $email_response =  $this->sendMail("", $toMail, $subject, $message);
            }
        }
        return $this->response->error_no;
    }

    public function download_file(Request $request)
    {
        try {
            $headers = array(
                'Content-Type: application/' . pathinfo($request->fileName, PATHINFO_EXTENSION),
            );
            return response()->download(storage_path('app/public/' . $request->generatedName), $request->fileName, $headers);
        } catch (\Exception $e) {
            Log::info('Error: Code: ' . $e->getCode());
            Log::info('Error: Message: ' . $e->getMessage());

            return back()->with('error', $e->getMessage());
        }
    }

    public function change_message_status(Request $request)
    {
        $response = new responseModal();
        foreach ($request->checked_data as $row_id) {
            $response = $this->message_modal::change_message_status($row_id, $request->action);
        }

        return response()->json([
            'error' => $response->error_no,
            'message' => $response->message
        ]);
    }

    public function remove_message(Request $request)
    {
        $response = new responseModal();
        foreach ($request->rowId as $row_id) {
            $response = $this->message_modal::remove_message($row_id, $request->action);
        }

        return response()->json([
            'error' => $response->error_no,
            'message' => $response->message
        ]);
    }

    public function block_user(Request $request)
    {
        $response = new responseModal();
        $response = BlockUser::add_block_user($request->blockUserId);
        return response()->json([
            'error' => $response->error_no,
            'message' => $response->message
        ]);
    }

    public function unblock_user(Request $request)
    {
        $response = new responseModal();
        $response = BlockUser::unblock_user($request->userId);
        return response()->json([
            'error' => $response->error_no,
            'message' => $response->message
        ]);
    }
}
