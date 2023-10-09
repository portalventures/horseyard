<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use App\Models\ResponseModal;
use Illuminate\Support\Facades\Auth;
use Log;

class CustomerMessage extends Model
{
    use HasFactory;

    public $response;
    public $timestamps = true;

    protected $table = "customer_messages";

    protected $fillable = ['id', 'parent_msg_id', 'from_user_id', 'to_user_id', 'subject', 'body_text', 'date_of_msg', 'is_read', 'is_active', 'is_draft', 'created_at', 'updated_at'];

    public function message_list()
    {
        return $this->belongsTo(User::class);
    }

    public static function AddMessageDetail($request, $to_user)
    {
        $response = new ResponseModal();
        try {
            $insert_ad = CustomerMessage::create([
                'parent_msg_id' => $request->parentMailId,
                'from_user_id' => Auth()->user()->id,
                'to_user_id' => $to_user,
                'subject' => $request->subject,
                'body_text' => $request->message,
                'date_of_msg' => date('Y-m-d H:i:s', time()),
                'is_read' => '0',
                'is_active' => '1',
                'is_draft' => '0'
            ]);
            $response->message = $insert_ad->id;
        } catch (\Exception\Database\QueryException $e) {
            Log::info('Query: ' . $e->getSql());
            Log::info('Query: Bindings: ' . $e->getBindings());
            Log::info('Error: Code: ' . $e->getCode());
            Log::info('Error: Message: ' . $e->getMessage());
            $response->error_no = 1;
            $response->message = $e->getMessage();
        } catch (\Exception $e) {
            Log::info('Error: Code: ' . $e->getCode());
            Log::info('Error: Message: ' . $e->getMessage());

            $response->error_no = 1;
            $response->message = $e->getMessage();
        }
        return $response;
    }

    public static function change_message_status($row_id, $status)
    {
        $response = new ResponseModal();
        try {
            $response->message = CustomerMessage::where("id", $row_id)->update(array("is_read" => $status));
        } catch (\Exception $e) {
            Log::info('Error: Code: ' . $e->getCode());
            Log::info('Error: Message: ' . $e->getMessage());

            $response->error_no = 1;
            $response->message = $e->getMessage();
        }
        return $response;
    }

    public static function remove_message($row_id)
    {
        $response = new ResponseModal();
        try {
            $existing = CustomerMessage::where("id", $row_id)->value('disabled_user');
            if ($existing != null && $existing != "") {
                $existing .= "," . Auth()->user()->email;
            } else {
                $existing = Auth()->user()->email;
            }
            $response->message = CustomerMessage::where("id", $row_id)->update(array('disabled_user' => $existing));
        } catch (\Exception $e) {
            Log::info('Error: Code: ' . $e->getCode());
            Log::info('Error: Message: ' . $e->getMessage());

            $response->error_no = 1;
            $response->message = $e->getMessage();
        }
        return $response;
    }

    public static function GetUserMail($user_id)
    {
        return User::where("id", $user_id)->value("email");
    }
}
