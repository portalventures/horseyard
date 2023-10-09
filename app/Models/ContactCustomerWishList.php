<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactCustomerWishList extends Model
{
  use HasFactory;
    
  protected $table = "contact_customer_wish_list";

  protected $fillable = ['id', 'user_id', 'listing_master_id', 'is_active', 'created_at', 'updated_at'];    
}
