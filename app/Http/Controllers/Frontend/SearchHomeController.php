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

class SearchHomeController extends Controller
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
    $this->listing_master = $listing_master;
    $this->listing_meta = $listing_meta;

    $searchParams = session('searchParams');
    $this->sortingMethod = $this->getSortingMethod();
    $this->perPageCnt = $this->getPerPageResultCount();

    $this->master_query = "['is_active' => '1', 'is_approved' => '1', 'is_delete' => '0']";
    $this->joinQuery = "'listing_dynamic_field_values', 'listing_dynamic_field_values.listing_master_id','=','listing_master.id'";
    $this->general_search_result = ListingMaster::select(
      'listing_master.id as listing_id',
      'listing_master.category_id as listing_category_id',
      'listing_master.title as listing_title',
      'listing_master.price as listing_price',
      'listing_master.state_id as state_id',
      'listing_master.suburb_id as suburb_id',
      'listing_master.description as listing_description',
      'listing_master.identification_code as listing_identification_code',
      'listing_master.slug as slug_url',
      'listing_master.ad_id as ad_id',
      'listing_master.item_show_type as item_show_type',
      'listing_master.featured_image_url as featured_image_url'
    )
      ->where(['is_active' => '1', 'is_approved' => '1', 'is_delete' => '0']);

    $this->search_params = $searchParams;
  }

  public function generateQueryURL()
  {
    $searchParams = session('searchParams');

    if (!isset($searchParams->top_category)) {
      $searchParams->top_category = "horses";
    }
    else {
      $top_category = $searchParams->top_category;
    }

    $query_url = '';

    $query_url .= $top_category;

    /*horses*/
    if (!empty($searchParams->selectedDiscipline)) {
      $search_discipline_DynamicField_values = DynamicFieldValues::whereIn('id', $searchParams->selectedDiscipline)->pluck('slug')->toArray();
      $query_url .= '-' . implode(".", $search_discipline_DynamicField_values);
    }

    if (!empty($searchParams->selectedColor)) {
      $search_color_DynamicField_values = DynamicFieldValues::whereIn('id', $searchParams->selectedColor)->pluck('slug')->toArray();
      $query_url .= '-' . implode("-", $search_color_DynamicField_values);
    }

    if (!empty($searchParams->selectedGender)) {
      $search_gender_DynamicField_values = DynamicFieldValues::whereIn('id', $searchParams->selectedGender)->pluck('slug')->toArray();
      $query_url .= '-' . implode("-", $search_gender_DynamicField_values);
    }

    if (!empty($searchParams->selectedAge)) {
      $search_age_DynamicField_values = DynamicFieldValues::whereIn('id', $searchParams->selectedAge)->pluck('slug')->toArray();
      $query_url .= '-' . implode("-", $search_age_DynamicField_values);
    }

    if (!empty($searchParams->selectedRiderLevel)) {
      $search_rider_Level_DynamicField_values = DynamicFieldValues::whereIn('id', $searchParams->selectedRiderLevel)->pluck('slug')->toArray();
      $query_url .= '-' . implode("-", $search_rider_Level_DynamicField_values);
    }

    if (!empty($searchParams->selectedHeight)) {
      $search_height_DynamicField_values = DynamicFieldValues::whereIn('id', $searchParams->selectedHeight)->pluck('slug')->toArray();
      $query_url .= '-' . implode("-", $search_height_DynamicField_values);
    }

    if (!empty($searchParams->selectedBreed)) {
      $search_breed_primary_DynamicField_values = DynamicFieldValues::whereIn('id', $searchParams->selectedBreed)->pluck('slug')->toArray();
      $query_url .= '-' . implode("-", $search_breed_primary_DynamicField_values);
    }

    /*transport*/
    if (!empty($searchParams->selectedTransportType)) {
      $search_transtype_DynamicField_values = DynamicFieldValues::whereIn('id', $searchParams->selectedTransportType)->pluck('slug');
      $query_url .= '-' . implode("-", $search_transtype_DynamicField_values);
    }

    if (!empty($searchParams->selectedHorseNumber)) {
      $search_no_of_horses_DynamicField_values = DynamicFieldValues::whereIn('id', $searchParams->selectedHorseNumber)->pluck('slug');
      $query_url .= '-' . implode("-", $search_no_of_horses_DynamicField_values);
    }

    if (!empty($searchParams->selectedRampLocation)) {
      $search_ramplocation_DynamicField_values = DynamicFieldValues::whereIn('id', $searchParams->selectedRampLocation)->pluck('slug');
      $query_url .= '-' . implode("-", $search_ramplocation_DynamicField_values);
    }

    /*saddlery*/
    if (!empty($searchParams->selectedSaddleryType)) {
      $search_saddlerytype_DynamicField_values = DynamicFieldValues::whereIn('id', $searchParams->selectedSaddleryType)->pluck('slug');
      $query_url .= '-' . implode("-", $search_saddlerytype_DynamicField_values);
    }

    if (!empty($searchParams->selectedSaddleryCategory)) {
      $search_saddlerycategory_DynamicField_values = DynamicFieldValues::whereIn('id', $searchParams->selectedSaddleryCategory)->pluck('slug');
      $query_url .= '-' . implode("-", $search_saddlerycategory_DynamicField_values);
    }

    if (!empty($searchParams->selectedSaddleryCondition)) {
      $search_saddlerycondition_DynamicField_values = DynamicFieldValues::whereIn('id', $searchParams->selectedSaddleryCondition)->pluck('slug');
      $query_url .= '-' . implode("-", $search_saddlerycondition_DynamicField_values);
    }

    /*property*/
    if (!empty($searchParams->selectedPropertyCategory)) {
      array_push($all_DynamicField_values, $searchParams->selectedPropertyCategory);
      $query_url .= '-' . implode("-", \Str::slug($searchParams->selectedPropertyCategory));
    }

    if (!empty($searchParams->selectedBedrooms)) {
      $search_property_Bedrooms_DynamicField_values = DynamicFieldValues::whereIn('id', $searchParams->selectedBedrooms)->pluck('slug');
      $query_url .= '-' . implode("-", $search_property_Bedrooms_DynamicField_values);
    }

    if (!empty($searchParams->selectedBathrooms)) {
      $search_property_Bathrooms_DynamicField_values = DynamicFieldValues::whereIn('id', $searchParams->selectedBathrooms)->pluck('slug');
      $query_url .= '-' . implode("-", $search_property_Bathrooms_DynamicField_values);
    }

    if (!empty($searchParams->selectedLocation)) {
      $state = State::whereIn('id', $request->search_state)->get();
      foreach ($searchParams->selectedLocation as $stId) {
        $state = State::find($stId);
        $query_url .= '-' . \Str::slug($state->state_name) . '-' . $state->state_code;
      }
    }
    return $query_url;
  }

  public function category_quicksearch(Request $request)
  {
    $all_DynamicField_values = [];
    
    $searchParams = session('searchParams');
    if (empty($searchParams)) {
      $searchParams = new SearchParams;
    }
    else {
      $searchParams->resetSearchTerms();
    }

    $query_url = '';

    if (isset($request->category)) {
      $top_category = $request->category;
      $searchParams->top_category = $top_category;
    }

    $query_url .= 'category='.$top_category;

    $request_count =0;
    $request_type = '';
    $request_value = '';

    /*Horases*/
    if ($top_category == 'horses') {
      if (isset($request->sex)) {
        array_push($searchParams->selectedGender, $request->sex);

        $sex_DynamicField_values = DynamicFieldValues::where('id', $request->sex)->pluck('field_value');
        $sex_DynamicField_slug = DynamicFieldValues::where('id', $request->sex)->pluck('slug')->toArray();
        array_push($all_DynamicField_values, $sex_DynamicField_values);

        $tStr = implode (DELIM_URL, $sex_DynamicField_slug);
        $request_count += count($sex_DynamicField_slug);
        $query_url .= DELIM_ADD.'gender='.$tStr ;
        if(count($sex_DynamicField_slug)==1){
          $request_value = $tStr;
          $request_type = 'field-sex';
        }
      }
      if (isset($request->breed)) {
        array_push($searchParams->selectedBreed, $request->breed);

        $breed_DynamicField_values = DynamicFieldValues::where('id', $request->breed)->pluck('field_value');
        $breed_DynamicField_slug = DynamicFieldValues::where('id', $request->breed)->pluck('slug')->toArray();
        array_push($all_DynamicField_values, $breed_DynamicField_values);


        $tStr = implode (DELIM_URL, $breed_DynamicField_slug);
        $query_url .= DELIM_ADD.'breed='.$tStr ;
          $request_count += count($breed_DynamicField_slug);
          if(count($breed_DynamicField_slug)==1){
            $request_value = $tStr;
            $request_type = 'horses-for-sale';
          }
      }
      if (isset($request->discipline)) {
        array_push($searchParams->selectedDiscipline, $request->discipline);

        $discipline_DynamicField_values = DynamicFieldValues::where('id', $request->discipline)->pluck('field_value');
        $discipline_DynamicField_slug = DynamicFieldValues::where('id', $request->discipline)->pluck('slug')->toArray();
        array_push($all_DynamicField_values, $discipline_DynamicField_values);

        $tStr = implode (DELIM_URL, $discipline_DynamicField_slug);

        $query_url .= DELIM_ADD.'discipline='.$tStr;
        $request_count += count($discipline_DynamicField_slug);
        if(count($discipline_DynamicField_slug)==1){
          $request_value = $tStr;
          $request_type = 'horses-for-sale';
        }
      }
    }

    /*Transport*/
    if ($top_category == 'transport') {

      if (isset($request->transport_type)) {
        array_push($searchParams->selectedTransportType, $request->transport_type);

        $transport_type_DynamicField_values = DynamicFieldValues::where('id', $request->transport_type)->pluck('field_value');
        $transport_type_DynamicField_slug = DynamicFieldValues::where('id', $request->transport_type)->pluck('slug')->toArray();
        array_push($all_DynamicField_values, $transport_type_DynamicField_values);

        $tStr = implode (DELIM_URL, \Arr::flatten($transport_type_DynamicField_slug));
        $query_url .= DELIM_ADD.'transtype='.$tStr ;
        $request_count += count($transport_type_DynamicField_slug);
        if(count($transport_type_DynamicField_slug)==1){
          $request_value = $tStr;
          $request_type = 'transport-for-horses';
        }
      }

      if (isset($request->transport_horse_number)) {
        array_push($searchParams->selectedHorseNumber, $request->transport_horse_number);

        $transport_horse_number_DynamicField_values = DynamicFieldValues::where('id', $request->transport_horse_number)->pluck('field_value');
        $transport_horse_number_DynamicField_slug = DynamicFieldValues::where('id', $request->transport_horse_number)->pluck('slug')->toArray();

        array_push($all_DynamicField_values, $transport_horse_number_DynamicField_values);

        $tStr = implode (DELIM_URL, \Arr::flatten($transport_horse_number_DynamicField_slug));
        $query_url .= DELIM_ADD.'no_of_horse='.$tStr ;
        $request_count += count($transport_horse_number_DynamicField_slug);
        if(count($transport_horse_number_DynamicField_slug)==1){
          $request_value = $tStr;
          $request_type = 'transport-for-horses';
        }
      }

      if (isset($request->transport_ramp_location)) {
        array_push($searchParams->selectedRampLocation, $request->transport_ramp_location);

        $transport_ramp_location_DynamicField_values = DynamicFieldValues::where('id', $request->transport_ramp_location)->pluck('field_value');
        $transport_ramp_location_DynamicField_slug = DynamicFieldValues::where('id', $request->transport_ramp_location)->pluck('slug')->toArray();

        array_push($all_DynamicField_values, $transport_ramp_location_DynamicField_values);

        $tStr = implode (DELIM_URL, \Arr::flatten($transport_ramp_location_DynamicField_slug));
        $query_url .= DELIM_ADD.'ramp_location='.$tStr ;
        $request_count += count($transport_ramp_location_DynamicField_slug);
        if(count($transport_ramp_location_DynamicField_slug)==1){
          $request_value = $tStr;
          $request_type = 'transport-for-horses';
        }
      }

    }

    /*Saddlery*/
    if ($top_category == 'saddlery') {

      if (isset($request->saddlery_type)) {
        $saddlery_type = $request->saddlery_type;
        array_push($searchParams->selectedSaddleryType, $saddlery_type);

        $all_saddlery_type_DynamicField_values = DynamicFieldValues::where('id', $request->saddlery_type)->pluck('field_value');
        $all_saddlery_type_DynamicField_slug = DynamicFieldValues::where('id', $request->saddlery_type)->pluck('slug')->toArray();
        array_push($all_DynamicField_values, $all_saddlery_type_DynamicField_values);

        $tStr = implode (DELIM_URL, \Arr::flatten($all_saddlery_type_DynamicField_slug));
        $request_count += count($all_saddlery_type_DynamicField_slug);
        $query_url .= DELIM_ADD.'saddlery_type='.$tStr ;
        if(count($all_saddlery_type_DynamicField_slug)==1){
          $request_value = $tStr;
          $request_type = 'saddlery-type';
        }
      }

      if (isset($request->saddlery_category)) {
        $saddlery_category = $request->saddlery_category;
        array_push($searchParams->selectedSaddleryCategory, $saddlery_category);

        $saddlery_category_DynamicField_values = DynamicFieldValues::where('id', $request->saddlery_category)->pluck('field_value');
        $saddlery_category_DynamicField_slug = DynamicFieldValues::where('id', $request->saddlery_category)->pluck('slug')->toArray();
        array_push($all_DynamicField_values, $saddlery_category_DynamicField_values);

        $tStr = implode (DELIM_URL, \Arr::flatten($saddlery_category_DynamicField_slug));
        $query_url .= DELIM_ADD.'saddlery_cat='.$tStr ;
        $request_count += count($saddlery_category_DynamicField_slug);
        if(count($saddlery_category_DynamicField_slug)==1){
          $request_value = $tStr;
          $request_type = 'saddlery-and-tack';
        }
      }
    }

    /*Property*/
    if ($top_category == 'property') {

      // if ($request->property_category == 'all_property_category') {
      //     $all_property_category = ['N/A', 'Agistment', 'For lease', 'For sale'];
      //     $search_result = $search_result->whereIn('property_category', $all_property_category);
      // } else {
      //     $search_result = $search_result->where('property_category', $request->property_category);
      // }
      if (isset($request->property_category)) {
        //$search_result = $search_result->where('property_category', $request->property_category);
        array_push($searchParams->selectedPropertyType, $request->property_category);
        array_push($all_DynamicField_values, $request->property_category);

        $tStr = \Str::slug($request->property_category);
        $query_url .= DELIM_ADD.'property_type='.$tStr;
        $request_count += 1;
        $request_value = $tStr;
        $request_type = 'property-for-sale';
      }

      if (isset($request->property_Bathrooms)) {
        $property_Bathrooms = $request->property_Bathrooms;
        array_push($searchParams->selectedBathrooms, $property_Bathrooms);

        $property_Bathrooms_DynamicField_values = DynamicFieldValues::where('id', $request->property_Bathrooms)->pluck('field_value');
        $property_Bathrooms_DynamicField_slug = DynamicFieldValues::where('id', $request->property_Bathrooms)->pluck('slug')->toArray();
        array_push($all_DynamicField_values, $property_Bathrooms_DynamicField_values);

        $tStr = implode (DELIM_URL, \Arr::flatten($property_Bathrooms_DynamicField_slug));
        $query_url .= DELIM_ADD.'property_bathroom='.$tStr ;
        $request_count += count($property_Bathrooms_DynamicField_slug);
        if(count($property_Bathrooms_DynamicField_slug)==1){
          $request_value = $tStr;
          $request_type = 'property-for-sale';
        }
      }
      if (isset($request->property_Bedrooms)) {
        $property_Bedrooms = $request->property_Bedrooms;
        array_push($searchParams->selectedBedrooms, $property_Bedrooms);

        $property_Bedrooms_DynamicField_values = DynamicFieldValues::where('id', $request->property_Bedrooms)->pluck('field_value');
        $property_Bedrooms_DynamicField_slug = DynamicFieldValues::where('id', $request->property_Bedrooms)->pluck('slug')->toArray();
        array_push($all_DynamicField_values, $property_Bedrooms_DynamicField_values);

        $tStr = implode (DELIM_URL, \Arr::flatten($property_Bedrooms_DynamicField_slug));
        $query_url .= DELIM_ADD.'property_bedroom='.$tStr ;
        $request_count += count($property_Bedrooms_DynamicField_slug);
        if(count($property_Bedrooms_DynamicField_slug)==1){
          $request_value = $tStr;
          $request_type = 'property-for-sale';
        }
      }
    }

    if (isset($request->state)) {
      $state = State::where('id', $request->state)->first();
      array_push($searchParams->selectedLocation, $request->state);

      $query_url .= DELIM_ADD.'location='.$state->state_code;
      $request_count += 1;
      $request_value = strtolower($state->state_code);
      $request_type = 'horses-for-sale/location';
    //$search_result = $this->general_search_result->where('listing_master.state_id', $request->state);
    }

    if (isset($request->price_min) || isset($request->price_max)) {
      if($request_count == 1)
      {
        $request_count++;
      }
      if (empty($request->price_min)) {
        //$min_price = ListingMaster::min('price');
        $searchParams->minPrice = -1;
        $min_price = -1;
      }
      else {
        $min_price = $request->price_min;
        $searchParams->minPrice = $min_price;
      }
      if (empty($request->price_max)) {
        //$max_price = ListingMaster::max('price');
        $searchParams->maxPrice = -1;
        $max_price = -1;
      }
      else {
        $max_price = $request->price_max;
        $searchParams->maxPrice = $max_price;
      }
      $query_url .= DELIM_ADD.'min_price='.$min_price.DELIM_ADD.'max_price='.$max_price;
    //$query_url .= '-min_price-'.$min_price.'-max_price-'.$max_price;
    // $search_result = $this->general_search_result->whereBetween('listing_master.price', [$min_price, $max_price]);
    }

    if (empty($request->keyword_txt)) {
      $searchParams->keywordTxt = '';
    }
    else {
      if($request_count == 1)
      {
        $request_count++;
      }
      $searchParams->keywordTxt = $request->keyword_txt;
      $query_url .= DELIM_ADD.'keyword_or_sn='.$request->keyword_txt;
    }

    session(['searchParams' => $searchParams]);
    session(['requestSource' => 'leftFilter']);

    if($request_count==1){
      return \Redirect::to($request_type.'/'.$request_value);
    }
    //return;
    return \Redirect::to('search-listing-classifieds?'.$query_url);
    //return \Redirect::to('search-results/' . trim($query_url, '-'));

  // $search_result = $this->general_search_result->distinct()->paginate($perpage);

  // session(['searchParams' => $searchParams]);

  // $all_DynamicField_values = \Arr::flatten($all_DynamicField_values);

  // return view('front.listing_results', compact(
  //     'listing',
  //     'sortby',
  //     'perpage',
  //     'search_result'
  // ));
  }


  private function getSortingMethod()
  {
    $sortMethod = session('sortMethod');
    if (empty($sortMethod)) {
      $sortMethod = "price_low_to_high";
      session(['sortMethod' => $sortMethod]);
    }
  }

  private function getPerPageResultCount()
  {
    $perPageCnt = session('perPageCnt');
    if (empty($perPageCnt)) {
      $perPageCnt = 20;
      session(['perPageCnt' => $perPageCnt]);
    }
  }
}
