<?php

namespace App\Http\Controllers\Admin;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Pipeline;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;
use App\Http\Controllers\Route;
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
use App\Models\ListingReports;
use App\Models\FeaturedListing;
use App\Models\LatestListings;
use Illuminate\Filesystem\Filesystem;
use App\helpers;
use App\Http\Traits\EmailTrait;

class AdminAdsController extends Controller
{
  use EmailTrait;
  public $listing_master;
  public $suburb;
  public $State;

  public function __construct(ListingMaster $listing_master,Suburb $suburb,State $State)
  {
    $this->listing_master = $listing_master;
    $this->suburb = $suburb;
    $this->State = $State;
  }

  public function view_ads_created_by_admin(Request $request)
  {
    $current_page = 'admin_ads';
    $search_key_word = '';

    $adminUsers = User::where('role','=','superadmin')
                        ->orWhere('role','=','admin')
                        ->orWhere('role','=','editor')->pluck('id');

    if(isset($request->search) && !empty($request->search))
    {
      $search_key_word = $request->search;
      $admin_ads = ListingMaster::whereIn('user_id', $adminUsers)
                              ->where(['is_active' => '1','is_delete' => '0'])
                              ->where(function ($query) use ($search_key_word) {
                                $query->orWhere('title', 'LIKE', "%{$search_key_word}%");
                                $query->orWhere('description', 'LIKE', "%{$search_key_word}%");
                                $query->orWhere('ad_id', 'LIKE', "%{$search_key_word}%");
                                $query->orWhere('item_show_type', 'LIKE', "%{$search_key_word}%");
                              })
                              ->paginate(25);  
    }
    else{
      $admin_ads = ListingMaster::whereIn('user_id', $adminUsers)
                              ->where(['is_active' => '1','is_delete' => '0'])
                              ->paginate(25);  
    }    

    return view('admin.ads.admin_ads',compact('current_page','admin_ads','search_key_word'));
  }

  public function create_ad_view(Request $request)
  {
    $current_page = 'create_ad';
    $all_state = State::get();
    $all_top_categories = TopCategory::get();

    return view('admin.ads.create-ad',compact('current_page','all_top_categories','all_state'));
  }

  public function subrub_list(Request $request)
  {
    $suburb_list = $this->suburb->get_suburb_list_based_on_state($request->state);
    $from = 'admin';
    return view('shared.suburb_list', compact('suburb_list','from'));
  }

  public function categoryType_dynemic_fileds(Request $request)
  {
    $get_all_horses_dynamicFields = $this->listing_master->get_deynemic_fileds($request->categoryType);

    if($request->ad_slug_url != '0')
    {
      $ad_data = ListingMaster::where('slug', $request->ad_slug_url)->first();
    }
    else
    {
      $ad_data = '';
    }

    if($request->categoryType == 'transport')
    {
      if(!empty($ad_data))
      {
        $transport_type = ListingDynamicFieldValues::where(['field_id' => 10, 'listing_master_id' => $ad_data->id])->first();
        $transport_no_of_horse_to_carry = ListingDynamicFieldValues::where(['field_id' => 11, 'listing_master_id' => $ad_data->id])->first();
        $transport_ramp_location = ListingDynamicFieldValues::where(['field_id' => 12, 'listing_master_id' => $ad_data->id])->first();
        $transport_axles = ListingDynamicFieldValues::where(['field_id' => 13, 'listing_master_id' => $ad_data->id])->first();
        $transport_registration_state = ListingDynamicFieldValues::where(['field_id' => 14, 'listing_master_id' => $ad_data->id])->first();
      }
      else
      {
        $transport_type = '';
        $transport_no_of_horse_to_carry = '';
        $transport_ramp_location = '';
        $transport_axles = '';
        $transport_registration_state = '';
      }

      return view('admin.ads.listingTypeTransport',compact('get_all_horses_dynamicFields',
                                                            'ad_data',
                                                            'transport_type',
                                                            'transport_no_of_horse_to_carry',
                                                            'transport_ramp_location',
                                                            'transport_axles',
                                                            'transport_registration_state'));
    }
    elseif($request->categoryType == 'saddlery')
    {
      if(!empty($ad_data))
      {
        $saddlery_type = ListingDynamicFieldValues::where(['field_id' => 15, 'listing_master_id' => $ad_data->id])->first();
        $saddlery_category = ListingDynamicFieldValues::where(['field_id' => 16, 'listing_master_id' => $ad_data->id])->first();
        $saddlery_condition = ListingDynamicFieldValues::where(['field_id' => 17, 'listing_master_id' => $ad_data->id])->first();
      }
      else
      {
        $saddlery_type = '';
        $saddlery_category = '';
        $saddlery_condition = '';
      }
      return view('admin.ads.listingTypeSaddlery',compact('get_all_horses_dynamicFields',
                                                          'ad_data',
                                                          'saddlery_type',
                                                          'saddlery_category',
                                                          'saddlery_condition'));
    }
    elseif($request->categoryType == 'property')
    {
      if(!empty($ad_data))
      {
        $property_Bedrooms = ListingDynamicFieldValues::where(['field_id' => 18, 'listing_master_id' => $ad_data->id])
                                                      ->first();
        $property_Bathrooms = ListingDynamicFieldValues::where(['field_id' => 19, 'listing_master_id' => $ad_data->id])                                             ->first();
      }
      else
      {
        $property_Bedrooms = '';
        $property_Bathrooms = '';
      }

      $property_category_array = ['N/A', 'Agistment', 'For lease', 'For sale'];
      return view('admin.ads.listingTypeProperty',compact('get_all_horses_dynamicFields',
                                                          'property_category_array',
                                                          'ad_data',
                                                          'property_Bedrooms',
                                                          'property_Bathrooms'));
    }
    elseif($request->categoryType == "horses")
    {
      if(!empty($ad_data))
      {
        $horses_discipline = ListingDynamicFieldValues::where(['field_id' => 1,
                                                              'listing_master_id' => $ad_data->id])->first();
        $horses_breed_primary = ListingDynamicFieldValues::where(['field_id'=> 2,
                                                              'listing_master_id' => $ad_data->id] )->first();
        $horses_breed_secondary = ListingDynamicFieldValues::where(['field_id'=> 3,
                                                              'listing_master_id' => $ad_data->id] )->first();
        $horses_color = ListingDynamicFieldValues::where(['field_id'=> 4,
                                                              'listing_master_id' => $ad_data->id] )->first();
        $horses_gender = ListingDynamicFieldValues::where(['field_id'=> 5,
                                                              'listing_master_id' => $ad_data->id] )->first();
        $horses_temperament = ListingDynamicFieldValues::where(['field_id'=> 6,
                                                              'listing_master_id' => $ad_data->id] )->first();
        $horses_age = ListingDynamicFieldValues::where(['field_id'=> 7,
                                                              'listing_master_id' => $ad_data->id] )->first();
        $horses_rider_Level = ListingDynamicFieldValues::where(['field_id'=> 8,
                                                              'listing_master_id' => $ad_data->id] )->first();
        $horses_height = ListingDynamicFieldValues::where(['field_id'=> 9,
                                                              'listing_master_id' => $ad_data->id] )->first();
      }
      else
      {
        $horses_discipline = '';
        $horses_breed_primary = '';
        $horses_breed_secondary = '';
        $horses_color = '';
        $horses_gender = '';
        $horses_temperament = '';
        $horses_age = '';
        $horses_rider_Level = '';
        $horses_height = '';
      }
        return view('admin.ads.listingTypeHorses',compact('get_all_horses_dynamicFields',
                                                          'ad_data',
                                                          'horses_discipline',
                                                          'horses_breed_primary',
                                                          'horses_breed_secondary',
                                                          'horses_color',
                                                          'horses_gender',
                                                          'horses_temperament',
                                                          'horses_age',
                                                          'horses_rider_Level',
                                                          'horses_height'));
    }
  }

  public function create_ad(Request $request)
  {
    $slug_url = Str::slug($request->title);
    $is_active = '1';
    $is_approved = '1';
    $is_blocked = '0';
    $new_listing = $this->listing_master->create_new_ad_listing($request, 'admin', $slug_url, $is_active, $is_approved, $is_blocked);
    return $new_listing;
  }

  public function edit_ad(Request $request)
  {
    $current_page = 'edit_ad';
    $ad_data = ListingMaster::where('identification_code', $request->token)->first();
    $all_state = State::get();
    $suburb_list = $this->suburb->get_suburb_list_based_on_state($ad_data->state_id);
    $all_top_categories = TopCategory::get();

    $ad_images = $ad_data->images()->get();
    return view('admin.ads.edit-ad',compact('current_page','ad_data','all_state','ad_images','all_top_categories','suburb_list'));
  }

  public function delete_listing_image(Request $request)
  {
    $get_image = ListingImages::where('id',$request->image_id)->first();
    ListingImages::where('id',$request->image_id)->delete();
    $path = $get_image->image_url.'/'.$get_image->image_name;
    unlink(public_path($path));
  }

  public function ad_status_update(Request $request)
  {
    $ad_data = ListingMaster::where('id', $request->ad_id)->first();
    
    if($ad_data->listing_owner()->first()->isActive())
    {
      $FeaturedListing = FeaturedListing::where('listing_master_id', $request->ad_id)->first();
      $LatestListings = LatestListings::where('listing_master_id', $request->ad_id)->first();

      $is_active_status = '';
      $is_blocked_status = '';
      
      if($ad_data->is_active == '0')
      {
        $is_active_status = '1';
        $is_blocked_status = '0';
        $email_response_msg = "Blocked";
      }
      else
      {
        $is_active_status = '0';
        $is_blocked_status = '1';
        $email_response_msg = "Unlocked";
      }

      $ad_data->fill(['is_active' => $is_active_status, 'is_blocked' => $is_blocked_status])->save();
      
      if(!empty($FeaturedListing))
      {
        $FeaturedListing->fill(['is_active' => $is_active_status])->save();
      }
      
      if(!empty($LatestListings))
      {
        $LatestListings->fill(['is_active' => $is_active_status])->save();
      }

      $subj = "Listing " . $ad_data->title . " response";
      $message = "Your listing " . $ad_data->title . "has been " . $email_response_msg;
      $toAddr = $ad_data->listing_owner()->first()->email;      
      $email_response =  $this->sendMail("", $toAddr, $subj, $message);

      return 1;
    }
    elseif(!$ad_data->listing_owner()->first()->isActive())
    {
      return 2;
    }
  }

  public function update_ad(Request $request)
  {
    $ad_data = ListingMaster::where('slug', $request->ad_slug_url)->first();

    $slug_url = Str::slug($request->title);
    $is_active = $ad_data->is_active;
    $is_approved = $ad_data->is_approved;
    $is_blocked = $ad_data->is_blocked;
    $update_listing = $this->listing_master->update_ad_listing($request,'admin', $slug_url, $ad_data, $is_active, $is_approved, $is_blocked);
    return $update_listing;
  }

  public function ads_status_list(Request $request)
  {    
    $ad_status_type = $request->ad_status_type;
    $search_key_word = '';
    if($request->ad_status_type == 'pending')
    {
      $current_page = 'pending_ads';
    }
    elseif($request->ad_status_type == 'approved')
    {
      $current_page = 'approved_ads';
    }
    elseif($request->ad_status_type == 'blocked')
    {
      $current_page = 'blocked_ads';
    }
    elseif($request->ad_status_type == 'reported')
    {
      $current_page = 'reported_ads';
    }

    if($request->ad_status_type == 'pending' || $request->ad_status_type == 'approved')
    {
      // $pending_approved_ads = ListingMaster::select( 'listing_master.id as listing_id',
      //                                         'listing_master.category_id as listing_category_id',
      //                                         'listing_master.title as listing_title',
      //                                         'listing_master.is_active as listing_is_active',
      //                                         'listing_master.is_approved as listing_is_approved',
      //                                         'listing_master.is_blocked as listing_is_blocked',
      //                                         'listing_master.price as listing_price',
      //                                         'listing_master.state_id as state_id',
      //                                         'listing_master.suburb_id as suburb_id',
      //                                         'listing_master.description as listing_description',
      //                                         'listing_master.slug as slug',
      //                                         'listing_master.identification_code as listing_identification_code')
      //                         ->join('users', function($join)
      //                         {
      //                           $join->on('listing_master.user_id','=','users.id');
      //                           $join->where(['users.role' => 'user']);
      //                         })
      //                         ->orderBy('listing_master.id', 'DESC');

      $pending_approved_ads = ListingMaster::where('is_delete', '0')->orderBy('id', 'DESC');

      if($request->ad_status_type == 'pending')
      {
        $pending_approved_ads->where('is_approved', null)->where('is_active', '0')->where('is_delete', '0');
      }
      elseif($request->ad_status_type == 'approved')
      {
        $pending_approved_ads->where('is_active', '1')->where('is_approved', '1');
      }

      if(isset($request->search) && !empty($request->search))
      {
        $search_key_word = $request->search;
        $pending_approved_ads->where(function ($query) use ($search_key_word) {
                                  $query->orWhere('title', 'LIKE', "%{$search_key_word}%");
                                  $query->orWhere('description', 'LIKE', "%{$search_key_word}%");
                                  $query->orWhere('ad_id', 'LIKE', "%{$search_key_word}%");
                                  $query->orWhere('item_show_type', 'LIKE', "%{$search_key_word}%");
                                });                                
      }

      $pending_approved_ads = $pending_approved_ads->paginate(10);

      return view('admin.ads.pending_approved_ads',compact('current_page',
                                                           'pending_approved_ads',
                                                           'ad_status_type',
                                                           'search_key_word'));
    }
    elseif($request->ad_status_type == 'blocked')
    {
      $block_repoted_ads = ListingMaster::select('listing_master.id as listing_id',
                                              'listing_master.category_id as listing_category_id',
                                              'listing_master.title as listing_title',
                                              'listing_master.price as listing_price',
                                              'listing_master.state_id as state_id',
                                              'listing_master.suburb_id as suburb_id',
                                              'listing_master.description as listing_description',
                                              'listing_master.identification_code as listing_identification_code',
                                              'listing_master.is_active as is_active',
                                              'listing_master.slug as slug_url',
                                              'listing_master.item_show_type as item_show_type')
                                          ->where(['is_active'=> '0','is_delete'=> '0','is_approved' => '1']);

      if(isset($request->search) && !empty($request->search))
      {
        $search_key_word = $request->search;
        $block_repoted_ads->where(function ($query) use ($search_key_word) {
                                  $query->orWhere('listing_master.title', 'LIKE', "%{$search_key_word}%");
                                  $query->orWhere('listing_master.description', 'LIKE', "%{$search_key_word}%");
                                  $query->orWhere('listing_master.ad_id', 'LIKE', "%{$search_key_word}%");
                                  $query->orWhere('listing_master.item_show_type', 'LIKE', "%{$search_key_word}%");
                                });                                
      }

      $block_repoted_ads = $block_repoted_ads->paginate(10);
     
      return view('admin.ads.block_repoted_ads',compact('current_page',
                                                        'block_repoted_ads',
                                                        'ad_status_type',
                                                        'search_key_word'));
    }
    elseif($request->ad_status_type == 'reported')
    {
      $block_repoted_ads = ListingReports::select('listing_master.id as listing_id',
                                              'listing_master.category_id as listing_category_id',
                                              'listing_master.title as listing_title',
                                              'listing_master.price as listing_price',
                                              'listing_master.state_id as state_id',
                                              'listing_master.suburb_id as suburb_id',
                                              'listing_master.description as listing_description',
                                              'listing_master.identification_code as listing_identification_code',
                                              'listing_master.is_active as is_active',
                                              'listing_master.is_delete as is_delete',
                                              'listing_master.slug as slug_url',
                                              'listing_master.item_show_type as item_show_type')
                                          ->where('listing_master.is_delete','=', '0')
                                          ->Join('listing_master','listing_master.id','=','listing_reports.listing_master_id')
                                          ->groupBy('listing_reports.listing_master_id')
                                          ->orderBy('listing_reports.created_at', 'DESC');
      if(isset($request->search) && !empty($request->search))
      {
        $search_key_word = $request->search;
        $block_repoted_ads->where(function ($query) use ($search_key_word) {
                                  $query->orWhere('listing_master.title', 'LIKE', "%{$search_key_word}%");
                                  $query->orWhere('listing_master.description', 'LIKE', "%{$search_key_word}%");
                                  $query->orWhere('listing_master.ad_id', 'LIKE', "%{$search_key_word}%");
                                  $query->orWhere('listing_master.item_show_type', 'LIKE', "%{$search_key_word}%");
                                });                                
      }

      $block_repoted_ads = $block_repoted_ads->paginate(10);

      return view('admin.ads.block_repoted_ads',compact('current_page',
                                                        'block_repoted_ads',
                                                        'ad_status_type',
                                                        'search_key_word'));
    }    
  }

  public function approved_reject_ad(Request $request)
  {
    $current_page = 'pending_ads';
    $ad_data = ListingMaster::where('identification_code', $request->ad_id)->firstOrFail();
    
    if($request->status == 'approved')
    {
      $is_approved = '1';
      $email_response_msg = "Approved";
      $ad_data->fill([
        'is_active' => '1',
        'is_approved' => $is_approved,
        'approval_dt' => Carbon::now()->toDateTimeString()
      ])->save();
    }
    else
    {
      $is_approved = '0';
      $email_response_msg = "Decline";
      $ad_data->fill([
        'is_approved' => $is_approved,
        'approval_dt' => Carbon::now()->toDateTimeString()
      ])->save();
    }

    $ad_data->fill([
      'is_approved' => $is_approved,
      'approval_dt' => Carbon::now()->toDateTimeString()
    ])->save();

    $subj = "Listing " . $ad_data->title . " response";
    $message = "Your listing " . $ad_data->title . "has been " . $email_response_msg;
    $toAddr = $ad_data->listing_owner()->first()->email;      
    $email_response =  $this->sendMail("", $toAddr, $subj, $message);

    return $is_approved;
  }

  public function ad_all_reports(Request $request)
  {
    $current_page = 'reported_ads';
    $ad_data = ListingMaster::where('identification_code', $request->ad_id)->firstOrFail();
    $all_reports = ListingReports::where('listing_master_id','=',$ad_data->id)
                                  ->orderBy('created_at', 'DESC')
                                  ->paginate(10);

    return view('admin.ads.ad_all_reports',compact('current_page','all_reports'));
  }

  public function un_blocked_ads(Request $request)
  {
    $blockstatus = '';
    if($request->status == 'unblock'){
      $blockstatus = '0';
    }
    else{
      $blockstatus = '1';
    }
    
    $ad_data = ListingMaster::where('identification_code', $request->ad_id)->update(['is_blocked' => $blockstatus]);

    return redirect('admin/ads/blocked');
  }

  public function delete_ad(Request $request)
  {
    $ad_data = ListingMaster::where('identification_code', $request->ad_token)->first();
    $ad_data->is_delete = '1';
    $ad_data->save();
    
    $subj = "Listing " . $ad_data->title . " Deleted";
    $message = "Your listing " . $ad_data->title . "has been Deleted by horseyard admin";
    if(empty($ad_data->user_id) || $ad_data->user_id == 0) {
      $toAddr = Auth()->user()->email; 
    } else {
      $toAddr = $ad_data->listing_owner()->first()->email; 
    }
    $email_response =  $this->sendMail("", $toAddr, $subj, $message);
  }
}
