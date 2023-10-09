<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingImages extends Model
{
  use HasFactory;

  protected $table = "listing_images";

  protected $fillable = ['id', 'listing_master_id', 'image_name', 'image_url', 'created_at', 'updated_at'];

  public function listing()
  {
    return $this->belongsTo(ListingMaster::class);
  }
}
