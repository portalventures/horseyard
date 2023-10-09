<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopCategory extends Model
{
  use HasFactory;
    
  protected $table = "top_category";

  protected $fillable = ['id', 'category_name', 'category_icon', 'category_image', 'category_code', 'created_at', 'updated_at'];    
}
