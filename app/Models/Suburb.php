<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suburb extends Model
{
  use HasFactory;
    
  protected $table = "suburb";

  protected $fillable = ['id', 'suburb_name', 'suburb_code', 'state_id', 'created_at', 'updated_at'];

  public function state()
  {
    return $this->belongsTo(State::class, 'state_id', 'id');
  }

  public function get_suburb_list_based_on_state($state_id='')
  {
    $suburb_list = Suburb::where('state_id', $state_id)->orderBy('suburb_name','asc')->get();
    
    return $suburb_list;
  }
}
