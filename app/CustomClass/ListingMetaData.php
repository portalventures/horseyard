<?php

namespace App\CustomClass;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class ListingMetaData
{
    public $cntActiveAds;
    public $cntPendingAds;
    public $cntReportedAds;
    public $cntBlockedAds;
    public $cntTotalUsers;
    
}
