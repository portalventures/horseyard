<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseModal extends Model
{
    use HasFactory;

    public  $error_no;
    public $message;
    public $data;

    public function __construct()
    {
        $this->error_no = 0;
        $this->message = "";
        $this->data = [];
    }
}
