<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Log;

class ListingMeta extends Model
{
  use HasFactory;

  public $timestamps = true;

  protected $table = "listing_meta";

  protected $fillable = ['id', 'listing_master_id', 'number_of_views', 'image_name', 'image_url', 'last_view_dt', 'last_edited_dt', 'listing_dt', 'last_meta_update_dt', 'created_at', 'updated_at'];

  public function listing_master()
  {
    return $this->belongsTo(ListingMaster::class);
  }
}

