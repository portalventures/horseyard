<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use SendGrid\Mail\Mail;
use App\helpers;
use Carbon\Carbon;
use App\Http\Controllers\Frontend\MyHomeController;

use App\Models\User;
use App\Models\State;
use App\Models\Suburb;
use App\Models\TopCategory;
use App\Models\CategoryDynamicFields;
use App\Models\DynamicFieldValues;
use App\Models\ListingMaster;
use App\Models\ListingDynamicFieldValues;
use App\Models\ListingImages;
use App\Models\ListingMeta;
use App\Models\FeaturedListing;
use App\Models\LatestListings;
use App\Models\BlogListings;
use App\Models\Blog;
use App\CustomClass\SearchParams;

class ListingViewController extends Controller
{
  public $listing_master;
  public $general_search_result;
  public $top_category;
  public $top_categories;
  public $search_params;
  public $master_query;
  public $join_query;
  public $listing_meta;
  public $sortingMethod;
  public $perPageCnt;
  public $searchText;
  public $search_results;

  public function __construct(ListingMaster $listing_master, ListingMeta $listing_meta)
  {
    
  }
  
  public function view_listing(Request $request, $allParams)
  {
    $searchParams = new SearchParams;
    $searchParams->resetSearchTerms();

    $current_page = 'view_listing';

    $params = explode(DELIM_SLUG, $allParams);
    $adId = $params[0];

    $listing = ListingMaster::where('ad_id', $adId)->first();

    session(['listing_category' => '']);

    if($listing->category_id == 1)
    {    
      session(['listing_category' => 'horses']);
    }
    else if($listing->category_id == 2)
    {
      session(['listing_category' => 'transport']);
    }
    else if($listing->category_id == 3)
    {
      session(['listing_category' => 'saddlery']);
    }
    else if($listing->category_id == 4)
    {      
      session(['listing_category' => 'property']);
    }
    
    $ad_images = $listing->images()->get();

    $listing_meta = $listing->listing_meta()->first();
    if (empty($listing_meta)) {
      $listing_meta = new ListingMeta;
      $listing_meta = $listing_meta->create([
        'listing_master_id' => $listing->id,
        'number_of_views' => 1,
        'last_view_dt' => Carbon::now()
      ]);
      $listing_number_of_views = $listing_meta->number_of_views;
    }
    else {
      $listing_meta->fill([
        'listing_master_id' => $listing->id,
        'number_of_views' => $listing_meta->number_of_views + 1,
      ])->save();
      $listing_number_of_views = $listing_meta->number_of_views;
    }

    $meta_data = ListingMeta::orderBy('number_of_views', 'desc')
      ->join('listing_master', 'listing_master.id', '=', 'listing_meta.listing_master_id')
      ->where('listing_meta.listing_master_id', '!=', $listing->id)
      ->take(4)
      ->get();

    return view('front.view_listing', compact('current_page', 'listing', 'ad_images', 'listing_number_of_views', 'meta_data'));
  }
}
