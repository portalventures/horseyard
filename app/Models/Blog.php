<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
  use HasFactory;
    
  protected $table = "blogs";

  protected $fillable = ['id', 'title', 'slug', 'detailed_text', 'image', 'show_in_header_footer', 'category_id', 'is_active', 'created_at', 'updated_at'];

}
