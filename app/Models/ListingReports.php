<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Log;

class ListingReports extends Model
{
  use HasFactory;

  public $timestamps = true;

  protected $table = "listing_reports";

  protected $fillable = ['id', 'listing_master_id', 'name', 'email', 'reason', 'message', 'created_at', 'updated_at'];
}
