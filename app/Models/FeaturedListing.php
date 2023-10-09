<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeaturedListing extends Model
{
  use HasFactory;
    
  protected $table = "featured_listings";

  protected $fillable = ['id', 'created_by', 'listing_master_id', 'category_id', 'seq_no', 'is_active', 'created_at', 'updated_at'];    
}
