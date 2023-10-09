<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactEnquiries extends Model
{
  use HasFactory;
    
  protected $table = "contact_form_details";

  protected $fillable = ['id', 'name', 'email', 'phone', 'company', 'message', 'user_id', 'parent_id', 'is_active', 'recvd_dt', 'created_at', 'updated_at'];    
}
