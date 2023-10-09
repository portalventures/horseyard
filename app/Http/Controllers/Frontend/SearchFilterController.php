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


class SearchFilterController extends Controller
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
            'listing_master.item_show_type as item_show_type',
            'listing_master.featured_image_url as featured_image_url'
        )
            ->where(['is_active' => '1', 'is_approved' => '1', 'is_delete' => '0']);

        $this->search_params = $searchParams;
    }

    public function show_search_results(Request $request, $all_params)
    { 
      $requestSource = session('requestSource');
      $reqParam = $all_params;
      $mParams = explode(DELIM_MAIN, $reqParam);
      $cntParams = count($mParams);

      $searchParams = session('searchParams');
      if(empty($searchParams)) {
        $searchParams = new SearchParams;  
      }
      $searchParams->top_category = $mParams[0];
      session(['searchParams' => $searchParams]);

      $topCats = session('topCategories');

      if(empty($topCats)) {
        $homeController = new MyHomeController;
        $homeController->generateSessionData();
        // $topCats = TopCategory::select('category_name', 'id')->get();
        // session(['topCategories' => $topCats]);
      }

      $i = 1;
      $array_dynamic_ids = [];
      $locationSearch = false;
      $stCode = '';

      for($i = 1; $i < $cntParams; $i++) {
        $pParams = explode(DELIM_PRIMARY, $mParams[$i]);
        $dIds = getDynamicFieldUsingSlugArr($pParams);
        array_push($array_dynamic_ids, $dIds);
        if(($cntParams - $i) == 1) {
          $sParams = explode(DELIM_PRIMARY, $mParams[$i]);
          if(count($sParams) == 2 && strlen($sParams[1]) == 3) {
            $locationSearch = true;
            $stCode = $sParams[1];
          }
        }
      }
      
      if($locationSearch) {
        $stateObj = getStateByCode($stCode);
      }
      //dd($array_dynamic_ids);
      //dd(session('searchParams')->top_category);
      $search_result = $this->general_search_result
      ->join('listing_dynamic_field_values', 'listing_dynamic_field_values.listing_master_id','=','listing_master.id')
      ->whereIn('listing_dynamic_field_values.dynamic_field_id', $array_dynamic_ids);
      //$search_result = $this->generate_search_result($request);
      //$search_result = session('search_result');
      

      $perpage = session('perPageCnt');
      $search_result = $search_result->paginate($perpage);
      
      /*
      if($requestSource == 'leftFilter' || $requestSource == 'bottomFilter') {
        $search_result = $this->generate_search_result($request);
      } else {
        $search_result = session('search_result');
      }
      */
      $userSearchText = session('userSearchText');
     
      if(is_array($userSearchText)) {
        if(count($userSearchText)>1){
          $userSearchText = '';
        }else{
          $userSearchText = implode(', ', $userSearchText);
        }
      }
      return view('front.listing_results', compact('search_result', 'userSearchText'));
    }

    public function generateQueryURL()
    {
      $searchParams = session('searchParams');
      
      if (!isset($searchParams->top_category)) {          
        $searchParams->top_category = "horses";
      } else {
        $top_category = $searchParams->top_category;
      }

      $query_url = '';

      $query_url .= $top_category;

      /*horses*/
        if (!empty($searchParams->selectedDiscipline)){
          $search_discipline_DynamicField_values = DynamicFieldValues::whereIn('id',$searchParams->selectedDiscipline)->pluck('slug')->toArray();
          $query_url .= '-'.implode (".", $search_discipline_DynamicField_values);
        }
        
        if (!empty($searchParams->selectedColor)) {
            $search_color_DynamicField_values = DynamicFieldValues::whereIn('id',$searchParams->selectedColor)->pluck('slug')->toArray();
            $query_url .= '-'.implode ("-", $search_color_DynamicField_values);
        }

        if (!empty($searchParams->selectedGender)) {
          $search_gender_DynamicField_values = DynamicFieldValues::whereIn('id',$searchParams->selectedGender)->pluck('slug')->toArray();
          $query_url .= '-'.implode ("-", $search_gender_DynamicField_values);
        }

        if (!empty($searchParams->selectedAge)) {
          $search_age_DynamicField_values = DynamicFieldValues::whereIn('id',$searchParams->selectedAge)->pluck('slug')->toArray();
          $query_url .= '-'.implode ("-", $search_age_DynamicField_values);
        }

        if (!empty($searchParams->selectedRiderLevel)) {
          $search_rider_Level_DynamicField_values = DynamicFieldValues::whereIn('id',$searchParams->selectedRiderLevel)->pluck('slug')->toArray();
          $query_url .= '-'.implode ("-", $search_rider_Level_DynamicField_values);
        }

        if (!empty($searchParams->selectedHeight)) {
          $search_height_DynamicField_values = DynamicFieldValues::whereIn('id',$searchParams->selectedHeight)->pluck('slug')->toArray();
          $query_url .= '-'.implode ("-", $search_height_DynamicField_values);
        }

        if (!empty($searchParams->selectedBreed)) {
          $search_breed_primary_DynamicField_values = DynamicFieldValues::whereIn('id',$searchParams->selectedBreed)->pluck('slug')->toArray();
          $query_url .= '-'.implode ("-", $search_breed_primary_DynamicField_values);
        }

      /*transport*/
        if (!empty($searchParams->selectedTransportType)) {
            $search_transtype_DynamicField_values = DynamicFieldValues::whereIn('id',$searchParams->selectedTransportType)->pluck('slug');
            $query_url .= '-'.implode ("-", $search_transtype_DynamicField_values);
        }

        if (!empty($searchParams->selectedHorseNumber)) {
            $search_no_of_horses_DynamicField_values = DynamicFieldValues::whereIn('id',$searchParams->selectedHorseNumber)->pluck('slug');
            $query_url .= '-'.implode ("-", $search_no_of_horses_DynamicField_values);
        }

        if (!empty($searchParams->selectedRampLocation)) {
            $search_ramplocation_DynamicField_values = DynamicFieldValues::whereIn('id',$searchParams->selectedRampLocation)->pluck('slug');
            $query_url .= '-'.implode ("-", $search_ramplocation_DynamicField_values);
        }

      /*saddlery*/
        if (!empty($searchParams->selectedSaddleryType)) {
            $search_saddlerytype_DynamicField_values = DynamicFieldValues::whereIn('id',$searchParams->selectedSaddleryType)->pluck('slug');
            $query_url .= '-'.implode ("-", $search_saddlerytype_DynamicField_values);
        }

        if (!empty($searchParams->selectedSaddleryCategory)) {            
            $search_saddlerycategory_DynamicField_values = DynamicFieldValues::whereIn('id',$searchParams->selectedSaddleryCategory)->pluck('slug');
            $query_url .= '-'.implode ("-", $search_saddlerycategory_DynamicField_values);
        }

        if (!empty($searchParams->selectedSaddleryCondition)) {
            $search_saddlerycondition_DynamicField_values = DynamicFieldValues::whereIn('id',$searchParams->selectedSaddleryCondition)->pluck('slug');
            $query_url .= '-'.implode ("-", $search_saddlerycondition_DynamicField_values);
        }

      /*property*/
        if (!empty($searchParams->selectedPropertyCategory)) {
            array_push($all_DynamicField_values, $searchParams->selectedPropertyCategory);
            $query_url .= '-'.implode ("-", \Str::slug($searchParams->selectedPropertyCategory));
        }

        if (!empty($searchParams->selectedBedrooms)) {
            $search_property_Bedrooms_DynamicField_values = DynamicFieldValues::whereIn('id',$searchParams->selectedBedrooms)->pluck('slug');
            $query_url .= '-'.implode ("-", $search_property_Bedrooms_DynamicField_values);
        }

        if (!empty($searchParams->selectedBathrooms)) {
            $search_property_Bathrooms_DynamicField_values = DynamicFieldValues::whereIn('id',$searchParams->selectedBathrooms)->pluck('slug');
            $query_url .= '-'.implode ("-", $search_property_Bathrooms_DynamicField_values);
        }

        if (!empty($searchParams->selectedLocation)) {
          $state = State::whereIn('id', $request->search_state)->get();        
          foreach ($searchParams->selectedLocation as $stId) {
            $state = State::find($stId);   
            $query_url .= '-'.\Str::slug($state->state_name).'-'.$state->state_code;
          }
        }
      return $query_url;
    }


    public function search_page_filter(Request $request)
    {
      $searchParams = session('searchParams');
      $searchParams->resetSearchTerms();
      session(['TitleTxt' => '']);
      
      $perpage = '';
      if (isset($request->perpage)) {
        session(['perPageCnt' => $request->perpage]);
        $perpage = 'per_page='.$request->perpage;
      } 
      $sortby = '';
      if (isset($request->sortby)) {
        session(['sortMethod' => $request->sortby]);
        $sortby = 'sort_by='.$request->sortby;
      }
      
      if (isset($request->category)) {          
        $top_category = $request->category;
        $searchParams->top_category = $top_category;
      } else {
        $top_category = $searchParams->top_category;
      }

      $query_url = '';

      $query_url .= 'category='.$top_category;

      $request_count =0;
      $request_type = '';
      $request_value = '';

      /*horses*/
        if (isset($request->search_discipline)){
          $searchParams->selectedDiscipline = $request->search_discipline;
          
          $search_discipline_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_discipline)->pluck('slug')->toArray();
          $tStr = implode (DELIM_URL, $search_discipline_DynamicField_values);

          $query_url .= DELIM_ADD.'discipline='.$tStr;
          $request_count += count($search_discipline_DynamicField_values);
          if(count($search_discipline_DynamicField_values)==1){
            $request_value = $tStr;
            $request_type = 'horses-for-sale';
          }
        }
        
        if (isset($request->search_color)) {
            $searchParams->selectedColor = $request->search_color;

            $search_color_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_color)->pluck('slug')->toArray();
            $tStr = implode (DELIM_URL, $search_color_DynamicField_values);

            $request_count += count($search_color_DynamicField_values);
            $query_url .= DELIM_ADD.'color='.$tStr ;
            if(count($search_color_DynamicField_values)==1){
              $request_value = $tStr;
              $request_type = 'horse-colour';
            }
        }

        if (isset($request->search_gender)) {
          $searchParams->selectedGender = $request->search_gender;

          $search_gender_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_gender)->pluck('slug')->toArray();
          $tStr = implode (DELIM_URL, $search_gender_DynamicField_values);

          $request_count += count($search_gender_DynamicField_values);
          $query_url .= DELIM_ADD.'gender='.$tStr ;
          if(count($search_gender_DynamicField_values)==1){
            $request_value = $tStr;
            $request_type = 'field-sex';
          }
        }

        // if (isset($request->search_age)) {
        //   $searchParams->selectedAge = $request->search_age;

        //   $search_age_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_age)->pluck('slug')->toArray();
        //   $tStr = implode (DELIM_URL, $search_age_DynamicField_values);

        //   $query_url .= DELIM_ADD.'age='.$tStr ;
        //   $request_count += count($search_age_DynamicField_values);
        //   if(count($search_age_DynamicField_values)==1){
        //     $request_value = $tStr;
        //     $request_type = 'field-age';
        //   }
        // }

        if (isset($request->search_rider_Level)) {
          $searchParams->selectedRiderLevel = $request->search_rider_Level;

          $search_rider_Level_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_rider_Level)->pluck('slug')->toArray();
          $tStr = implode (DELIM_URL, $search_rider_Level_DynamicField_values);

          $request_count += count($search_rider_Level_DynamicField_values);
          $query_url .= DELIM_ADD.'rider_level='.$tStr ;
          if(count($search_rider_Level_DynamicField_values)==1){
            $request_value = $tStr;
            $request_type = 'rider-level';
          }
        }

        /*min/max Height*/    
          if (isset($request->minHeight) && $searchParams->top_category == 'horses') {
            $minHeight = explode(',',$request->minHeight);
            $searchParams->selectedMinHeight = $minHeight[0];
            $minHeight_DynamicField_values = DynamicFieldValues::where('id',$minHeight[0])
                                                                ->pluck('slug')
                                                                ->toArray();

            $tStr = implode (DELIM_URL, $minHeight_DynamicField_values);
            $request_count += count($minHeight_DynamicField_values);
                                  
            $query_url .= DELIM_ADD.'field-height='.$tStr ;

            if(count($minHeight_DynamicField_values)==1){
              $minHeight_DynamicField_value = DynamicFieldValues::where('id',$minHeight[0])->first();
              $request_value = $minHeight_DynamicField_value->slug;
              $request_type = 'field-height';
            }
          }
          
          if (isset($request->maxHeight) && $searchParams->top_category == 'horses') {
            $maxHeight = explode(',',$request->maxHeight);
            $searchParams->selectedMaxHeight = $maxHeight[0];
            $maxHeight_DynamicField_values = DynamicFieldValues::where('id',$maxHeight[0])
                                                                ->pluck('slug')
                                                                ->toArray();
            
            $tStr = implode (DELIM_URL, $maxHeight_DynamicField_values);
            $request_count += count($maxHeight_DynamicField_values);
            
            $query_url .= DELIM_ADD.'max-field-height='.$tStr;
            if(count($maxHeight_DynamicField_values)==1){
              $maxHeight_DynamicField_value = DynamicFieldValues::where('id',$maxHeight[0])->first();
              $request_value = $maxHeight_DynamicField_value->slug;
              $request_type = 'max-field-height';
            }
          }

        /*min/max Age*/
          if (isset($request->minAge) && $searchParams->top_category == 'horses') {
            $minAge = explode(',',$request->minAge);
            $searchParams->selectedMinAge = $minAge[0];
            $minAge_DynamicField_values = DynamicFieldValues::where('id',$minAge[0])
                                                                ->pluck('slug')
                                                                ->toArray();

            $tStr = implode (DELIM_URL, $minAge_DynamicField_values);

            $request_count += count($minAge_DynamicField_values) + 1;
            
            if (isset($request->maxAge)) {
              $request_count += 1;
            }

            $query_url .= DELIM_ADD.'min-age='.$minAge[1] ;
            if(count($minAge_DynamicField_values)==1){
              $request_value = $tStr;
              $request_type = 'min-age';
            }
          }

          if (isset($request->maxAge) && $searchParams->top_category == 'horses') {
            $maxAge = explode(',',$request->maxAge);
            $searchParams->selectedMaxAge = $maxAge[0];
            $maxAge_DynamicField_values = DynamicFieldValues::where('id',$maxAge[0])
                                                                ->pluck('slug')
                                                                ->toArray();
            
            $tStr = implode (DELIM_URL, $maxAge_DynamicField_values);

            $request_count += count($maxAge_DynamicField_values) + 1;
            
            if (isset($request->minAge)) {
              $request_count += 1;
            }

            $query_url .= DELIM_ADD.'max-age='.$maxAge[1];
            if(count($maxAge_DynamicField_values)==1){
              $request_value = $tStr;
              $request_type = 'max-age';
            }
          }

        if (isset($request->search_breed_primary)) {
          $searchParams->selectedBreed = $request->search_breed_primary;

          $search_breed_primary_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_breed_primary)->pluck('slug')->toArray();
          $tStr = implode (DELIM_URL, $search_breed_primary_DynamicField_values);

          $query_url .= DELIM_ADD.'breed='.$tStr ;
          $request_count += count($search_breed_primary_DynamicField_values);
          if(count($search_breed_primary_DynamicField_values)==1){
            $request_value = $tStr;
            $request_type = 'horses-for-sale';
          }
        }
        
        if (isset($request->keyword_or_sn) && !empty($request->keyword_or_sn))
        {
          $tStr = $request->keyword_or_sn;          
          $query_url .= DELIM_ADD.'keyword_or_sn='.$tStr;         
          $request_value = $tStr;
          $request_count += 2;          
          $request_type = 'keyword_or_sn';
          $searchParams->keywordTxt = $request->keyword_or_sn;
        }        

      /*transport*/
        if (isset($request->search_transtype)) {
            $searchParams->selectedTransportType = $request->search_transtype;
            $search_transtype_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_transtype)->pluck('slug');

            $tStr = implode (DELIM_URL, \Arr::flatten($search_transtype_DynamicField_values));

            $query_url .= DELIM_ADD.'transtype='.$tStr ;
            $request_count += count($search_transtype_DynamicField_values);
            if(count($search_transtype_DynamicField_values)==1){
              $request_value = $tStr;
              $request_type = 'transport-for-horses';
            }
        }

        if (isset($request->search_no_of_horses)) {
            $searchParams->selectedHorseNumber = $request->search_no_of_horses;

            $search_no_of_horses_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_no_of_horses)->pluck('slug');
            $tStr = implode (DELIM_URL, \Arr::flatten($search_no_of_horses_DynamicField_values));

            $query_url .= DELIM_ADD.'no_of_horse='.$tStr ;
            $request_count += count($search_no_of_horses_DynamicField_values);
            if(count($search_no_of_horses_DynamicField_values)==1){
              $request_value = $tStr;
              $request_type = 'transport-for-horses';
            }
        }

        if (isset($request->search_ramplocation)) {
            $searchParams->selectedRampLocation = $request->search_ramplocation;

            $search_ramplocation_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_ramplocation)->pluck('slug');
            $tStr = implode (DELIM_URL, \Arr::flatten($search_ramplocation_DynamicField_values));

            $query_url .= DELIM_ADD.'ramp_location='.$tStr ;
            $request_count += count($search_ramplocation_DynamicField_values);
            if(count($search_ramplocation_DynamicField_values)==1){
              $request_value = $tStr;
              $request_type = 'transport-for-horses';
            }
        }

      /*saddlery*/
        if (isset($request->search_saddlerytype)) {
            $searchParams->selectedSaddleryType = $request->search_saddlerytype;

            $search_saddlerytype_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_saddlerytype)->pluck('slug');
            $tStr = implode (DELIM_URL, \Arr::flatten($search_saddlerytype_DynamicField_values));

            $request_count += count($search_saddlerytype_DynamicField_values);
            $query_url .= DELIM_ADD.'saddlery_type='.$tStr ;
            if(count($search_saddlerytype_DynamicField_values)==1){
              $request_value = $tStr;
              $request_type = 'saddlery-type';
            }
        }

        if (isset($request->search_saddlerycategory)) {            
            $searchParams->selectedSaddleryCategory = $request->search_saddlerycategory;

            $search_saddlerycategory_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_saddlerycategory)->pluck('slug');
            $tStr = implode (DELIM_URL, \Arr::flatten($search_saddlerycategory_DynamicField_values));

            $query_url .= DELIM_ADD.'saddlery_cat='.$tStr ;
            $request_count += count($search_saddlerycategory_DynamicField_values);
            if(count($search_saddlerycategory_DynamicField_values)==1){
              $request_value = $tStr;
              $request_type = 'saddlery-and-tack';
            }
        }

        if (isset($request->search_saddlerycondition)) {
            $searchParams->selectedSaddleryCondition = $request->search_saddlerycondition;

            $search_saddlerycondition_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_saddlerycondition)->pluck('slug');
            $tStr = implode (DELIM_URL, \Arr::flatten($search_saddlerycondition_DynamicField_values));

            $query_url .= DELIM_ADD.'saddlery_condition='.$tStr ;
            $request_count += count($search_saddlerycondition_DynamicField_values);
            if(count($search_saddlerycondition_DynamicField_values)==1){
              $request_value = $tStr;
              $request_type = 'saddlery-and-tack';
            }
        }

      /*property*/
          if (isset($request->search_property_category)) {
            //$searchParams->search_property_category = $request->search_property_category;
              $searchParams->selectedPropertyType = $request->search_property_category;
          
              $search_property_category = $request->search_property_category;
              $search_property_category_arr = [];
              

              for ($i=0; $i < count($request->search_property_category); $i++) { 
                $search_property_category_arr[] = \Str::slug($search_property_category[$i]);
              }
              
              $tStr = implode (DELIM_URL, $search_property_category_arr);
              
              $query_url .= DELIM_ADD.'property_type='.implode (DELIM_URL, $search_property_category_arr);
              
              $request_count += count($search_property_category_arr);
              if(count($search_property_category_arr)==1){
                $request_value = $tStr;
                $request_type = 'property-for-sale';
              }
          }

          if (isset($request->search_property_Bedrooms)) {
              $searchParams->selectedBedrooms = $request->search_property_Bedrooms;

              $search_property_Bedrooms_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_property_Bedrooms)->pluck('slug');
              $tStr = implode (DELIM_URL, \Arr::flatten($search_property_Bedrooms_DynamicField_values));

              $query_url .= DELIM_ADD.'property_bedroom='.$tStr ;
              $request_count += count($search_property_Bedrooms_DynamicField_values);
              if(count($search_property_Bedrooms_DynamicField_values)==1){
                $request_value = $tStr;
                $request_type = 'property-for-sale';
              }
          }

          if (isset($request->search_property_Bathrooms)) {
            $searchParams->search_Bathrooms = $request->search_property_Bathrooms;
              $searchParams->selectedBathrooms = $request->search_property_Bathrooms;

              $search_property_Bathrooms_DynamicField_values = DynamicFieldValues::whereIn('id',$request->search_property_Bathrooms)->pluck('slug');
              $tStr = implode (DELIM_URL, \Arr::flatten($search_property_Bathrooms_DynamicField_values));

              $query_url .= DELIM_ADD.'property_bathroom='.$tStr ;
              $request_count += count($search_property_Bathrooms_DynamicField_values);
              if(count($search_property_Bathrooms_DynamicField_values)==1){
                $request_value = $tStr;
                $request_type = 'property-for-sale';
              }
          }

      if (isset($request->search_state)) {
        $searchParams->selectedLocation = $request->search_state;
        $state = State::whereIn('id', $request->search_state)->get();
        $state_ids = '';
        foreach ($state as $key => $value) {
          //$query_url .= DELIM_MAIN.\Str::slug($value->state_name).DELIM_PRIMARY.$value->state_code;
          $state_ids .= $value->state_code.DELIM_URL;
        }
        $query_url .= DELIM_ADD.'location='.trim($state_ids,DELIM_URL);
        $request_count += count($state);
        if(count($state)==1){
          $request_value = strtolower($value->state_code);
          $request_type = 'horses-for-sale/location';
        }
      }

      $query_url .= DELIM_ADD.$sortby.DELIM_ADD.$perpage;
      
      session(['requestSource' => 'leftFilter']);

      if($request_count == 1){
        return \Redirect::to($request_type.'/'.$request_value);
      }      
      return \Redirect::to('search-listing-classifieds?'.$query_url);
    }

    public function generate_search_result(Request $request)
    {
        $searchParams = session('searchParams');
        if(empty($searchParams)) {
          $searchParams = new SearchParams;
          $searchParams->top_category = "horses";
        }
        $top_category = $searchParams->top_category;
        $sortBy = session('sortMethod');
        $perPageCnt = session('perPageCnt');
        $minPrice = $searchParams->minPrice;
        $maxPrice = $searchParams->maxPrice;
        $keywordTxt = $searchParams->keywordTxt;
        
        /*horses*/
          $selectedAge = $searchParams->selectedAge;
          $selectedBreed = $searchParams->selectedBreed;
          $selectedColor = $searchParams->selectedColor;
          $selectedDiscipline = $searchParams->selectedDiscipline;
          $selectedGender = $searchParams->selectedGender;
          $selectedHeight = $searchParams->selectedHeight;
          $selectedLocation = $searchParams->selectedLocation;
          $selectedRiderLevel = $searchParams->selectedRiderLevel;

        /*transport*/
          $selectedTransportType = $searchParams->selectedTransportType;
          $selectedHorseNumber = $searchParams->selectedHorseNumber;
          $selectedRampLocation = $searchParams->selectedRampLocation;

        /*saddlery*/
          $selectedSaddleryType = $searchParams->selectedSaddleryType;
          $selectedSaddleryCategory = $searchParams->selectedSaddleryCategory;
          $selectedSaddleryCondition = $searchParams->selectedSaddleryCondition;
            
        /*property*/
          $selectedPropertyType = $searchParams->selectedPropertyType;
          $selectedBedrooms = $searchParams->selectedBedrooms;
          $selectedBathrooms = $searchParams->selectedBathrooms;

          $search_state = [];
          $category_id = 1;
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

        $search_result = $this->getMasterListingMainQuery($category_id);
        
        if(!empty($selectedLocation))
        {
          $search_result = $search_result->whereIn('listing_master.state_id', $selectedLocation);
        }

        if(!empty($minPrice) || !empty($maxPrice))
        {
          $search_result =  $search_result->whereBetween('listing_master.price', [$minPrice, $maxPrice]);
        }

        if(!empty($keywordTxt))
        {
          $search_result =  $search_result->where(function($q) use ($keywordTxt) {
                          $q->where('listing_master.title', 'like', '%'.$keywordTxt.'%')
                            ->orWhere('listing_master.ad_id', 'like', '%'.$keywordTxt.'%');
          });
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
              $search_result = $search_result->orderBy('listing_master.title', 'ASC');
          }
          if ($sortBy == 'z_a') {
              $search_result = $search_result->orderBy('listing_master.title', 'DESC');
          }
          if ($sortBy == 'price_high_to_low') {
              $search_result = $search_result->orderBy('listing_master.price', 'DESC');
          }
          if ($sortBy == 'price_low_to_high') {
              $search_result = $search_result->orderBy('listing_master.price', 'ASC');
          }
  

        $perpage = $perPageCnt;

        $search_result = $search_result->paginate($perpage);

        if(empty($all_DynamicField_values)) {
          array_push($all_DynamicField_values, session('searchText'));
        }

        $all_DynamicField_values = \Arr::flatten($all_DynamicField_values);
        session(['userSearchText' => $all_DynamicField_values]);
        session(['requestSource' => 'leftFilter']);
        //$request->session()->put('all_DynamicField_values', $all_DynamicField_values);
        return $search_result;        
    }

    public function getTopCategory()
    {
      return $this->top_category;
    }

    private function getMasterListingQuery($category_id = '')
    {
        $master_search_result = ListingMaster::where(['is_active' => '1',
                                                      'is_approved' => '1',
                                                      'is_delete' => '0',
                                                      'category_id' => $category_id])
                                              ->join(
                                                  'listing_dynamic_field_values',
                                                  'listing_dynamic_field_values.listing_master_id','=','listing_master.id'
                                                );
        return $master_search_result;
    }

    private function getMasterListingMainQuery($category_id = '')
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
