<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
  use HasFactory;
    
  protected $table = "country";

  protected $fillable = ['id', 'state_name', 'state_code', 'country_id', 'created_at', 'updated_at'];    
}
