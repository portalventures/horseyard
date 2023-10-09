<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
  use HasFactory;
    
  protected $table = "state";

  protected $fillable = ['id', 'state_name', 'state_code', 'country_id', 'created_at', 'updated_at'];

  public function suburbs()
  {
    return $this->hasMany(Suburb::class);
  }
}
