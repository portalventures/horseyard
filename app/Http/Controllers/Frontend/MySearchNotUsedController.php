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
use App\Models\ListingMeta;
use App\Models\FeaturedListing;
use App\Models\LatestListings;
use App\Models\BlogListings;
use App\Models\Blog;
use App\CustomClass\SearchParams;

class MySearchNotUsedController extends Controller
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
    public function search_page_filter(Request $request)
    {
      $searchParams = session('searchParams');
      $searchParams->resetSearchTerms();
      
      if (isset($request->perpage)) {
        $searchParams->perPage = $request->perpage;
      } 
      
      if (isset($request->sortby)) {
        $searchParams->sortBy = $request->sortby;
      }

      if (isset($request->category)) {          
        $top_category = $request->category;
        $searchParams->top_category = $top_category;
      }

      $query_url = '';

      $query_url .= $top_category;

      /*horses*/
        if (isset($request->search_discipline)){
          $searchParams->selectedDiscipline = $request->search_discipline;
          
          $search_discipline_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_discipline)->pluck('slug')->toArray();
         
          $query_url .= '-'.implode ("-", $search_discipline_DynamicField_values);
        }
        
        if (isset($request->search_color)) {
            $searchParams->selectedColor = $request->search_color;

            $search_color_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_color)->pluck('slug')->toArray();
            $query_url .= '-'.implode ("-", $search_color_DynamicField_values);
        }

        if (isset($request->search_gender)) {
          $searchParams->selectedGender = $request->search_gender;

          $search_gender_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_gender)->pluck('slug')->toArray();
          $query_url .= '-'.implode ("-", $search_gender_DynamicField_values);
        }

        if (isset($request->search_age)) {
          $search_age_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_age)->pluck('slug')->toArray();
          $query_url .= '-'.implode ("-", $search_age_DynamicField_values);
        }

        if (isset($request->search_rider_Level)) {
          $searchParams->selectedRiderLevel = $request->search_rider_Level;

          $search_rider_Level_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_rider_Level)->pluck('slug')->toArray();
          $query_url .= '-'.implode ("-", $search_rider_Level_DynamicField_values);
        }

        if (isset($request->search_height)) {
          $searchParams->selectedHeight = $request->search_height;

          $search_height_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_height)->pluck('slug')->toArray();
          $query_url .= '-'.implode ("-", $search_height_DynamicField_values);
        }

        if (isset($request->search_breed_primary)) {
          $searchParams->selectedBreed = $request->search_breed_primary;

          $search_breed_primary_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_breed_primary)->pluck('slug')->toArray();
          $query_url .= '-'.implode ("-", $search_breed_primary_DynamicField_values);
        }

      /*transport*/
        if (isset($request->search_transtype)) {
            $searchParams->selectedTransportType = $request->search_transtype;
            $search_transtype_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_transtype)->pluck('slug');
            $query_url .= '-'.implode ("-", $search_transtype_DynamicField_values);
        }

        if (isset($request->search_no_of_horses)) {
            $searchParams->selectedHorseNumber = $request->search_no_of_horses;

            $search_no_of_horses_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_no_of_horses)->pluck('slug');
            $query_url .= '-'.implode ("-", $search_no_of_horses_DynamicField_values);
        }

        if (isset($request->search_ramplocation)) {
            $searchParams->selectedRampLocation = $request->search_ramplocation;

            $search_ramplocation_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_ramplocation)->pluck('slug');
            $query_url .= '-'.implode ("-", $search_ramplocation_DynamicField_values);
        }

      /*saddlery*/
        if (isset($request->search_saddlerytype)) {
            $searchParams->selectedSaddleryType = $request->search_saddlerytype;

            $search_saddlerytype_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_saddlerytype)->pluck('slug');
            $query_url .= '-'.implode ("-", $search_saddlerytype_DynamicField_values);
        }

        if (isset($request->search_saddlerycategory)) {            
            $searchParams->selectedSaddleryCategory = $request->search_saddlerycategory;

            $search_saddlerycategory_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_saddlerycategory)->pluck('slug');
            $query_url .= '-'.implode ("-", $search_saddlerycategory_DynamicField_values);
        }

        if (isset($request->search_saddlerycondition)) {
            $searchParams->selectedSaddleryCondition = $request->search_saddlerycondition;

            $search_saddlerycondition_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_saddlerycondition)->pluck('slug');
            $query_url .= '-'.implode ("-", $search_saddlerycondition_DynamicField_values);
        }

      /*property*/
          if (isset($request->search_property_category)) {
              $search_property_category = $request->search_property_category;
              $searchParams->selectedPropertyType = $request->search_property_category;
          
              array_push($all_DynamicField_values, $request->search_property_category);
              $query_url .= '-'.implode ("-", \Str::slug($request->search_property_category));
          }

          if (isset($request->search_property_Bedrooms)) {
              $searchParams->selectedBedrooms = $request->search_property_Bedrooms;

              $search_property_Bedrooms_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_property_Bedrooms)->pluck('slug');
              $query_url .= '-'.implode ("-", $search_property_Bedrooms_DynamicField_values);
          }

          if (isset($request->search_property_Bathrooms)) {
              $search_Bathrooms = $request->search_property_Bathrooms;
              $searchParams->selectedBathrooms = $request->search_property_Bathrooms;

              $search_property_Bathrooms_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_property_Bathrooms)->pluck('slug');
              $query_url .= '-'.implode ("-", $search_property_Bathrooms_DynamicField_values);
          }

      if (isset($request->search_state)) {
        $searchParams->selectedLocation = $request->search_state;
        $state = State::whereIn('id', $request->search_state)->get();        
        foreach ($state as $key => $value) {
          $query_url .= '-'.\Str::slug($value->state_name).'-'.$value->state_code;
        }
      }

      return \Redirect::to('search-results/'.trim($query_url,'-'));
    }
}
