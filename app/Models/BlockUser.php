<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Log;

class BlockUser extends Model
{
    use HasFactory;
    protected $response;
    public $timestamps = true;

    protected $table = "block_user";

    protected $fillable = ['id', 'from_user', 'to_user', 'created_at', 'updated_at'];

    public static function add_block_user($useId)
    {
        $response = new ResponseModal();
        try {
            $insert = BlockUser::create([
                'from_user' => Auth()->user()->id,
                'to_user' => $useId
            ]);
            $response->message = $insert->id;
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

    public static function check_block_user($to_useId)
    {
        $response = new ResponseModal();
        $from_user = Auth()->user()->id;
        try {
            $insert = BlockUser::where([['from_user', '=', $from_user], ['to_user', '=', $to_useId]])
                ->orWhere([['from_user', '=', $to_useId], ['to_user', '=', $from_user]])->get();
            if ($insert->count() > 0) {
                $response->message = "block";
            }
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

    public static function get_blocK_usr()
    {
        $query = BlockUser::join("users", "users.id", "to_user")
            ->where("from_user", "=", Auth()->user()->id)
            ->select("block_user.id", "block_user.to_user", "users.first_name", "users.last_name", "users.email")->get();

        return $query;
    }

    public static function unblock_user($userId)
    {
        $response = new ResponseModal();
        try {

            $query = BlockUser::where("from_user", "=", Auth()->user()->id)
                ->where("to_user", "=", $userId)->delete();
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
}
