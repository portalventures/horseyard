<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ResponseModal;
use Log;

class CustomerMessageAttachment extends Model
{
    use HasFactory;

    public $response;

    public $timestamps = true;

    protected $table = "customer_message_attachments";

    protected $fillable = ['id', 'message_id', 'file_name', 'generated_file_name', 'file_type', 'created_at', 'updated_at'];

    public function listing_owner()
    {
        return $this->belongsTo(CustomerMessage::class, "message_id");
    }

    public function AddMessageAttachment($request, $message_id)
    {
        $response = new ResponseModal();
        try {
            $files = $request->attachment;
            if ($request->hasFile('attachment')) {
                foreach ($files as $file) {
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $path_parts = pathinfo($filename);
                    $generatedName = $path_parts['filename'] . "_" . date('Ymd_His', time()) . "." . $extension;

                    Storage::disk('public')->put($generatedName, file_get_contents($file));
                    foreach ($message_id as $message) {
                        $qry = CustomerMessageAttachment::create([
                            'message_id' => $message,
                            'file_name' => $filename,
                            'generated_file_name' => $generatedName,
                            'file_type' =>  $extension
                        ]);
                    }
                }
            }
        } catch (\Exception\Database\QueryException $e) {
            Log::info('Query: ' . $e->getSql());
            Log::info('Query: Bindings: ' . $e->getBindings());
            Log::info('Error: Code: ' . $e->getCode());
            Log::info('Error: Message: ' . $e->getMessage());
            $response->error_no = 1;
            $this->response->message = $e->getMessage();
        } catch (\Exception $e) {
            Log::info('Error: Code: ' . $e->getCode());
            Log::info('Error: Message: ' . $e->getMessage());
            $response->error_no = 1;
            $response->message = $e->getMessage();
        }
        return $response;
    }
}
