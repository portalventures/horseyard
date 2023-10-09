<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryDynamicFields extends Model
{
  use HasFactory;
    
  protected $table = "category_dynamic_fields";

  protected $fillable = ['id', 'category_id', 'field_name', 'field_seq_no', 'field_type', 'created_at', 'updated_at'];    
}
