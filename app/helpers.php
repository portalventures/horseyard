<?php

use App\Models\User;

use App\Models\TopCategory;
use App\Models\CategoryDynamicFields;
use App\Models\DynamicFieldValues;

use App\Models\ListingMaster;
use App\Models\ListingDynamicFieldValues;
use App\Models\ListingImages;
use App\Models\ListingReports;
use App\Models\ContactCustomerWishList;

use App\Models\State;
use App\Models\Suburb;
use App\Models\FeaturedListing;
use App\Models\LatestListings;
use App\Models\BlogListings;
use App\Models\Blog;
use App\Models\CustomerMessage;

function get_to_category_name($category_id = '')
{
    $category = TopCategory::where('id', $category_id)->first();
    if (!empty($category)) {
        return $category->category_name;
    } else {
        return '';
    }
}

function get_listing_ad_id($listing_master_id = '')
{
    $listObj = ListingMaster::find($listing_master_id);
    if (!empty($listObj)) {
        if (empty($listObj->ad_id)) {
            return '#' . $listing_master_id;
        } else {
            return $listObj->ad_id;
        }
    } else {
        return '#' . $listing_master_id;
    }
}

function get_listing_first_image($listing_master_id = '')
{
    $listing_image = ListingImages::where('listing_master_id', $listing_master_id)->first();
    if (!empty($listing_image)) {
        return $listing_image;
    } else {
        return '';
    }
}

function get_state_name($state_id = '')
{
    $state = State::where('id', $state_id)->first();
    if (!empty($state)) {
        return $state->state_name;
    } else {
        return '';
    }
}

function get_state_short_code($state_id = '')
{
    $state = State::where('id', $state_id)->first();
    if (!empty($state)) {
        return $state->state_code;
    } else {
        return '';
    }
}

function getStateByCode($state_cd = '')
{
    $state = State::where('state_code', $state_cd)->first();
    if (!empty($state)) {
        return $state;
    } else {
        return null;
    }
}

function getStateListByArrCode($state_cd)
{
    $stateLst = State::whereIn('state_code', $state_cd)->get();
    $arrStateIds = [];
    
    if (!empty($stateLst)) {
        foreach($stateLst as $sObj) {
            
            array_push($arrStateIds, $sObj->id);
        }
      return $arrStateIds;
    } else {
      return $arrStateIds;
    }
}

function get_suburb_name($suburb_id = '')
{
  $suburb = Suburb::where('id', $suburb_id)->first();
  if (!empty($suburb)) {
      return $suburb->suburb_name;
  } else {
      return '';
  }
}

function get_Suburb_short_code($suburb_id = '')
{
    $suburb = Suburb::where('id', $suburb_id)->first();
    if (!empty($suburb)) {
        return $suburb->suburb_code;
    } else {
        return '';
    }
}

function dynamic_field_data($dynamic_field_id = '')
{
    $dynamic_field = DynamicFieldValues::where('id', $dynamic_field_id)->first();
    if (!empty($dynamic_field)) {
      return $dynamic_field->field_value;
    } else {
      return '';
    }
}

function dynamic_field_slug($dynamic_field_id = '')
{
    $dynamic_field = DynamicFieldValues::where('id', $dynamic_field_id)->first();
    if (!empty($dynamic_field)) {
      return $dynamic_field->slug;
    } else {
      return '';
    }
}

function getDynamicFieldUsingSlug($dynamic_field_slug = '')
{
    $dynamic_field = DynamicFieldValues::where('slug', $dynamic_field_slug)->first();
    if (!empty($dynamic_field)) {
      return $dynamic_field->id;
    } else {
      return 0;
    }
}

function getDynamicFieldUsingSlugArr_Breed_Primary($dynamic_field_slug)
{
    $dynamic_fields = DynamicFieldValues::where('field_id', 2)
                                        ->whereIn('slug', $dynamic_field_slug)
                                        ->get();
    $arrDynamicIds = [];
    
    if (!empty($dynamic_fields)) {
      foreach($dynamic_fields as $dObj) {            
        array_push($arrDynamicIds, $dObj->id);
      }        
      return $arrDynamicIds;
    } else {
      return $arrDynamicIds;
    }
}

function getDynamicFieldUsingSlugArr($dynamic_field_slug)
{
    $dynamic_fields = DynamicFieldValues::whereIn('slug', $dynamic_field_slug)->get();
    $arrDynamicIds = [];
    
    if (!empty($dynamic_fields)) {
      foreach($dynamic_fields as $dObj) {            
        array_push($arrDynamicIds, $dObj->id);
      }        
      return $arrDynamicIds;
    } else {
      return $arrDynamicIds;
    }
}

function getListingDynamicFieldUsingIds($lstIds,$count_filters=1)
{
  $lstIds = \Arr::flatten($lstIds);

  $listingDynObjs = ListingDynamicFieldValues::select('listing_master_id')
                                             ->whereIn('dynamic_field_id', $lstIds)
                                             ->groupBy('listing_master_id')
                                             //->havingRaw('COUNT(DISTINCT dynamic_field_id) > ?',[$count_filters])
                                             ->get();  
  $arrListingDynIds = [];
  
  if (!empty($listingDynObjs)) {
    foreach($listingDynObjs as $dObj) {            
      array_push($arrListingDynIds, $dObj->listing_master_id);
    }
    return $arrListingDynIds;
  } else {
    return $arrListingDynIds;
  }
}

function getListingObj($listingId)
{
  return ListingMaster::find($listingId);
}

function admin_get_pending_approved_blocked_ads_count($type = '')
{
    $pending_approved_ads_count = ListingMaster::where('is_delete', '0');
    if ($type == 'pending') {
        $pending_approved_ads_count->where('is_approved', null);
    } elseif ($type == 'approved') {
        $pending_approved_ads_count->where(['is_approved' => '1', 'is_active' => '1', 'is_delete' => '0']);
    } elseif ($type == 'blocked') {
        $pending_approved_ads_count->where(['is_active' => '0', 'is_approved' => '1', 'is_delete' => '0']);
    }

    $pending_approved_ads_count = $pending_approved_ads_count->count();

    return $pending_approved_ads_count;
}

function admin_get_reported_ads_count($type = '')
{
    $blocked_ads_count = ListingReports::where(['is_active' => '1', 'is_delete' => '0'])
        ->Join('listing_master', 'listing_master.id', '=', 'listing_reports.listing_master_id')
        ->groupBy('listing_reports.listing_master_id')
        ->orderBy('listing_reports.created_at', 'DESC')
        ->pluck('listing_reports.listing_master_id');

    return $blocked_ads_count->count();
}

function get_category_dynamic_details_for_search($listing_token = '', $category_id = '')
{
    $listing = ListingMaster::where('identification_code', $listing_token)->first();
    // ListingDynamicFieldValues
    $default = new ListingDynamicFieldValues();
    if ($category_id == 1) /* horses */ {
        $obj = [
            'horses_discipline' => ListingDynamicFieldValues::where([
                'field_id' => 1,
                'listing_master_id' => $listing->id
            ])->first() ?? $default,
            'horses_breed_primary' => ListingDynamicFieldValues::where([
                'field_id' => 2,
                'listing_master_id' => $listing->id
            ])->first() ?? $default,
            'horses_breed_secondary' => ListingDynamicFieldValues::where([
                'field_id' => 3,
                'listing_master_id' => $listing->id
            ])->first() ?? $default,
            'horses_color' => ListingDynamicFieldValues::where([
                'field_id' => 4,
                'listing_master_id' => $listing->id
            ])->first() ?? $default,
            'horses_gender' => ListingDynamicFieldValues::where([
                'field_id' => 5,
                'listing_master_id' => $listing->id
            ])->first() ?? $default,
            'horses_temperament' => ListingDynamicFieldValues::where([
                'field_id' => 6,
                'listing_master_id' => $listing->id
            ])->first() ?? $default,
            'horses_age' => ListingDynamicFieldValues::where([
                'field_id' => 7,
                'listing_master_id' => $listing->id
            ])->first() ?? $default,
            'horses_rider_Level' => ListingDynamicFieldValues::where([
                'field_id' => 8,
                'listing_master_id' => $listing->id
            ])->first() ?? $default,
            'horses_height' => ListingDynamicFieldValues::where([
                'field_id' => 9,
                'listing_master_id' => $listing->id
            ])->first() ?? $default
        ];
        return $obj;
    } elseif ($category_id == 2) /* transport */ {
        return [
            'transport_type' => ListingDynamicFieldValues::where(['field_id' => 10, 'listing_master_id' => $listing->id])->first() ?? $default,
            'transport_no_of_horse_to_carry' => ListingDynamicFieldValues::where(['field_id' => 11, 'listing_master_id' => $listing->id])->first() ?? $default,
            'transport_ramp_location' => ListingDynamicFieldValues::where(['field_id' => 12, 'listing_master_id' => $listing->id])->first() ?? $default,
            'transport_axles' => ListingDynamicFieldValues::where(['field_id' => 13, 'listing_master_id' => $listing->id])->first() ?? $default,
            'transport_registration_state' => ListingDynamicFieldValues::where(['field_id' => 14, 'listing_master_id' => $listing->id])->first() ?? $default
        ];
    } elseif ($category_id == 3) /* saddlery */ {
        return [
            'saddlery_type' => ListingDynamicFieldValues::where(['field_id' => 15, 'listing_master_id' => $listing->id])->first() ?? $default,
            'saddlery_category' => ListingDynamicFieldValues::where(['field_id' => 16, 'listing_master_id' => $listing->id])->first() ?? $default,
            'saddlery_condition' => ListingDynamicFieldValues::where(['field_id' => 17, 'listing_master_id' => $listing->id])->first() ?? $default
        ];
    } elseif ($category_id == 4) /* property */ {
        return [
            'property_Bedrooms' => ListingDynamicFieldValues::where(['field_id' => 18, 'listing_master_id' => $listing->id])
                ->first() ?? $default,
            'property_Bathrooms' => ListingDynamicFieldValues::where(['field_id' => 19, 'listing_master_id' => $listing->id])->first() ?? $default
        ];
    }
}

function check_listing_exist_in_dynamic_detail($dynamic_field_id = '')
{
    $dynamic_field_count = ListingDynamicFieldValues::where('dynamic_field_id', $dynamic_field_id)->count();
    return $dynamic_field_count;
}

function check_state_exist_in_listing($state_id = '')
{
    $dynamic_field_count = ListingMaster::where('state_id', $state_id)->count();
    return $dynamic_field_count;
}

function get_listing_report_count($listing_id = '')
{
    $listing_count = ListingReports::where('listing_master_id', $listing_id)->count();
    return $listing_count;
}

function user_listing_present_in_wishlist($user_id = '', $listing_id = '')
{
    $listing_count = ContactCustomerWishList::where(['user_id' => $user_id, 'listing_master_id' => $listing_id])->count();
    return $listing_count;
}

function getInboxNewMsgCount()
{
  $userId = Auth()->user()->id;
  $cnt =  CustomerMessage::leftJoin('block_user', function ($cnt) use ($userId) {
          $cnt->where('customer_messages.to_user_id', '=', $userId)
          ->where(function ($cnt) {
              $cnt->where(function ($cnt) {
                  $cnt->on('block_user.from_user', '=', 'customer_messages.to_user_id')
                      ->on('block_user.to_user', '=', 'customer_messages.from_user_id');
              })
              ->orWhere(function ($cnt) {
                  $cnt->on('block_user.from_user', '=', 'customer_messages.from_user_id')
                      ->on('block_user.to_user', '=', 'customer_messages.to_user_id');
              });
          });
        })
        ->whereNull('block_user.id')
        ->where('to_user_id', $userId)
        ->where("is_read", "=", "0")->count();

    return $cnt;
}

function generate_ad_attribute_view_url($category_details = '', $listing_token = '' ,$category_id = '')
{
    $listing = ListingMaster::where('identification_code', $listing_token)->first();
    $location = get_state_short_code($listing->state_id).'-'.\Str::Slug(get_suburb_name($listing->suburb_id));

    $attribute = '';
    $desh = '-';

    if($category_id == 1)
    {
      $horses_discipline = dynamic_field_slug($category_details['horses_discipline']->dynamic_field_id);
      $horses_breed_primary = dynamic_field_slug($category_details['horses_breed_primary']->dynamic_field_id);
      $horses_breed_secondary = dynamic_field_slug($category_details['horses_breed_secondary']->dynamic_field_id);
      $horses_color = dynamic_field_slug($category_details['horses_color']->dynamic_field_id);
      $horses_gender = dynamic_field_slug($category_details['horses_gender']->dynamic_field_id);
      $horses_temperament = dynamic_field_slug($category_details['horses_temperament']->dynamic_field_id);
      $horses_age = dynamic_field_slug($category_details['horses_age']->dynamic_field_id);
      $horses_rider_Level = dynamic_field_slug($category_details['horses_rider_Level']->dynamic_field_id);
      $horses_height = dynamic_field_slug($category_details['horses_height']->dynamic_field_id);

      $attribute .= append_attribute($horses_discipline);
      $attribute .= append_attribute($horses_color);
      $attribute .= append_attribute($horses_gender);
      $attribute .= append_attribute($horses_temperament);
      $attribute .= append_attribute($horses_age);
      $attribute .= append_attribute($horses_rider_Level);
      $attribute .= append_attribute($horses_height);
    
      $attribute = substr($attribute, 0, -1);
      return $attribute;
    }
    
    if($category_id == 2)
    {
      $transport_type = dynamic_field_slug($category_details['transport_type']->dynamic_field_id);
      $transport_no_of_horse_to_carry = dynamic_field_slug($category_details['transport_no_of_horse_to_carry']->dynamic_field_id);
      $transport_ramp_location = dynamic_field_slug($category_details['transport_ramp_location']->dynamic_field_id);
      $transport_axles = dynamic_field_slug($category_details['transport_axles']->dynamic_field_id);
      $transport_registration_state = dynamic_field_slug($category_details['transport_registration_state']->dynamic_field_id);
      
      $attribute .=  'type'.'/';
      $attribute .= append_attribute($transport_type);
      $attribute .= append_attribute($transport_no_of_horse_to_carry);
      $attribute .= append_attribute($transport_ramp_location);
      $attribute .= append_attribute($transport_axles);
      $attribute .= append_attribute($transport_registration_state);

      $attribute = substr($attribute, 0, -1);
      return $attribute;
    }

    if($category_id == 3)
    {
      $saddlery_type = dynamic_field_slug($category_details['saddlery_type']->dynamic_field_id);
      $saddlery_category = dynamic_field_slug($category_details['saddlery_category']->dynamic_field_id);
      $saddlery_condition = dynamic_field_slug($category_details['saddlery_condition']->dynamic_field_id);
      
      $attribute .=  'type'.'/';
      $attribute .= append_attribute($saddlery_type);
      $attribute .= append_attribute($saddlery_category);
      $attribute .= append_attribute($saddlery_condition);

      $attribute = substr($attribute, 0, -1);
      return $attribute;
    }
    
    if($category_id == 4)
    { 
      $attribute .=  'type'.'/';
      $attribute .= Str::slug($listing->property_category);
      return $attribute;
    }
}

function generate_location_view_url($listing_token='')
{
  $listing = ListingMaster::where('identification_code', $listing_token)->first();
  $location = get_state_short_code($listing->state_id).'-'.\Str::Slug(get_suburb_name($listing->suburb_id));
  return $location;
}

function append_attribute($dynamic_field = '')
{
  if(!empty($dynamic_field)){
    return $dynamic_field.'-';
  }
  else{
    return '';
  }
}

function create_slug($title,$table_name)
{
  $slug = Str::slug($title);
  $slugCount = count( DB::table($table_name)->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->get());

  return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
}

function update_slug($id,$title,$table_name)
{
  $slug = Str::slug($title);
  
  $allSlugs = DB::table($table_name)->select('slug')->where('slug', 'like', $slug.'%')
              ->where('id', '<>', $id)
              ->get();

  if (! $allSlugs->contains('slug', $slug)){
    return $slug;
  }

  for ($i = 1; $i <= 5000; $i++) {
    $newSlug = $slug.'-'.$i;
    if (! $allSlugs->contains('slug', $newSlug)) {
        return $newSlug;
    }
  }
}

function getDynamicField_HeightIdsArr($min_height = '',$max_height = '')
{
    $min_height_value = '';
    $max_height_value = '';

    $searchParams = session('searchParams');
    $dynamic_min_height = DynamicFieldValues::where('field_id', 9)->min('id');
    $dynamic_max_height = DynamicFieldValues::where('field_id', 9)->max('id');

    if($min_height != '')
    {
      // $min_height_value = $min_height;
      $min_height_value = $searchParams->selectedMinHeight;
    }
    else{
      $min_height_value = $dynamic_min_height;
    }

    if($max_height != '')
    {
      //$max_height_value = $max_height;
      $max_height_value = $searchParams->selectedMaxHeight;
    }
    else{
      $max_height_value = $dynamic_max_height;
    }

    $dynamic_fields = DynamicFieldValues::where('field_id', 9)
                                        ->whereBetween('id', [$min_height_value, $max_height_value])->get();
    
    $arrDynamicIds = [];
    
    if (!empty($dynamic_fields)) {
        foreach($dynamic_fields as $dObj) {            
          array_push($arrDynamicIds, $dObj->id);
        }
      return $arrDynamicIds;
    } else {
      return $arrDynamicIds;
    }
}

function getDynamicField_AgeIdsArr($min_age = '',$max_age = '')
{
    $min_age_value = '';
    $max_age_value = '';
    
    $searchParams = session('searchParams');
    $dynamic_min_age = DynamicFieldValues::where('field_id', 7)->min('id');
    $dynamic_max_age = DynamicFieldValues::where('field_id', 7)->max('id');

    if($min_age != '')
    {
      // $min_age_value = $min_age;
      $min_age_value = $searchParams->selectedMinAge;
    }
    else{
      $min_age_value = $dynamic_min_age;
    }

    if($max_age != '')
    {
      // $max_age_value = $max_age;
      $max_age_value = $searchParams->selectedMaxAge;
    }
    else{
      $max_age_value = $dynamic_max_age;
    }

    $dynamic_fields = DynamicFieldValues::where('field_id', 7)
                                        ->whereBetween('id', [$min_age_value, $max_age_value])->get();
    
    $arrDynamicIds = [];
    
    if (!empty($dynamic_fields)) {
        foreach($dynamic_fields as $dObj) {            
            array_push($arrDynamicIds, $dObj->id);
        }        
      return $arrDynamicIds;
    } else {
      return $arrDynamicIds;
    }
}

function getListingIds_for_keyword_or_sn($keyword_or_sn='')
{
  return ListingMaster::where('listing_master.title', 'like', '%'.$keyword_or_sn.'%')
                      ->orWhere('listing_master.description', 'like', '%'.$keyword_or_sn.'%')
                      ->orWhere('listing_master.ad_id', 'like', '%'.$keyword_or_sn.'%')->pluck('id');
}

function getFieldIds($top_cat_name)
{
  $top_cat = TopCategory::where('category_name',$top_cat_name)->first();
  $field_ids = [];
  if(!empty($top_cat)){
    $field_ids = CategoryDynamicFields::where('category_id',$top_cat->id)->pluck('id');
  }
  return $field_ids;
}