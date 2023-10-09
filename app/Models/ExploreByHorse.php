<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExploreByHorse extends Model
{
  use HasFactory;
    
  protected $table = "explore_by_horse";

  protected $fillable = ['id', 'created_by', 'primary_breed_id','image', 'is_active', 'created_at', 'updated_at'];
}
