<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogListings extends Model
{
  use HasFactory;
    
  protected $table = "blog_listings";

  protected $fillable = ['id', 'created_by', 'blog_id', 'category_id', 'seq_no', 'is_active', 'created_at', 'updated_at'];    
}
