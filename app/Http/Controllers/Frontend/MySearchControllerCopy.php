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

class MySearchControllerCopy extends Controller
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

    public function __construct(ListingMaster $listing_master,ListingMeta $listing_meta)
    {
        $this->listing_master = $listing_master;
        $this->listing_meta   = $listing_meta;
        
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
            'listing_master.item_show_type as item_show_type'
        )
            ->where(['is_active' => '1', 'is_approved' => '1', 'is_delete' => '0']);

        $this->search_params = $searchParams;
    }

    public function header_menu_quick_search(Request $request)
    {
      $searchParams = new SearchParams;
      $searchParams->resetSearchTerms();

      $perpage = $this->perPageCnt;
      $sortBy = $this->sortingMethod;
      // $searchParams->perPage = $perpage;

      // $sortBy = 'a_z';
      // $searchParams->sortBy = $sortBy;

      if ($request->by_category == 'horses') {
          $searchParams->top_category = $request->by_category;
          return \Redirect::to('search-results/'.$request->by_category);
          //$search_result = $this->general_search_result->where('listing_master.category_id', 1);
      } 

      if ($request->by_category == 'transport') {
          $searchParams->top_category = $request->by_category;
          return \Redirect::to('search-results/'.$request->by_category);
          //$search_result = $this->general_search_result->where('listing_master.category_id', 2);
      }

      if ($request->by_category == 'saddlery') {
          $searchParams->top_category = $request->by_category;
          return \Redirect::to('search-results/'.$request->by_category);
          //$search_result = $this->general_search_result->where('listing_master.category_id', 3);
      }

      if ($request->by_category == 'property') {
          $searchParams->top_category = $request->by_category;
          return \Redirect::to('search-results/'.$request->by_category);
          //$search_result = $this->general_search_result->where('listing_master.category_id', 4);
      }

      if ($request->quick_search_type == 'free' || $request->quick_search_type == 'negotiable') {
          $quick_search = $request->quick_search_type;
          $searchParams->top_category = 'horses';
          $search_result = $this->general_search_result->where('item_show_type', $quick_search);
      }

      if ($request->quick_search_type == 'under1000') {
          $searchParams->top_category = 'horses';
          $search_result = $this->general_search_result->where('price', '<=', 1000);
      }

      if ($request->quick_search_type == 'over5000') {
          $searchParams->top_category = 'horses';
          $search_result = $this->general_search_result->where('price', '>=', 5000);
      }

      if ($request->quick_search_type == 'last24hours') {
          $searchParams->top_category = 'horses';
          $search_result = $this->general_search_result->where('listing_master.created_at', '>', Carbon::now()->subDays(1));
      }

      $search_result = $this->general_search_result->paginate($perpage);

      return view('front.listing_results', compact(
          'sortBy',
          'perpage',
          'search_result'
      ));
    }

    public function search_latest_featured_listing(Request $request)
    {
        $searchParams = session('searchParams');
        $searchParams->resetSearchTerms();
      
        $perpage = 20;
        $searchParams->perPage = $perpage;
        
        if (isset($request->latest_featured)) {
          $listing = $request->latest_featured;
        }
      
        $searchParams->sortBy = $listing;

        $searchParams->top_category = 'horses';
      
        return \Redirect::to('search-results/'.$listing);

        // if ($listing == 'featured') {
        //     $search_result = $this->general_search_result->whereIn('listing_master.id', function ($q) {
        //         $q->select('listing_master_id')
        //             ->from('featured_listings');
        //     });
        // }

        // if ($listing == 'latest') {
        //     $search_result = $this->general_search_result->whereIn('listing_master.id', function ($q) {
        //         $q->select('listing_master_id')
        //             ->from('latest_listings');
        //     });
        // }

        // if ($listing == 'stallion') {
        //     $search_result = $this->general_search_result->whereIn('listing_master.id', function ($q) {
        //         $q->select('listing_master_id')
        //             ->from('stallions_listing');
        //     });
        // }

        // $search_result = $this->general_search_result->distinct()->paginate($perpage);
        // return view('front.listing_results', compact(            
        //     'sortBy',
        //     'perpage',
        //     'search_result'
        // ));
    }

    public function search_by_state(Request $request)
    {
      $searchParams = session('searchParams');
      $searchParams->resetSearchTerms();

      $searchParams->top_category = 'horses';
      $state = State::where('state_code', $request->state_code)->first();
      array_push($searchParams->selectedLocation, $state->id);
      
      return \Redirect::to('search-results/'.'horses-location-'.$request->state_code);
    }

    public function search_horse_dynamic_categories(Request $request)
    {
      $searchParams = session('searchParams');
      $searchParams->resetSearchTerms();

      if (isset($request->perpage)) {
        $perpage = $request->perpage;
      } 
      else
      {
        $perpage = 20;
        $searchParams->perPage = $perpage;
      }

      $sortby = 'a_z';
      $listing = '';
      $searchParams->sortBy = $sortby;
      $searchParams->listing = $listing;

      $listing_dynamic_field_ids = $request->dynamic_category_id;

      $searchParams->top_category = $request->by_category;

        if($request->by_category == 'horses')
        {          
          if ($request->dynamic_category_type == 'breed')
          {
            array_push($searchParams->selectedBreed, $listing_dynamic_field_ids);            
            return \Redirect::to('search-results/'.'horses-breed-'.$request->category_name);
          }

          if ($request->dynamic_category_type == 'color') {
            array_push($searchParams->selectedColor, $listing_dynamic_field_ids);            
            return \Redirect::to('search-results/'.'horses-color-'.$request->category_name);
          }

          if ($request->dynamic_category_type == 'gender') {
            array_push($searchParams->selectedGender, $listing_dynamic_field_ids);            
            return \Redirect::to('search-results/'.'horses-gender-'.$request->category_name);
          }

          if ($request->dynamic_category_type == 'discipline') {
            array_push($searchParams->selectedDiscipline, $listing_dynamic_field_ids);
            return \Redirect::to('search-results/'.'horses-discipline-'.$request->category_name);
          }
        }
        elseif($request->by_category == 'transport')
        {
          array_push($searchParams->selectedTransportType, $listing_dynamic_field_ids);
          return \Redirect::to('search-results/'.'transport');
        }
        elseif($request->by_category == 'saddlery')
        {
          array_push($searchParams->selectedSaddleryType, $listing_dynamic_field_ids);
          return \Redirect::to('search-results/'.'saddlery');
        }
        elseif($request->by_category == 'property')
        {
          array_push($searchParams->selectedPropertyType, $listing_dynamic_field_ids);
          return \Redirect::to('search-results/'.'property');
        }

        // session(['searchParams' => $searchParams]);

        // $search_result = $this->general_search_result->where('listing_master.category_id', 1)
        //     ->join(
        //         'listing_dynamic_field_values',
        //         function ($join) use ($listing_dynamic_field_ids) {
        //             $join->on('listing_dynamic_field_values.listing_master_id', '=', 'listing_master.id');
        //             if (!empty($listing_dynamic_field_ids)) {
        //                 $join->where('listing_dynamic_field_values.dynamic_field_id', '=', $listing_dynamic_field_ids);
        //             }
        //         }
        //     );
        // $search_result = $this->general_search_result->distinct()->paginate($perpage);

        // return view('front.listing_results', compact(
        //     'listing',
        //     'sortby',
        //     'perpage',
        //     'search_result'
        // ));
    }

    public function category_quicksearch(Request $request)
    {      
        $all_DynamicField_values = [];

        $searchParams = session('searchParams');
        $searchParams->resetSearchTerms();

        if (isset($request->perpage)) {
          $perpage = $request->perpage;
        } 
        else
        {
          $perpage = 20;
          $searchParams->perPage = $perpage;
        }

        $sortby = 'a_z';
        $listing = '';
        $searchParams->sortBy = $sortby;
        $searchParams->listing = $listing;

        $query_url = '';

        if (isset($request->category)) {          
          $top_category = $request->category;
          $searchParams->top_category = $top_category;
        }

        $query_url .= $top_category;

        /*Horases*/
          if ($top_category == 'horses') {
              //$search_result = $this->general_search_result->where('listing_master.category_id', 1);

              if (isset($request->discipline) || isset($request->breed) || isset($request->sex)) {

                  if (isset($request->discipline)) {            
                      array_push($searchParams->selectedDiscipline, $request->discipline);

                      $discipline_DynamicField_values = DynamicFieldValues::where('id',$request->discipline)->pluck('field_value');                      
                      array_push($all_DynamicField_values, $discipline_DynamicField_values);                      
                      $query_url .= '-'.\Str::slug($discipline_DynamicField_values[0]);
                  }                  
                  if (isset($request->sex)) {
                      array_push($searchParams->selectedGender, $request->sex);

                      $sex_DynamicField_values = DynamicFieldValues::where('id',$request->sex)->pluck('field_value');
                      array_push($all_DynamicField_values, $sex_DynamicField_values);
                      $query_url .= '-'.\Str::slug($sex_DynamicField_values[0]);
                  }
                  if (isset($request->breed)) {
                      array_push($searchParams->selectedBreed, $request->breed);

                      $breed_DynamicField_values = DynamicFieldValues::where('id',$request->breed)->pluck('field_value');                      
                      array_push($all_DynamicField_values, $breed_DynamicField_values);                    
                      $query_url .= '-'.\Str::slug($breed_DynamicField_values[0]);
                  }                  
                  // $search_result =  $this->general_search_result->join(
                  //     'listing_dynamic_field_values',
                  //     function ($join) use ($discipline, $breed, $sex) {
                  //         $join->on('listing_dynamic_field_values.listing_master_id', '=', 'listing_master.id');
                  //         $join->where(function ($query) use ($discipline, $breed, $sex) {
                  //             if ($discipline != '') {
                  //                 $query->where('dynamic_field_id', '=', $discipline);
                  //             }

                  //             if ($breed != '') {
                  //                 $query->where('dynamic_field_id', '=', $breed);
                  //             }

                  //             if ($sex != '') {
                  //                 $query->where('dynamic_field_id', '=', $sex);
                  //             }
                  //         });
                  //     }
                  // );
              }
          }

        /*Transport*/
          if ($top_category == 'transport') {
              //$search_result =  $this->general_search_result->where('listing_master.category_id', 2);

              if (isset($request->transport_type) || isset($request->transport_horse_number) || isset($request->transport_ramp_location)) {

                  if (isset($request->transport_type)) {
                      array_push($searchParams->selectedTransportType, $request->transport_type);

                      $transport_type_DynamicField_values = DynamicFieldValues::where('id',$request->transport_type)->pluck('field_value');
                      array_push($all_DynamicField_values, $transport_type_DynamicField_values);
                      $query_url .= '-'.\Str::slug($transport_type_DynamicField_values[0]);
                  }
                  if (isset($request->transport_horse_number)) {
                      array_push($searchParams->selectedHorseNumber, $request->transport_horse_number);

                      $transport_horse_number_DynamicField_values = DynamicFieldValues::where('id',$request->transport_horse_number)->pluck('field_value');

                      array_push($all_DynamicField_values, $transport_horse_number_DynamicField_values);
                      $query_url .= '-'.\Str::slug($transport_horse_number_DynamicField_values[0]);
                  }
                  if (isset($request->transport_ramp_location)) {
                      array_push($searchParams->selectedRampLocation, $request->transport_ramp_location);

                      $transport_ramp_location_DynamicField_values = DynamicFieldValues::where('id',$request->transport_ramp_location)->pluck('field_value');
                      array_push($all_DynamicField_values, $transport_ramp_location_DynamicField_values);
                      $query_url .= '-'.\Str::slug($transport_ramp_location_DynamicField_values[0]);
                  }
                  // $search_result =  $this->general_search_result->join(
                  //     'listing_dynamic_field_values',
                  //     function ($join) use (
                  //         $transport_type,
                  //         $transport_horse_number,
                  //         $transport_ramp_location
                  //     ) {
                  //         $join->on('listing_dynamic_field_values.listing_master_id', '=', 'listing_master.id');
                  //         $join->where(function ($query) use (
                  //             $transport_type,
                  //             $transport_horse_number,
                  //             $transport_ramp_location
                  //         ) {

                  //             if ($transport_type != '') {
                  //                 $query->where('dynamic_field_id', '=', $transport_type);
                  //             }
                  //             if ($transport_horse_number != '') {
                  //                 $query->where('dynamic_field_id', '=', $transport_horse_number);
                  //             }
                  //             if ($transport_ramp_location != '') {
                  //                 $query->where('dynamic_field_id', '=', $transport_ramp_location);
                  //             }
                  //         });
                  //     }
                  // );
              }
          }

        /*Saddlery*/
          if ($top_category == 'saddlery') {
              //$search_result = $this->general_search_result->where('listing_master.category_id', 3);

              if (isset($request->saddlery_type) && isset($request->saddlery_category)) {
                  $cnt++;

                  if (isset($request->saddlery_type)) {
                      $saddlery_type = $request->all_saddlery_type;
                      array_push($searchParams->selectedSaddleryType, $saddlery_type);

                      $all_saddlery_type_DynamicField_values = DynamicFieldValues::where('id',$request->all_saddlery_type)->pluck('field_value');
                      array_push($all_DynamicField_values, $all_saddlery_type_DynamicField_values);                    
                      $query_url .= '-'.\Str::slug($all_saddlery_type_DynamicField_values[0]);
                  }
                  if (isset($request->saddlery_category)) {
                      $saddlery_category = $request->saddlery_category;
                      array_push($searchParams->selectedSaddleryCategory, $saddlery_category);

                      $saddlery_category_DynamicField_values = DynamicFieldValues::where('id',$request->saddlery_category)->pluck('field_value');
                      array_push($all_DynamicField_values, $saddlery_category_DynamicField_values);
                      $query_url .= '-'.\Str::slug($saddlery_category_DynamicField_values[0]);
                  }
                  // $search_result = $this->general_search_result->join(
                  //     'listing_dynamic_field_values',
                  //     function ($join) use ($saddlery_type, $saddlery_category) {
                  //         $join->on('listing_dynamic_field_values.listing_master_id', '=', 'listing_master.id');
                  //         $join->where(function ($query) use ($saddlery_type, $saddlery_category) {

                  //             if ($saddlery_type != '') {
                  //                 $query->where('dynamic_field_id', '=', $saddlery_type);
                  //             }

                  //             if ($saddlery_category != '') {
                  //                 $query->where('dynamic_field_id', '=', $saddlery_category);
                  //             }
                  //         });
                  //     }
                  // );
              }
          }

        /*Property*/
          if ($top_category == 'property') {
              //$search_result = $this->general_search_result->where('listing_master.category_id', 4);

              if (isset($request->property_category) || isset($request->property_Bathrooms) || isset($request->property_Bedrooms)) {
                  // if ($request->property_category == 'all_property_category') {
                  //     $all_property_category = ['N/A', 'Agistment', 'For lease', 'For sale'];
                  //     $search_result = $search_result->whereIn('property_category', $all_property_category);
                  // } else {
                  //     $search_result = $search_result->where('property_category', $request->property_category);
                  // }
                  if (isset($request->property_category))
                  {
                    $search_result = $search_result->where('property_category', $request->property_category);
                    array_push($searchParams->selectedPropertyType, $request->property_category);
                    array_push($all_DynamicField_values, $request->property_category);
                    $query_url .= '-'.\Str::slug($request->property_category);
                  }

                  if (isset($request->property_Bathrooms)){
                      $property_Bathrooms = $request->property_Bathrooms;
                      array_push($searchParams->selectedBedrooms, $property_Bathrooms);

                      $property_Bathrooms_DynamicField_values = DynamicFieldValues::whereIn('id',$request->property_Bathrooms)->pluck('field_value');
                      array_push($all_DynamicField_values, $property_Bathrooms_DynamicField_values);
                      $query_url .= '-'.\Str::slug($property_Bathrooms_DynamicField_values[0]);
                  }
                  if (isset($request->property_Bedrooms)) {
                      $property_Bedrooms = $request->property_Bedrooms;
                      array_push($searchParams->selectedBathrooms, $property_Bedrooms);

                      $property_Bedrooms_DynamicField_values = DynamicFieldValues::where('id',$request->property_Bedrooms)->pluck('field_value');
                      array_push($all_DynamicField_values, $property_Bedrooms_DynamicField_values); 
                      $query_url .= '-'.\Str::slug($property_Bedrooms_DynamicField_values[0]);                    
                  }
                  // $search_result = $this->general_search_result->join(
                  //     'listing_dynamic_field_values',
                  //     function ($join) use ($property_Bathrooms, $property_Bedrooms) {
                  //         $join->on('listing_dynamic_field_values.listing_master_id', '=', 'listing_master.id');
                  //         $join->where(function ($query) use ($property_Bathrooms, $property_Bedrooms) {
                  //             if ($property_Bathrooms != '') {
                  //                 $query->where('dynamic_field_id', '=', $property_Bathrooms);
                  //             }
                  //             if ($property_Bedrooms != '') {
                  //                 $query->where('dynamic_field_id', '=', $property_Bedrooms);
                  //             }
                  //         });
                  //     }
                  // );
              }
          }

        if (isset($request->state))
        {
          $state = State::where('id', $request->state)->first();
          array_push($searchParams->selectedLocation, $request->state);
          $query_url .= '-'.\Str::slug($state->state_name).'-'.$state->state_code;
          //$search_result = $this->general_search_result->where('listing_master.state_id', $request->state);
        }

        if (isset($request->price_min) || isset($request->price_max)) {
            if (empty($request->price_min))
            {
              $min_price = ListingMaster::min('price');
              $searchParams->minPrice = $min_price;
            }
            else
            {
              $min_price = $request->price_min;
              $searchParams->minPrice = $min_price;
            }
            if (empty($request->price_max))
            {
              $max_price = ListingMaster::max('price');
              $searchParams->maxPrice = $max_price;
            }
            else
            {
              $max_price = $request->price_max;
              $searchParams->maxPrice = $max_price;
            }
            //$query_url .= '-min_price-'.$min_price.'-max_price-'.$max_price;
            // $search_result = $this->general_search_result->whereBetween('listing_master.price', [$min_price, $max_price]);
        }

        return \Redirect::to('search-results/'.trim($query_url,'-'));

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

    public function search_result(Request $request)
    {
        $top_category = session()->get('searchParams')->top_category;
        $sortBy = session()->get('searchParams')->sortBy;
        $perPage = session()->get('searchParams')->perPage;
        $minPrice = session()->get('searchParams')->minPrice;
        $maxPrice = session()->get('searchParams')->maxPrice;
     
        /*horses*/
          $selectedAge = session()->get('searchParams')->selectedAge;
          $selectedBreed = session()->get('searchParams')->selectedBreed;
          $selectedColor = session()->get('searchParams')->selectedColor;
          $selectedDiscipline = session()->get('searchParams')->selectedDiscipline;
          $selectedGender = session()->get('searchParams')->selectedGender;
          $selectedHeight = session()->get('searchParams')->selectedHeight;
          $selectedLocation = session()->get('searchParams')->selectedLocation;
          $selectedRiderLevel = session()->get('searchParams')->selectedRiderLevel;

        /*transport*/
          $selectedTransportType = session()->get('searchParams')->selectedTransportType;
          $selectedHorseNumber = session()->get('searchParams')->selectedHorseNumber;
          $selectedRampLocation = session()->get('searchParams')->selectedRampLocation;

        /*saddlery*/
          $selectedSaddleryType = session()->get('searchParams')->selectedSaddleryType;
          $selectedSaddleryCategory = session()->get('searchParams')->selectedSaddleryCategory;
          $selectedSaddleryCondition = session()->get('searchParams')->selectedSaddleryCondition;
            
        /*property*/
          $selectedPropertyType = session()->get('searchParams')->selectedPropertyType;
          $selectedBedrooms = session()->get('searchParams')->selectedBedrooms;
          $selectedBathrooms = session()->get('searchParams')->selectedBathrooms;

          $search_state = [];
          $category_id = '';
          $all_DynamicField_values = [];

        /*horses_search*/
          $search_discipline  = [];
          $search_breed_primary  = [];
          $search_height = [];
          $search_age = [];
          $search_gender = [];
          $search_rider_Level = [];
          $search_color = [];

        /*transport_search*/
          $search_trans_type = [];
          $search_no_of_horse = [];
          $search_ramp_location = [];

        /*saddlery_search*/
          $search_saddlerytype = [];
          $search_saddlerycategory = [];
          $search_saddlerycondition = [];

        /*property_search*/
          $search_property_category = [];
          $search_Bedrooms = [];
          $search_Bathrooms = [];

        /*horses_result*/
          $discipline_search_result = [];
          $breed_search_result = [];
          $height_search_result = [];
          $age_search_result = [];
          $gender_search_result = [];
          $rider_Level_search_result = [];
          $color_search_result = [];

        /*transport_result*/
          $trans_type_search_result = [];
          $no_of_horse_search_result = [];
          $ramp_location_search_result = [];

        /*saddlery_result*/
          $saddlery_type_search_result = [];
          $saddlery_category_search_result = [];
          $saddlery_condition_search_result = [];

        /*property_result*/
          $property_category_search_result = [];
          $property_Bedrooms_search_result = [];
          $property_Bathrooms_search_result = [];


        if ($top_category == 'horses') {            
          $category_id = 1;
        }

        if ($top_category == 'transport') {            
          $category_id = 2;
        }

        if ($top_category == 'saddlery') {          
            $category_id = 3;
        }

        if ($top_category == 'property') {            
          $category_id = 4;
        }

        $search_result = $this->getMasterListingQuery1($category_id);
        
        if(!empty($selectedLocation))
        {
          $search_result = $search_result->whereIn('listing_master.state_id', $selectedLocation);
        }

        if(!empty($minPrice) || !empty($maxPrice))
        {
          $search_result =  $search_result->whereBetween('listing_master.price', [$minPrice, $maxPrice]);
        }

        /*horses*/
          if(!empty($selectedDiscipline)){
              // $search_discipline = $request->search_discipline;
              // $searchParams->selectedDiscipline = $request->search_discipline;
              
              $search_discipline_DynamicField_values = DynamicFieldValues::whereIn('id',$selectedDiscipline)->pluck('field_value');              
              array_push($all_DynamicField_values, $search_discipline_DynamicField_values);

              $master_query = $this->getMasterListingQuery($category_id);
              $discipline_search_result = $master_query->select('listing_master.id')
                  ->where('listing_dynamic_field_values.field_id', 1)
                  ->whereIn('listing_dynamic_field_values.dynamic_field_id', $selectedDiscipline)
                  ->get();
          }

          if (!empty($selectedBreed)) {
              // $search_breed_primary = $request->search_breed_primary;
              // $searchParams->selectedBreed = $request->search_breed_primary;

              $search_breed_primary_DynamicField_values = DynamicFieldValues::whereIn('id',$selectedBreed)->pluck('field_value');
              array_push($all_DynamicField_values, $search_breed_primary_DynamicField_values);

              $master_query = $this->getMasterListingQuery($category_id);
              $breed_search_result = $master_query->select('listing_master.id')
                  ->where('listing_dynamic_field_values.field_id', 2)
                  ->whereIn('listing_dynamic_field_values.dynamic_field_id', $selectedBreed)
                  ->get();
          }
          
          if (!empty($selectedColor)) {
              // $search_color = $request->search_color;
              // $searchParams->selectedColor = $request->search_color;

              $search_color_DynamicField_values = DynamicFieldValues::whereIn('id',$selectedColor)->pluck('field_value');
              array_push($all_DynamicField_values, $search_color_DynamicField_values);

              $master_query = $this->getMasterListingQuery($category_id);
              $color_search_result = $master_query->select('listing_master.id')
                  ->where('listing_dynamic_field_values.field_id', 4)
                  ->whereIn('listing_dynamic_field_values.dynamic_field_id', $selectedColor)
                  ->get();
          }

          if (!empty($selectedGender)) {
              // $search_gender = $request->search_gender;
              // $searchParams->selectedGender = $request->search_gender;

              $search_gender_DynamicField_values = DynamicFieldValues::whereIn('id',$selectedGender)->pluck('field_value');
              array_push($all_DynamicField_values, $search_gender_DynamicField_values);

              $master_query = $this->getMasterListingQuery($category_id);
              $gender_search_result = $master_query->select('listing_master.id')
                  ->where('listing_dynamic_field_values.field_id', 5)
                  ->whereIn('listing_dynamic_field_values.dynamic_field_id', $selectedGender)
                  ->get();
          }

          if (!empty($selectedAge)) {
              // $search_age = $request->search_age;
              // $searchParams->selectedAge = $request->search_age;

              $search_age_DynamicField_values = DynamicFieldValues::whereIn('id',$selectedAge)->pluck('field_value');
              array_push($all_DynamicField_values, $search_age_DynamicField_values);

              $master_query = $this->getMasterListingQuery($category_id);
              $age_search_result = $master_query->select('listing_master.id')
                  ->where('listing_dynamic_field_values.field_id', 7)
                  ->whereIn('listing_dynamic_field_values.dynamic_field_id', $selectedAge)
                  ->get();
          }

          if (!empty($selectedRiderLevel)) {
              // $search_rider_Level = $request->search_rider_Level;
              // $searchParams->selectedRiderLevel = $request->search_rider_Level;

              $search_rider_Level_DynamicField_values = DynamicFieldValues::whereIn('id',$selectedRiderLevel)->pluck('field_value');
              array_push($all_DynamicField_values, $search_rider_Level_DynamicField_values);

              $master_query = $this->getMasterListingQuery($category_id);
              $rider_Level_search_result = $master_query->select('listing_master.id')
                  ->where('listing_dynamic_field_values.field_id', 8)
                  ->whereIn('listing_dynamic_field_values.dynamic_field_id', $selectedRiderLevel)
                  ->get();
          }

          if (!empty($selectedHeight)) {
              // $search_height = $request->search_height;
              // $searchParams->selectedHeight = $request->search_height;

              $search_height_DynamicField_values = DynamicFieldValues::whereIn('id',$selectedHeight)->pluck('field_value');
              array_push($all_DynamicField_values, $search_height_DynamicField_values);

              $master_query = $this->getMasterListingQuery($category_id);
              $height_search_result = $master_query->select('listing_master.id')
                  ->where('listing_dynamic_field_values.field_id', 9)
                  ->whereIn('listing_dynamic_field_values.dynamic_field_id', $selectedHeight)
                  ->get();
          }
        
        /*transport*/
          if (!empty($selectedTransportType)) {
              // $search_trans_type = $request->search_transtype;
              // $searchParams->selectedTransportType = $request->search_transtype;

              $search_transtype_DynamicField_values = DynamicFieldValues::whereIn('id',$selectedTransportType)->pluck('field_value');
              array_push($all_DynamicField_values, $search_transtype_DynamicField_values);

              $master_query = $this->getMasterListingQuery($category_id);
              $trans_type_search_result = $master_query->select('listing_master.id')
                  ->where('listing_dynamic_field_values.field_id', 10)
                  ->whereIn('listing_dynamic_field_values.dynamic_field_id', $selectedTransportType)
                  ->get();
          }

          if (!empty($selectedHorseNumber)) {
              // $search_no_of_horse = $request->search_no_of_horses;
              // $searchParams->selectedHorseNumber = $request->search_no_of_horses;

              $search_no_of_horses_DynamicField_values = DynamicFieldValues::whereIn('id',$selectedHorseNumber)->pluck('field_value');
              array_push($all_DynamicField_values, $search_no_of_horses_DynamicField_values);

              $master_query = $this->getMasterListingQuery($category_id);
              $no_of_horse_search_result = $master_query->select('listing_master.id')
                  ->where('listing_dynamic_field_values.field_id', 11)
                  ->whereIn('listing_dynamic_field_values.dynamic_field_id', $selectedHorseNumber)
                  ->get();
          }

          if (!empty($selectedRampLocation)) {
              // $search_ramp_location = $request->search_ramplocation;
              // $searchParams->selectedRampLocation = $request->search_ramplocation;

              $search_ramplocation_DynamicField_values = DynamicFieldValues::whereIn('id',$selectedRampLocation)->pluck('field_value');
              array_push($all_DynamicField_values, $search_ramplocation_DynamicField_values);

              $master_query = $this->getMasterListingQuery($category_id);
              $ramp_location_search_result = $master_query->select('listing_master.id')
                  ->where('listing_dynamic_field_values.field_id', 12)
                  ->whereIn('listing_dynamic_field_values.dynamic_field_id', $selectedRampLocation)
                  ->get();
          }

        /*saddlery*/
          if (!empty($selectedSaddleryType)) {
            // $search_saddlerytype = $request->search_saddlerytype;
            // $searchParams->selectedSaddleryType = $request->search_saddlerytype;

            $search_saddlerytype_DynamicField_values = DynamicFieldValues::whereIn('id',$selectedSaddleryType)->pluck('field_value');
            array_push($all_DynamicField_values, $search_saddlerytype_DynamicField_values);

            $master_query = $this->getMasterListingQuery($category_id);
            $saddlery_type_search_result = $master_query->select('listing_master.id')
                ->where('listing_dynamic_field_values.field_id', 15)
                ->whereIn('listing_dynamic_field_values.dynamic_field_id',$selectedSaddleryType)
                ->get();
          }

          if (!empty($selectedSaddleryCategory)) {
              // $search_saddlerycategory = $request->search_saddlerycategory;
              // $searchParams->selectedSaddleryCategory = $request->search_saddlerycategory;

              $search_saddlerycategory_DynamicField_values = DynamicFieldValues::whereIn('id',$selectedSaddleryCategory)->pluck('field_value');
              array_push($all_DynamicField_values, $search_saddlerycategory_DynamicField_values);

              $master_query = $this->getMasterListingQuery($category_id);
              $saddlery_category_search_result = $master_query->select('listing_master.id')
                  ->where('listing_dynamic_field_values.field_id', 16)
                  ->whereIn('listing_dynamic_field_values.dynamic_field_id',$selectedSaddleryCategory)
                  ->get();
          }

          if (!empty($selectedSaddleryCondition)) {
              // $search_saddlerycondition = $request->search_saddlerycondition;
              // $searchParams->selectedSaddleryCondition = $request->search_saddlerycondition;

              $search_saddlerycondition_DynamicField_values = DynamicFieldValues::whereIn('id',$selectedSaddleryCondition)->pluck('field_value');
              array_push($all_DynamicField_values, $search_saddlerycondition_DynamicField_values);

              $master_query = $this->getMasterListingQuery($category_id);
              $saddlery_condition_search_result = $master_query->select('listing_master.id')
                  ->where('listing_dynamic_field_values.field_id', 17)
                  ->whereIn('listing_dynamic_field_values.dynamic_field_id',$selectedSaddleryCondition)
                  ->get();
          }

        /*property*/
          if (!empty($selectedPropertyType)) {
              // $search_property_category = $request->search_property_category;
              // $searchParams->selectedPropertyType = $request->search_property_category;
          
              array_push($all_DynamicField_values, $selectedPropertyType);

              $master_query = $this->getMasterListingQuery($category_id);
              $property_category_search_result = $master_query->select('listing_master.id')                    
                  ->whereIn('listing_master.property_category',$selectedPropertyType)
                  ->get();
          }

          if (!empty($selectedBedrooms)) {
              // $search_Bedrooms = $request->search_property_Bedrooms;
              // $searchParams->selectedBedrooms = $request->search_property_Bedrooms;

              $search_property_Bedrooms_DynamicField_values = DynamicFieldValues::whereIn('id',$selectedBedrooms)->pluck('field_value');
              array_push($all_DynamicField_values, $search_property_Bedrooms_DynamicField_values);

              $master_query = $this->getMasterListingQuery($category_id);
              $property_Bedrooms_search_result = $master_query->select('listing_master.id')
                  ->where('listing_dynamic_field_values.field_id', 18)
                  ->whereIn('listing_dynamic_field_values.dynamic_field_id',$selectedBedrooms)
                  ->get();
          }

          if (!empty($selectedBathrooms)) {
              // $search_Bathrooms = $request->search_property_Bathrooms;
              // $searchParams->selectedBathrooms = $request->search_property_Bathrooms;

              $search_property_Bathrooms_DynamicField_values = DynamicFieldValues::whereIn('id',$selectedBathrooms)->pluck('field_value');
              array_push($all_DynamicField_values, $search_property_Bathrooms_DynamicField_values);
              
              $master_query = $this->getMasterListingQuery($category_id);
              $property_Bathrooms_search_result = $master_query->select('listing_master.id')
                  ->where('listing_dynamic_field_values.field_id', 19)
                  ->whereIn('listing_dynamic_field_values.dynamic_field_id',$selectedBathrooms)
                  ->get();
          }
        
        /*horses*/
          if (!empty($discipline_search_result)) {            
            $search_result = $search_result->whereIn('id', $discipline_search_result);
          }
          if (!empty($breed_search_result)) {
            $search_result = $search_result->whereIn('id', $breed_search_result);
          }
          if (!empty($height_search_result)) {
            $search_result = $search_result->whereIn('id', $height_search_result);
          }
          if (!empty($age_search_result)) {
            $search_result = $search_result->whereIn('id', $age_search_result);
          }
          if (!empty($gender_search_result)) {
            $search_result = $search_result->whereIn('id', $gender_search_result);
          }
          if (!empty($rider_Level_search_result)) {
            $search_result = $search_result->whereIn('id', $rider_Level_search_result);
          }
          if (!empty($color_search_result)) {
            $search_result = $search_result->whereIn('id', $color_search_result);
          }

        /*transport*/
          if (!empty($trans_type_search_result)) {
              $search_result = $search_result->whereIn('id', $trans_type_search_result);
          }
          if (!empty($no_of_horse_search_result)) {
              $search_result = $search_result->whereIn('id', $no_of_horse_search_result);
          }
          if (!empty($ramp_location_search_result)) {
              $search_result = $search_result->whereIn('id', $ramp_location_search_result);
          }

        /*saddlery*/
          if (!empty($saddlery_type_search_result)) {
              $search_result = $search_result->whereIn('id', $saddlery_type_search_result);
          }

          if (!empty($saddlery_category_search_result)) {
              $search_result = $search_result->whereIn('id', $saddlery_category_search_result);
          }

          if (!empty($saddlery_category_search_result)) {
              $search_result = $search_result->whereIn('id', $saddlery_category_search_result);
          }

        /*property*/
          if (!empty($property_category_search_result)) {
              $search_result = $search_result->whereIn('id', $property_category_search_result);
          }

          if (!empty($property_Bedrooms_search_result)) {
              $search_result = $search_result->whereIn('id', $property_Bedrooms_search_result);
          }

          if (!empty($property_Bathrooms_search_result)) {
              $search_result = $search_result->whereIn('id', $property_Bathrooms_search_result);
          }

            if ($sortBy == 'featured' || $sortBy == 'latest') {
                $listing = $sortBy;
            } else {
                $listing = '';
            }

            if ($sortBy == 'featured') {
                $search_result =  $search_result->where(function ($query) {
                    $query->whereIn('listing_master.id', function ($q) {
                        $q->select('listing_master_id')
                            ->from('featured_listings');
                    });
                });
            }

            if ($sortBy == 'latest') {
                $search_result =  $search_result->where(function ($query) {
                    $query->whereIn('listing_master.id', function ($q) {
                        $q->select('listing_master_id')
                            ->from('latest_listings');
                    });
                });
            }

            if ($sortBy == 'a_z') {
                $search_result = $search_result->orderBy('listing_master.title', 'DESC');
            }
            if ($sortBy == 'z_a') {
                $search_result = $search_result->orderBy('listing_master.title', 'ASC');
            }
            if ($sortBy == 'price_high_to_low') {
                $search_result = $search_result->orderBy('listing_master.price', 'DESC');
            }
            if ($sortBy == 'price_low_to_high') {
                $search_result = $search_result->orderBy('listing_master.price', 'ASC');
            }
  

        $perpage = $perPage;

        $search_result = $search_result->paginate($perpage);

        //session(['searchParams' => $searchParams]);
        $all_DynamicField_values = \Arr::flatten($all_DynamicField_values);
        
        return view('front.listing_results', compact('all_DynamicField_values','sortBy', 'perpage', 'search_result'));
    }

    public function getTopCategory()
    {
        return $this->top_category;
    }

    private function getMasterListingQuery($category_id = '')
    {
        $master_search_result = ListingMaster::where(['is_active' => '1', 'is_approved' => '1', 'is_delete' => '0', 'category_id' => $category_id])
            ->join(
                'listing_dynamic_field_values',
                'listing_dynamic_field_values.listing_master_id',
                '=',
                'listing_master.id'
            );
        return $master_search_result;
    }

    private function getMasterListingQuery1($category_id = '')
    {
        $master_search_result = ListingMaster::select(
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
            'listing_master.item_show_type as item_show_type'
        )->where(['is_active' => '1', 'is_approved' => '1', 'is_delete' => '0', 'category_id' => $category_id]);

        return $master_search_result;
    }

    public function view_listing(Request $request)
    {
      $current_page = 'view_listing';
      $listing = ListingMaster::where('ad_id',$request->ad_id)
                                ->where(['is_active' => '1', 'is_approved' => '1', 'is_delete' => '0'])
                                ->first();

      $ad_images = $listing->images()->get();

      $listing_meta = $listing->listing_meta()->first();
      if(empty($listing_meta))
      {
        $listing_meta = $this->listing_meta->create([
          'listing_master_id' => $listing->id,
          'number_of_views' => 1,
          'last_view_dt' => Carbon::now()
        ]);
        $listing_number_of_views = $listing_meta->number_of_views;
      }
      else
      {
        $listing_meta->fill([
          'listing_master_id' => $listing->id,
          'number_of_views' => $listing_meta->number_of_views + 1,
        ])->save();
        $listing_number_of_views = $listing_meta->number_of_views;
      }

     $meta_data = ListingMeta::orderBy('number_of_views', 'desc')
                    ->join('listing_master','listing_master.id','=','listing_meta.listing_master_id')
                    ->where('listing_meta.listing_master_id','!=', $listing->id)
                    ->take(4)
                    ->get();

      return view('front.view_listing',compact('current_page','listing','ad_images','listing_number_of_views','meta_data'));
    }

    private function getSortingMethod(){
      $sortMethod = session('sortMethod');
      if(empty($sortMethod)) {
        $sortMethod = "price_low_to_high";
        session(['sortMethod' => $sortMethod]);
      }
    }

    private function getPerPageResultCount(){
      $perPageCnt = session('perPageCnt');
      if(empty($perPageCnt)) {
        $perPageCnt = 20;
        session(['perPageCnt' => $perPageCnt]);
      }
    }
}
