<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Redirect;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id', 'old_user_id', 'first_name', 'last_name', 'email', 'password', 'company_name', 'address_line_1', 'address_line_2', 'suburb', 'state', 'country', 'postal_code', 'phone_number', 'gender', 'date_of_birth', 'google_id', 'social_type', 'verification_code', 'role', 'is_verifed', 'is_active', 'is_blocked', 'blocked_at', 'is_delete', 'token', 'created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_listings()
    {
        return $this->hasMany(ListingMaster::class);
    }

    public function user_messages()
    {
        $email = Auth()->user()->email;
        $userId = Auth()->user()->id;
        $query = $this->hasMany(CustomerMessage::class, 'to_user_id')
            ->leftJoin('block_user', function ($query) use ($userId) {
                $query->where('customer_messages.to_user_id', '=', $userId)
                    ->where(function ($query) {
                        $query->where(function ($query) {
                            $query->on('block_user.from_user', '=', 'customer_messages.to_user_id')
                                ->on('block_user.to_user', '=', 'customer_messages.from_user_id');
                        })
                            ->orWhere(function ($query) {
                                $query->on('block_user.from_user', '=', 'customer_messages.from_user_id')
                                    ->on('block_user.to_user', '=', 'customer_messages.to_user_id');
                            });
                    });
            })
            ->join('users', 'users.id', '=', 'customer_messages.from_user_id')
            ->whereNull("block_user.id")
            ->where(function ($query) use ($email) {
                $query->where("customer_messages.disabled_user", "not like", "%" . $email . "%")
                    ->orWhereNull('customer_messages.disabled_user');
            })
            ->select('customer_messages.id', 'from_user_id', 'to_user_id', 'subject', 'body_text', 'is_read', 'customer_messages.created_at', 'users.first_name', 'users.last_name', 'users.email')->orderBy('customer_messages.created_at', 'desc')
            ->paginate(10);
        return $query;
    }
    public function user_messages_detail($rowId)
    {
        $message = new CustomerMessage();
        $message->where('id', $rowId)->update(['is_read' => "1"]);
        $data = $message->where('id', $rowId)->get();
        $response = BlockUser::check_block_user($data[0]->from_user_id);
        if ($response->message == "block") {
            return $response->message;
        }
        return $data;
    }
    public function user_reply_detail($rowId)
    {
        $message = new CustomerMessage();
        $message->where('parent_msg_id', $rowId)->update(['is_read' => "1"]);
        $data = $message->where('parent_msg_id', $rowId)->get();
        return $data;
    }
    public function user_attachment($rowId)
    {
        $attachment = new CustomerMessageAttachment();
        $data = $attachment->where('message_id', $rowId)->get();
        return $data;
    }


    public function send_verification_code($user_details, $from = '')
    {
        $pass = env('SENDGRID_API_KEY'); // not the key, but the token
        $url = 'https://api.sendgrid.com/';

        if ($from == "signup") {
            $message = "your verification code = $user_details->verification_code";
        } else {
            $message = "your verification code = $user_details->verification_code";
        }

        $params = array(
            'to'        => $user_details->email,
            'subject'   => 'Verification code',
            'html'      => "$message",
            'from'      => 'jignesh.nai@inuscg.com',
        );

        $request =  $url . 'api/mail.send.json';
        $headr = array();
        // set authorization header
        $headr[] = 'Authorization: Bearer ' . $pass;

        $session = curl_init($request);
        curl_setopt($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // add authorization header
        curl_setopt($session, CURLOPT_HTTPHEADER, $headr);

        $response = curl_exec($session);
    }

    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isActive()
    {
        return $this->is_active === '1';
    }

    public function isDelete()
    {
        return $this->is_delete === '0';
    }

    public function getFullName()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }
}
