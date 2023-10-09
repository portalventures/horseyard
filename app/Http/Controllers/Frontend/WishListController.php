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

use App\Models\User;
use App\Models\State;
use App\Models\Suburb;
use App\Models\TopCategory;
use App\Models\CategoryDynamicFields;
use App\Models\DynamicFieldValues;
use App\Models\ListingMaster;
use App\Models\ListingDynamicFieldValues;
use App\Models\ListingImages;
use App\Models\FeaturedListing;
use App\Models\LatestListings;
use App\Models\BlogListings;
use App\Models\Blog;
use App\Models\ContactCustomerWishList;

class WishListController extends Controller
{
  public function view_wishlist($value='')
  {
    $current_page = 'wishlist';
    $wishlist = ContactCustomerWishList::select('listing_master.id as listing_id',
                                              'listing_master.title as listing_title',
                                              'listing_master.price as listing_price',  
                                              'listing_master.description as listing_description',
                                              'listing_master.identification_code as listing_identification_code',
                                              'contact_customer_wish_list.created_at as wishlist_created_at')
                                        ->where('contact_customer_wish_list.user_id' , Auth()->user()->id)
                                        ->join('listing_master','listing_master.id','=','contact_customer_wish_list.listing_master_id')
                                        ->paginate(20);
    return view('front.account.wishlist.wishlist',compact('current_page','wishlist'));
  }

  public function listing_add_into_wishlist(Request $request)
  {
    $listing = ListingMaster::where('identification_code', $request->listing_token)->first();
    $wishlist = ContactCustomerWishList::where(['user_id' => Auth()->user()->id,'listing_master_id' => $listing->id])->first();

    if(empty($wishlist))
    {
      ContactCustomerWishList::create([
        'user_id' => Auth()->user()->id,
        'listing_master_id' => $listing->id
      ]);
      return true;
    }
    else{
      $wishlist->delete();
      return false;
    }
  }   
}
