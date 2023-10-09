<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingDynamicFieldValues extends Model
{
  use HasFactory;

  protected $table = "listing_dynamic_field_values";

  protected $fillable = ['id', 'listing_master_id', 'field_id', 'dynamic_field_id', 'field_value', 'created_at', 'updated_at'];

  public function listing()
  {
    return $this->belongsTo(ListingMaster::class);
  }
}
