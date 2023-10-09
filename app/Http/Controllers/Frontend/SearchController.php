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

class SearchController extends Controller
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
        )->where(['listing_master.is_active' => '1', 'listing_master.is_approved' => '1', 'listing_master.is_delete' => '0']);

        
        $searchParams = session('searchParams');
        
        $this->search_params = $searchParams;
      $topCats = session('topCategories');

      if(empty($topCats)) {
        $homeController = new MyHomeController;
        $homeController->generateSessionData();
        // $topCats = TopCategory::select('category_name', 'id')->get();
        // session(['topCategories' => $topCats]);
      }
    }

    public function topCategorySearch(Request $request, $by_category)
    {
        return $this->topCategorySearchWFilters($request, $by_category, null);
    }

    public function searchHorseForSale(Request $request)
    {
        return $this->topCategorySearchWFilters($request,'horses', null);
    }

    public function searchTransportForSale(Request $request)
    {
        return $this->topCategorySearchWFilters($request,'transport', null);
    }

    public function searchPropertyForSale(Request $request)
    {
        return $this->topCategorySearchWFilters($request,'property', null);
    }

    public function searchSaddleryAndTack(Request $request)
    {
        return $this->topCategorySearchWFilters($request,'saddlery', null);
    }

    public function topCategorySearchWFilters(Request $request, $by_category, $quick_search_type)
    {
      // since search is from header menu, all search params must reset, excep the sorting and per page count
      $searchParams = new SearchParams;
      session(['userSearchText' => 'All '. $by_category]);
      $returnParam = $by_category;

      if(!empty($quick_search_type)) {
        if($quick_search_type == "free") {
          session(['userSearchText' => 'All '. $by_category . ' where value is free']);
          $returnParam .= '-free';
          $search_result = $this->general_search_result->where('item_show_type', $quick_search_type);
        } else if($quick_search_type == "negotiable") {
          session(['userSearchText' => ('All '. $by_category . ' where value is negotiable')]);
          $returnParam .= '-negotiable';
          $search_result = $this->general_search_result->where('item_show_type', $quick_search_type);
        } else if($quick_search_type == "under1000") {
          session(['userSearchText' => 'All '. $by_category . ' where value is under $1000']);
          $returnParam .= '-under1000';
          $search_result = $this->general_search_result->where('price', '<=', 1000);
        } else if($quick_search_type == "over5000") {
          session(['userSearchText' => 'All '. $by_category . ' where value is over $5000']);
          $returnParam .= '-over5000';
          $search_result = $this->general_search_result->where('price', '>=', 5000);
        } else {
          session(['userSearchText' => 'All '. $by_category . ' where listing is added in last 24 hours']);
          $returnParam .= '-last24hours';
          $search_result = $this->general_search_result->where('listing_master.created_at', '>', Carbon::now()->subDays(1));
        }
      } else {
        //$search_result = $this->generate_search_result($request);
        if($by_category == 'horses') {
          $search_result = $this->general_search_result->where('listing_master.category_id', 1);
        } else if($by_category == 'transport') {
          $search_result = $this->general_search_result->where('listing_master.category_id', 2);
        } else if($by_category == 'saddlery') {
          $search_result = $this->general_search_result->where('listing_master.category_id', 3);
        } else if($by_category == 'property') {
          $search_result = $this->general_search_result->where('listing_master.category_id', 4);
        }
      }

      //session(['searchResultQuery' => $search_result]);

      $perpage = session('perPageCnt');
      $search_result_count = $search_result->count();

      $search_result = $search_result->paginate($perpage);

      $searchParams->top_category = $by_category;
      session(['searchParams' => $searchParams]);
      session(['search_result' => $search_result]);
      session(['requestSource'=> 'topFilter']);
      session(['TitleTxt' => '']);

      //return;
      $userSearchText = session('userSearchText');

      if(is_array($userSearchText)) {
        if(count($userSearchText)>1){
          $userSearchText = '';
        }else{
          $userSearchText = implode(', ', $userSearchText);
        }
      }
      
      if($search_result_count > 0)
      {
        return view('front.listing_results', compact('search_result', 'userSearchText'));
      }
      else
      {
        return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      }      
    }

    public function searchByLocation(Request $request, $stateCd)
    {
      $searchParams = session('searchParams');      
      
      if(empty($searchParams)) {
        $searchParams = new SearchParams;
      } else {
        $searchParams->resetSearchTerms();
      }
      //$searchParams->top_category = 'Horses';
      
      $listing_category = session()->get('listing_category');

      if(empty($listing_category)) {
        $searchParams->top_category = 'horses'; 
      }
      else{
        $searchParams->top_category = $listing_category;
      }

      $stateObj = State::where('state_code', '=', $stateCd)->first();

      if(!empty($stateObj))
      {
        $search_result = $this->general_search_result->where('listing_master.state_id', $stateObj->id);

        if($searchParams->top_category == 'horses')
        {
          $search_result = $search_result->where('listing_master.category_id', 1);
          session(['userSearchText' => 'Horses in ' . $stateObj->state_code]);
        }
        elseif($searchParams->top_category == 'transport')
        {
          $search_result = $search_result->where('listing_master.category_id', 2);
          session(['userSearchText' => 'Transport in ' . $stateObj->state_code]);
        }
        elseif($searchParams->top_category == 'saddlery')
        {
          $search_result = $search_result->where('listing_master.category_id', 3);
          session(['userSearchText' => 'Saddlery in ' . $stateObj->state_code]);
        }
        elseif($searchParams->top_category == 'property')
        {
          $search_result = $search_result->where('listing_master.category_id', 4);
          session(['userSearchText' => 'Property in ' . $stateObj->state_code]);
        }
        else{
          $searchParams = new SearchParams;
          $searchParams->top_category = 'horses';
          $search_result = $search_result->where('listing_master.category_id', 1);
          session(['userSearchText' => 'Horses in ' . $stateObj->state_code]);
        }

        array_push($searchParams->selectedLocation, $stateObj->id);
        $perpage = session('perPageCnt');
        $search_result_count = $search_result->count();        
        $search_result = $search_result->paginate($perpage);

        session(['searchParams' => $searchParams]);
        session(['search_result' => $search_result]);
        session(['requestSource' => 'bottomFilter']);
        session(['TitleTxt' => '']);
        session(['TitleTxt' => $stateObj->state_code]);

        $userSearchText = session('userSearchText');

        if(is_array($userSearchText))
        {
          if(count($userSearchText)>1){
            $userSearchText = '';
          }else{
            $userSearchText = implode(', ', $userSearchText);
          }
        }
      }else{
        $search_result = NULL;
        $userSearchText = '';
        $search_result_count = 0;
        return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      }

      return view('front.listing_results', compact('search_result', 'userSearchText'));
      
      // if($search_result_count > 0)
      // {
      //   return view('front.listing_results', compact('search_result', 'userSearchText'));
      // }
      // else
      // {
      //   return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      // }
    }

    public function searchBySuburb(Request $request, $suburb_code)
    {
      $searchParams = session('searchParams');
      if(empty($searchParams)) {
        $searchParams = new SearchParams;
      } else {
        $searchParams->resetSearchTerms();
      }
      $listing_category = session()->get('listing_category');

      if(empty($listing_category)) {
        $searchParams->top_category = 'horses'; 
      }
      else{
        $searchParams->top_category = $listing_category;
      }

      $suburbObj = Suburb::where('suburb_code', '=', $suburb_code)->first();

      if(!empty($suburbObj)){ 
        $search_result = $this->general_search_result->where('listing_master.suburb_id', $suburbObj->id);

        if($searchParams->top_category == 'horses')
        {
          session(['userSearchText' => 'Horses in ' . $suburbObj->suburb_name]);
          $search_result = $search_result->where('listing_master.category_id', 1);
        }
        elseif($searchParams->top_category == 'transport')
        {
          session(['userSearchText' => 'Transport in ' . $suburbObj->suburb_name]);
          $search_result = $search_result->where('listing_master.category_id', 2);
        }
        elseif($searchParams->top_category == 'saddlery')
        {
          session(['userSearchText' => 'Saddlery in ' . $suburbObj->suburb_name]);
          $search_result = $search_result->where('listing_master.category_id', 3);
        }
        elseif($searchParams->top_category == 'property')
        {
          session(['userSearchText' => 'Property in ' . $suburbObj->suburb_name]);
          $search_result = $search_result->where('listing_master.category_id', 4);
        }
        
        $perpage = session('perPageCnt');
        $search_result_count = $search_result->count();
        $search_result = $search_result->paginate($perpage);

        session(['searchParams' => $searchParams]);
        session(['search_result' => $search_result]);        
        session(['TitleTxt' => '']);
        session(['TitleTxt' => $suburbObj->suburb_name]);

        $userSearchText = session('userSearchText');
        
        if(is_array($userSearchText))
        {
          if(count($userSearchText) > 1){
            $userSearchText = '';
          }else{
            $userSearchText = implode(', ', $userSearchText);
          }
        }
      }else{
        $search_result = NULL;
        $userSearchText = '';
        $search_result_count = 0;
        return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      }
      
      return view('front.listing_results', compact('search_result', 'userSearchText'));

      // if($search_result_count > 0)
      // {
      //   return view('front.listing_results', compact('search_result', 'userSearchText'));
      // }
      // else
      // {
      //   return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      // }
    }

    public function searchByAttribute(Request $request, $attrNm)
    {
      $searchParams = session('searchParams');
      if(empty($searchParams)) {
        $searchParams = new SearchParams;
      } else {
        $searchParams->resetSearchTerms();
      }
      
      $searchParams->top_category = 'Horses';

      $field_ids = getFieldIds('horses');

      if($attrNm != 'foals')
      {
        $attrObj = DynamicFieldValues::where('slug', '=', $attrNm)
                                      ->whereIn('field_id',$field_ids)
                                      ->where(function ($query) {
                                        $query->Where('field_id',1)
                                              ->orWhere('field_id',2);
                                        })->first();        
      }
      else{
        $attrObj = DynamicFieldValues::where(['slug'=> 0,'field_id' => 7])
                                     ->whereIn('field_id',$field_ids)
                                     ->first();
      }

      if(!empty($attrObj)) {
        $searchParams->selectedDiscipline = explode(',',$attrObj->id);
        $searchParams->selectedBreed = explode(',',$attrObj->id);
        
        if($attrNm == 'foals'){
          $searchParams->selectedMinAge = 141;
          $searchParams->selectedMaxAge = 142;
        }

        $search_result = $this->general_search_result
                              ->join('listing_dynamic_field_values', 'listing_dynamic_field_values.listing_master_id','=','listing_master.id');

                                if($attrNm != 'foals')
                                {                                
                                  $search_result->where('listing_dynamic_field_values.dynamic_field_id', $attrObj->id);
                                }
                                else{
                                  $search_result->where('listing_dynamic_field_values.dynamic_field_id', 141);
                                  $search_result->orWhere('listing_dynamic_field_values.dynamic_field_id', 142);
                                }
        
        if($attrNm != 'foals')
        {
          session(['userSearchText' => $attrObj->field_value.' horses']);
        }
        else{
          session(['userSearchText' => '0'.' horses']);
        }
        
        $search_result_count = $search_result->count();

        $perpage = session('perPageCnt');
        $search_result = $search_result->paginate($perpage);
        
        session(['searchParams' => $searchParams]);
        session(['search_result' => $search_result]);
        session(['requestSource' => 'bottomFilter']);
        session(['TitleTxt' => '']);
        session(['TitleTxt' => $attrNm]);

        $userSearchText = session('userSearchText');
       
        if(is_array($userSearchText)) {
          if(count($userSearchText) > 1){
            $userSearchText = '';
          }else{
            $userSearchText = implode(', ', $userSearchText);
          }
        }
      } else {
        $search_result = NULL;
        $userSearchText = '';
        $search_result_count = 0;
        return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      }

      return view('front.listing_results', compact('search_result', 'userSearchText'));

      // if($search_result_count > 0)
      // {
      //   return view('front.listing_results', compact('search_result', 'userSearchText'));
      // }
      // else
      // {
      //   return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      // }
    }

    public function searchBySaddleryAttr(Request $request, $attrNm)
    {
      $searchParams = session('searchParams');
      if(empty($searchParams)) {
        $searchParams = new SearchParams;
      } else {
        $searchParams->resetSearchTerms();
      }
      
      $searchParams->top_category = 'saddlery';

      $field_ids = getFieldIds('saddlery');
      $attrObj = DynamicFieldValues::where('slug', '=', $attrNm)
                                   ->whereIn('field_id',$field_ids)
                                   ->first();

      if(!empty($attrObj)) {
        $searchParams->selectedSaddleryCategory = explode(',',$attrObj->id);
        $searchParams->selectedSaddleryCondition = explode(',',$attrObj->id);
        $search_result = $this->general_search_result
                              ->join('listing_dynamic_field_values', 'listing_dynamic_field_values.listing_master_id','=','listing_master.id')
                              ->where('listing_dynamic_field_values.dynamic_field_id', $attrObj->id);
      
        session(['userSearchText' => $attrObj->field_value.' saddlery']);
      
        $perpage = session('perPageCnt');

        $search_result_count = $search_result->count();

        $search_result = $search_result->paginate($perpage);
        
        session(['searchParams' => $searchParams]);
        session(['search_result' => $search_result]);
        session(['requestSource' => 'bottomFilter']);
        $userSearchText = session('userSearchText');
       
        if(is_array($userSearchText)) {
          if(count($userSearchText)>1){
            $userSearchText = '';
          }else{
            $userSearchText = implode(', ', $userSearchText);
          }
        }
      } else {
        $search_result = NULL;
        $userSearchText = '';
        $search_result_count = 0;
      }

      if($search_result_count > 0)
      {
        return view('front.listing_results', compact('search_result', 'userSearchText'));
      }
      else
      {
        return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      }
    }

    public function searchByPropertyAttribute(Request $request, $attrNm)
    {
      $searchParams = session('searchParams');
      if(empty($searchParams)) {
        $searchParams = new SearchParams;
      } else {
        $searchParams->resetSearchTerms();
      }
      
      $searchParams->top_category = 'property';

      $field_ids = getFieldIds('property');
      $attrObj = DynamicFieldValues::where('slug', '=', $attrNm)->whereIn('field_id',$field_ids)->first();

      if(!empty($attrObj)) {
        $searchParams->selectedBedrooms = explode(',',$attrObj->id);
        $searchParams->selectedBathrooms = explode(',',$attrObj->id);

        $search_result = $this->general_search_result
                              ->join('listing_dynamic_field_values', 'listing_dynamic_field_values.listing_master_id','=','listing_master.id')
                              ->where('listing_dynamic_field_values.dynamic_field_id', $attrObj->id);
      
        session(['userSearchText' => $attrObj->field_value.' property']);
        
        $perpage = session('perPageCnt');
        $search_result_count = $search_result->count();
        $search_result = $search_result->paginate($perpage);
        
        session(['searchParams' => $searchParams]);
        session(['search_result' => $search_result]);
        session(['requestSource' => 'bottomFilter']);
        $userSearchText = session('userSearchText');
       
        if(is_array($userSearchText)) {
          if(count($userSearchText)>1){
            $userSearchText = '';
          }else{
            $userSearchText = implode(', ', $userSearchText);
          }
        }
      } else {

        if($attrNm == 'na' || $attrNm == 'agistment' || $attrNm == 'for-lease' || $attrNm == 'for-sale')
        {          
          $perpage = session('perPageCnt');
          if($attrNm == 'na'){
            $attrNm = 'N/A';
          }elseif($attrNm == 'agistment'){
            $attrNm = 'Agistment';
          }elseif($attrNm == 'for-lease'){
            $attrNm = 'For lease';
          }elseif($attrNm =='for-sale'){
            $attrNm = 'For sale';
          }

          $searchParams->selectedPropertyType = explode(',',$attrNm);
          $search_result = $this->general_search_result->where('listing_master.property_category',$attrNm)->paginate($perpage);
          if($search_result->count()){
            session(['userSearchText' => $attrNm.' property']);
            session(['searchParams' => $searchParams]);
            session(['search_result' => $search_result]);
            session(['requestSource' => 'bottomFilter']);
            $userSearchText = session('userSearchText');
          }else{
            $search_result = NULL;
            $userSearchText = '';
            $search_result_count = 0;          
          }
        }
        else{
          $search_result = NULL;
          $userSearchText = '';
          $search_result_count = 0;
          return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
        }
      }

      return view('front.listing_results', compact('search_result', 'userSearchText'));

      // if($search_result_count > 0)
      // {
      //   return view('front.listing_results', compact('search_result', 'userSearchText'));
      // }
      // else
      // {
      //   return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      // }
    }

    public function searchByTransportAttribute(Request $request, $attrNm)
    {
      $searchParams = session('searchParams');
      if(empty($searchParams)) {
        $searchParams = new SearchParams;
      } else {
        //$searchParams->resetSearchTerms();
      }
      
      $searchParams->top_category = 'transport';

      $field_ids = getFieldIds('transport');
      $attrObj = DynamicFieldValues::where('slug', '=', $attrNm)->whereIn('field_id',$field_ids)->first();

      if(!empty($attrObj)) {
        $searchParams->selectedTransportType = explode(',',$attrObj->id);
        $searchParams->selectedHorseNumber = explode(',',$attrObj->id);
        $searchParams->selectedRampLocation = explode(',',$attrObj->id);
        $search_result = $this->general_search_result
                              ->join('listing_dynamic_field_values', 'listing_dynamic_field_values.listing_master_id','=','listing_master.id')
                              ->where('listing_dynamic_field_values.dynamic_field_id', $attrObj->id);
      
          session(['userSearchText' => $attrObj->field_value.' transport']);
        
        $perpage = session('perPageCnt');
        $search_result_count = $search_result->count();
        $search_result = $search_result->paginate($perpage);
        
        session(['searchParams' => $searchParams]);
        session(['search_result' => $search_result]);
        session(['requestSource' => 'bottomFilter']);
        session(['TitleTxt' => '']);
        session(['TitleTxt' => $attrObj->field_value]);        
        $userSearchText = session('userSearchText');
       
        if(is_array($userSearchText)) {
          if(count($userSearchText)>1){
            $userSearchText = '';
          }else{
            $userSearchText = implode(', ', $userSearchText);
          }
        }
      } else {
        $search_result = NULL;
        $userSearchText = '';
        $search_result_count = 0;
      }

      if($search_result_count > 0)
      {
        return view('front.listing_results', compact('search_result', 'userSearchText'));
      }
      else
      {
        return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      }
    }

    public function searchByRampLocation(Request $request, $attrNm)
    {
      $searchParams = session('searchParams');
      if(empty($searchParams)) {
        $searchParams = new SearchParams;
      } else {
        $searchParams->resetSearchTerms();
      }
      
      $searchParams->top_category = 'transport';

      $field_ids = getFieldIds('transport');
      $attrObj = DynamicFieldValues::where(['field_id' => 12, 'slug' => $attrNm])
                                    ->first();

      if(!empty($attrObj))
      {
        $searchParams->selectedRampLocation = explode(',',$attrObj->id);
        $search_result = $this->general_search_result
                              ->join('listing_dynamic_field_values', 'listing_dynamic_field_values.listing_master_id','=','listing_master.id')
                              ->where('listing_dynamic_field_values.dynamic_field_id', $attrObj->id);
      
        session(['userSearchText' => $attrObj->field_value.' transport']);
        
        $perpage = session('perPageCnt');
        $search_result_count = $search_result->count();
        $search_result = $search_result->paginate($perpage);
        
        session(['searchParams' => $searchParams]);
        session(['search_result' => $search_result]);
        session(['TitleTxt' => '']);
        session(['TitleTxt' => $attrNm]);
        $userSearchText = session('userSearchText');
       
        if(is_array($userSearchText)) {
          if(count($userSearchText)>1){
            $userSearchText = '';
          }else{
            $userSearchText = implode(', ', $userSearchText);
          }
        }
      } else {
        $search_result = NULL;
        $userSearchText = '';
        $search_result_count = 0;
        return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      }
      
      return view('front.listing_results', compact('search_result', 'userSearchText'));

      // if($search_result_count > 0)
      // {
      //   return view('front.listing_results', compact('search_result', 'userSearchText'));
      // }
      // else
      // {
      //   return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      // }
    }

    public function searchByRampAxles(Request $request, $attrNm)
    {
      $searchParams = session('searchParams');
      if(empty($searchParams)) {
        $searchParams = new SearchParams;
      } else {
        $searchParams->resetSearchTerms();
      }
      
      $searchParams->top_category = 'transport';

      $field_ids = getFieldIds('transport');
      $attrObj = DynamicFieldValues::where(['field_id' => 13, 'slug' => $attrNm])->first();      
      
      if(!empty($attrObj))
      {
        $search_result = $this->general_search_result
                              ->join('listing_dynamic_field_values', 'listing_dynamic_field_values.listing_master_id','=','listing_master.id')
                              ->where('listing_dynamic_field_values.dynamic_field_id', $attrObj->id);

        session(['userSearchText' => $attrObj->field_value.' transport']);
        
        $perpage = session('perPageCnt');
        $search_result_count = $search_result->count();        
        $search_result = $search_result->paginate($perpage);
        
        session(['searchParams' => $searchParams]);
        session(['search_result' => $search_result]);
        session(['TitleTxt' => '']);
        session(['TitleTxt' => 'Axles '.$attrNm]);
        $userSearchText = session('userSearchText');
       
        if(is_array($userSearchText)) {
          if(count($userSearchText) > 1){
            $userSearchText = '';
          }else{
            $userSearchText = implode(', ', $userSearchText);
          }
        }
      } else {
        $search_result = NULL;
        $userSearchText = '';
        $search_result_count = 0;
        return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      }

      return view('front.listing_results', compact('search_result', 'userSearchText'));

      // if($search_result_count > 0)
      // {
      //   return view('front.listing_results', compact('search_result', 'userSearchText'));
      // }
      // else
      // {
      //   return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      // }
    }

    public function searchByRegistrationState(Request $request, $attrNm)
    {
      $searchParams = session('searchParams');
      if(empty($searchParams)) {
        $searchParams = new SearchParams;
      } else {
        $searchParams->resetSearchTerms();
      }
      
      $searchParams->top_category = 'transport';

      $field_ids = getFieldIds('transport');
      $attrObj = DynamicFieldValues::where(['field_id' => 14, 'slug' => $attrNm])->first();      
      
      if(!empty($attrObj))
      {
        $search_result = $this->general_search_result
                              ->join('listing_dynamic_field_values', 'listing_dynamic_field_values.listing_master_id','=','listing_master.id')
                              ->where('listing_dynamic_field_values.dynamic_field_id', $attrObj->id);
      
        session(['userSearchText' => $attrObj->field_value.' transport']);
        
        $perpage = session('perPageCnt');
        $search_result_count = $search_result->count();
        $search_result = $search_result->paginate($perpage);
        
        session(['searchParams' => $searchParams]);
        session(['search_result' => $search_result]);
        session(['TitleTxt' => '']);
        session(['TitleTxt' => $attrNm]);
        $userSearchText = session('userSearchText');
       
        if(is_array($userSearchText)) {
          if(count($userSearchText)>1){
            $userSearchText = '';
          }else{
            $userSearchText = implode(', ', $userSearchText);
          }
        }
      } else {
        $search_result = NULL;
        $userSearchText = '';
        $search_result_count = 0;
        return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      }

      return view('front.listing_results', compact('search_result', 'userSearchText'));

      // if($search_result_count > 0)
      // {
      //   return view('front.listing_results', compact('search_result', 'userSearchText'));
      // }
      // else
      // {
      //   return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      // }
    }

    public function searchByAge(Request $request, $attrNm)
    {
      $searchParams = session('searchParams');
      if(empty($searchParams)) {
        $searchParams = new SearchParams;
      } else {
        //$searchParams->resetSearchTerms();
      }
      $searchParams->top_category = 'Horses';

      $attrObj = DynamicFieldValues::where('slug', '=', $attrNm)->first();

      if(!empty($attrObj)) {
        $search_result = $this->general_search_result
                              ->join('listing_dynamic_field_values', 'listing_dynamic_field_values.listing_master_id','=','listing_master.id')
                              ->where('listing_dynamic_field_values.dynamic_field_id', $attrObj->id);

        //array_push($searchParams->selectedLocation, $stateObj->id);
        $perpage = session('perPageCnt');
        $search_result_count = $search_result->count();
        $search_result = $search_result->paginate($perpage);
        
        $searchParams->selectedMinAge = $attrObj->id;
        session(['searchParams' => $searchParams]);
        session(['search_result' => $search_result]);
        session(['userSearchText' => 'All Horses for sale with age as ' . $attrNm]);
        session(['requestSource' => 'bottomFilter']);
        $userSearchText = session('userSearchText');
       
        if(is_array($userSearchText)) {
          if(count($userSearchText)>1){
            $userSearchText = '';
          }else{
            $userSearchText = implode(', ', $userSearchText);
          }
        }
      }else{
        $search_result = NULL;
        $userSearchText = '';
        $search_result_count = 0;
      }

      if($search_result_count > 0)
      {
        return view('front.listing_results', compact('search_result', 'userSearchText'));
      }
      else
      {
        return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      }
    }

    public function searchByGender(Request $request, $attrNm)
    {
      $searchParams = session('searchParams');
      if(empty($searchParams)) {
        $searchParams = new SearchParams;
      } else {
        $searchParams->resetSearchTerms();
      }
      $searchParams->top_category = 'Horses';

      $field_ids = getFieldIds('horses');
      $attrObj = DynamicFieldValues::where('slug', '=', $attrNm)
                                   ->whereIn('field_id',$field_ids)
                                   ->first();

      if(!empty($attrObj))
      {
        $searchParams->selectedGender = explode(',',$attrObj->id);
        $search_result = $this->general_search_result
                              ->join('listing_dynamic_field_values', 'listing_dynamic_field_values.listing_master_id','=','listing_master.id')
                              ->where('listing_dynamic_field_values.dynamic_field_id', $attrObj->id)
                              ->where('listing_dynamic_field_values.field_id', 5);

        //array_push($searchParams->selectedLocation, $stateObj->id);
        $perpage = session('perPageCnt');
        $search_result_count = $search_result->count();
        $search_result = $search_result->paginate($perpage);
        
        array_push($searchParams->selectedGender, $attrObj->id);
        session(['searchParams' => $searchParams]);
        session(['search_result' => $search_result]);
        session(['userSearchText' => $attrNm.' horses']);
        session(['requestSource' => 'bottomFilter']);
        session(['TitleTxt' => '']);
        session(['TitleTxt' => $attrNm]);

        $userSearchText = session('userSearchText');
       
        if(is_array($userSearchText)) {
          if(count($userSearchText)>1){
            $userSearchText = '';
          }else{
            $userSearchText = implode(', ', $userSearchText);
          }
        }
      }else{
        $search_result = NULL;
        $userSearchText = '';
        $search_result_count = 0;
        return response(['error' => true, 'error-msg' => 'Not found'], abort(404));        
      }

      return view('front.listing_results', compact('search_result', 'userSearchText'));

      // if($search_result_count > 0)
      // {
      //   return view('front.listing_results', compact('search_result', 'userSearchText'));
      // }
      // else
      // {
      //   return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      // }
    }

    public function searchByColour(Request $request, $attrNm)
    {
      $searchParams = session('searchParams');
      if(empty($searchParams)) {
        $searchParams = new SearchParams;
      } else {
        $searchParams->resetSearchTerms();
      }
      $searchParams->top_category = 'Horses';

      $field_ids = getFieldIds('horses');
      $attrObj = DynamicFieldValues::where('slug', '=', $attrNm)->whereIn('field_id',$field_ids)->first();

      if(!empty($attrObj)) {
        $searchParams->selectedColor = explode(',',$attrObj->id);
        $search_result = $this->general_search_result
                              ->join('listing_dynamic_field_values', 'listing_dynamic_field_values.listing_master_id','=','listing_master.id')
                              ->where('listing_dynamic_field_values.dynamic_field_id', $attrObj->id)
                              ->where('listing_dynamic_field_values.field_id', 4);

        //array_push($searchParams->selectedLocation, $stateObj->id);
        $perpage = session('perPageCnt');
        $search_result_count = $search_result->count();
        $search_result = $search_result->paginate($perpage);
        
        array_push($searchParams->selectedColor, $attrObj->id);
        session(['searchParams' => $searchParams]);
        session(['search_result' => $search_result]);
        session(['userSearchText' => $attrNm.' horses']);
        session(['requestSource' => 'bottomFilter']);
        session(['TitleTxt' => '']);
        session(['TitleTxt' => $attrNm]);
        $userSearchText = session('userSearchText');
       
        if(is_array($userSearchText)) {
          if(count($userSearchText)>1){
            $userSearchText = '';
          }else{
            $userSearchText = implode(', ', $userSearchText);
          }
        }
      }else{
        $search_result = NULL;
        $userSearchText = '';
        $search_result_count = 0;
        return response(['error' => true, 'error-msg' => 'Not found'], abort(404));        
      }

      return view('front.listing_results', compact('search_result', 'userSearchText'));

      // if($search_result_count > 0)
      // {
      //   return view('front.listing_results', compact('search_result', 'userSearchText'));
      // }
      // else
      // {
      //   return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      // }
    }

    public function searchByRiderLevel(Request $request, $attrNm)
    {
      $searchParams = session('searchParams');
      if(empty($searchParams)) {
        $searchParams = new SearchParams;
      } else {
        $searchParams->resetSearchTerms();
      }
      $searchParams->top_category = 'Horses';

      $field_ids = getFieldIds('horses');
      $attrObj = DynamicFieldValues::where('slug', '=', $attrNm)->whereIn('field_id',$field_ids)->first();

      if(!empty($attrObj)){
        $searchParams->selectedRiderLevel = explode(',',$attrObj->id);
        $search_result = $this->general_search_result
                              ->join('listing_dynamic_field_values', 'listing_dynamic_field_values.listing_master_id','=','listing_master.id')
                              ->where('listing_dynamic_field_values.dynamic_field_id', $attrObj->id);

        //array_push($searchParams->selectedLocation, $stateObj->id);
        $perpage = session('perPageCnt');
        $search_result_count = $search_result->count();
        $search_result = $search_result->paginate($perpage);
        
        array_push($searchParams->selectedRiderLevel, $attrObj->id);
        session(['searchParams' => $searchParams]);
        session(['search_result' => $search_result]);
        session(['userSearchText' => $attrNm.' horses']);
        session(['requestSource' => 'bottomFilter']);
        session(['TitleTxt' => '']);
        session(['TitleTxt' => $attrNm]);
        $userSearchText = session('userSearchText');
       
        if(is_array($userSearchText)) {
          if(count($userSearchText)>1){
            $userSearchText = '';
          }else{
            $userSearchText = implode(', ', $userSearchText);
          }
        }
      }else{
        $search_result = NULL;
        $userSearchText = '';
        $search_result_count = 0;
        return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      }
      
      return view('front.listing_results', compact('search_result', 'userSearchText'));

      // if($search_result_count > 0)
      // {
      //   return view('front.listing_results', compact('search_result', 'userSearchText'));
      // }
      // else
      // {
      //   return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      // }
    }

    public function searchFieldByHeight(Request $request, $attrNm)
    {
      $searchParams = session('searchParams');
      if(empty($searchParams)) {
        $searchParams = new SearchParams;
      } else {
        //$searchParams->resetSearchTerms();
      }

      $searchParams->top_category = 'Horses';

      $attrObj = DynamicFieldValues::where(['field_id' => 9,'slug' => $attrNm])->first();

      if(!empty($attrObj))
      {
        $search_result = $this->general_search_result
                              ->join('listing_dynamic_field_values', 'listing_dynamic_field_values.listing_master_id','=','listing_master.id')
                              ->where('listing_dynamic_field_values.dynamic_field_id', $attrObj->id)
                              ->where('listing_dynamic_field_values.field_id', 9);
        
        $perpage = session('perPageCnt');
        $search_result_count = $search_result->count();
        $search_result = $search_result->paginate($perpage);
        
        $searchParams->selectedMinHeight = $attrObj->id;
        session(['searchParams' => $searchParams]);
        session(['search_result' => $search_result]);
        session(['TitleTxt' => '']);
        session(['TitleTxt' => $attrObj->field_value]);        
        session(['userSearchText' => 'All Horses for sale with Height as ' . $attrObj->field_value]);      
        $userSearchText = session('userSearchText');
       
        if(is_array($userSearchText)) {
          if(count($userSearchText)>1){
            $userSearchText = '';
          }else{
            $userSearchText = implode(', ', $userSearchText);
          }
        }

        if($search_result_count > 0)
        {
          return view('front.listing_results', compact('search_result', 'userSearchText'));
        }
        else
        {
          return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
        }
      }
      else{
        return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      }
    }

    public function searchFieldMaxByHeight(Request $request, $attrNm)
    {
      $searchParams = session('searchParams');
      if(empty($searchParams)) {
        $searchParams = new SearchParams;
      } else {
        //$searchParams->resetSearchTerms();
      }

      $searchParams->top_category = 'Horses';

      $attrObj = DynamicFieldValues::where(['field_id' => 9,'slug' => $attrNm])->first();

      if(!empty($attrObj))
      {
        $search_result = $this->general_search_result
                              ->join('listing_dynamic_field_values', 'listing_dynamic_field_values.listing_master_id','=','listing_master.id')
                              ->where('listing_dynamic_field_values.dynamic_field_id', $attrObj->id)
                              ->where('listing_dynamic_field_values.field_id', 9);
        
        $perpage = session('perPageCnt');
        $search_result_count = $search_result->count();
        $search_result = $search_result->paginate($perpage);
        
        $searchParams->selectedMaxHeight = $attrObj->id;
        
        session(['searchParams' => $searchParams]);
        session(['search_result' => $search_result]);
        session(['TitleTxt' => '']);
        session(['TitleTxt' => $attrObj->field_value]); 
        session(['userSearchText' => 'All Horses for sale with Height as ' . $attrObj->field_value]);      
        $userSearchText = session('userSearchText');
       
        if(is_array($userSearchText)) {
          if(count($userSearchText)>1){
            $userSearchText = '';
          }else{
            $userSearchText = implode(', ', $userSearchText);
          }
        }

        if($search_result_count > 0)
        {
          return view('front.listing_results', compact('search_result', 'userSearchText'));
        }
        else
        {
          return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
        }
      }
      else{
        return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      }
    }

    public function searchBySaddleryType(Request $request, $attrNm)
    {
      $searchParams = session('searchParams');
      if(empty($searchParams)) {
        $searchParams = new SearchParams;
      } else {
        //$searchParams->resetSearchTerms();
      }
      $searchParams->top_category = 'saddlery';

      $field_ids = getFieldIds('saddlery');
      $attrObj = DynamicFieldValues::where('slug', '=', $attrNm)->whereIn('field_id',$field_ids)->first();

      if(!empty($attrObj)){
        $searchParams->selectedSaddleryType = explode(',',$attrObj->id);
        $search_result = $this->general_search_result
                              ->join('listing_dynamic_field_values', 'listing_dynamic_field_values.listing_master_id','=','listing_master.id')
                              ->where('listing_dynamic_field_values.dynamic_field_id', $attrObj->id);

        //array_push($searchParams->selectedLocation, $stateObj->id);
        $perpage = session('perPageCnt');
        $search_result_count = $search_result->count();
        $search_result = $search_result->paginate($perpage);
        
        array_push($searchParams->selectedSaddleryType, $attrObj->id);
        session(['searchParams' => $searchParams]);
        session(['search_result' => $search_result]);
        session(['userSearchText' => $attrNm.' saddlery']);
        session(['TitleTxt' => '']);
        session(['TitleTxt' => $attrObj->field_value]);
        $userSearchText = session('userSearchText');
       
        if(is_array($userSearchText)) {
          if(count($userSearchText)>1){
            $userSearchText = '';
          }else{
            $userSearchText = implode(', ', $userSearchText);
          }
        }
      }else{
        $search_result = NULL;
        $userSearchText = '';
        $search_result_count = 0;
        return response(['error' => true, 'error-msg' => 'Not found'], abort(404));        
      }
      
      return view('front.listing_results', compact('search_result', 'userSearchText'));

      // if($search_result_count > 0)
      // {
      //   return view('front.listing_results', compact('search_result', 'userSearchText'));
      // }
      // else
      // {
      //   return response(['error' => true, 'error-msg' => 'Not found'], abort(404));
      // }
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
