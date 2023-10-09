<?php

namespace App\CustomClass;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class AdsData
{
    public $listing;
    public $cntMostViewed;
}
