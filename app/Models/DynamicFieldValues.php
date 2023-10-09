<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicFieldValues extends Model
{
  use HasFactory;
    
  protected $table = "dynamic_field_values";

  protected $fillable = ['id', 'field_id', 'field_value','slug', 'field_text', 'field_comment', 'seq_no', 'created_at', 'updated_at'];    
}
