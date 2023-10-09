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
use Illuminate\Support\Arr;

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


class SearchResultController extends Controller
{
  public $listing_master;
  public $listing_meta;

  public function __construct(ListingMaster $listing_master,ListingMeta $listing_meta)
  {
    $this->listing_master = $listing_master;
    $this->listing_meta   = $listing_meta;
  }

  public function search_result(Request $request)
  {
    $listing = '';
    $top_category = '';

    $discipline = '';
    $breed = '';
    $sex = '';

    $transport_type = '';
    $transport_horse_number = '';
    $transport_ramp_location = '';

    $saddlery_type = '';
    $saddlery_category = '';

    $property_Bathrooms = '';
    $property_Bedrooms = '';

    $search_discipline  = [];
    $search_breed_primary  = [];
    $search_height = [];
    $search_age = [];
    $search_gender = [];
    $search_rider_Level = [];
    $search_color = [];
    $search_state = [];
    $sortby = '';
    $cnt = 0;
    $where = [];

    $all_top_categories = TopCategory::get();

    $get_deynemic_values = $this->listing_master->get_deynemic_fileds('horses');
    $all_state = State::get();

    if(isset($request->perpage))
    {
      $perpage = $request->perpage;
    }
    else{
      $perpage = 20;
    }

    if(isset($request->listing) && !empty($request->listing))
    {
      array_push($where,'1');
      $listing = $request->listing;
    }

    if(isset($request->sortby))
    {
      array_push($where,'2');
      if($request->sortby == 'featured' || $request->sortby == 'latest')
      {
        array_push($where,'2-1');
        $listing = $request->sortby;
      }
    }

    if(isset($request->price_min) || isset($request->price_max))
    {
      array_push($where,'3');
      if(empty($request->price_min))
      {
        array_push($where,'4');
        $min_price = ListingMaster::min('price');
      }
      else
      {
        array_push($where,'5');
        $min_price = $request->price_min;
      }
      if(empty($request->price_max))
      {
        array_push($where,'6');
        $max_price = ListingMaster::max('price');
      }
      else{
        array_push($where,'7');
        $max_price = $request->price_max;
      }
    }

    $search_result = ListingMaster::select( 'listing_master.id as listing_id',
                                              'listing_master.category_id as listing_category_id',
                                              'listing_master.title as listing_title',
                                              'listing_master.price as listing_price',
                                              'listing_master.state_id as state_id',
                                              'listing_master.suburb_id as suburb_id',
                                              'listing_master.description as listing_description',
                                              'listing_master.identification_code as listing_identification_code',
                                              'listing_master.slug as slug_url',
                                              'listing_master.item_show_type as item_show_type')
                                    ->where(['is_active' => '1', 'is_approved' => '1', 'is_delete' => '0']);
    if($listing == 'featured')
    {
      array_push($where,'8');
      $search_result = $search_result->whereIn('listing_master.id', function($q){
                                        $q->select('listing_master_id')
                                          ->from('featured_listings');
                                      });
    }

    if($listing == 'latest')
    {
      array_push($where,'9');
      $search_result = $search_result->whereIn('listing_master.id', function($q){
                                        $q->select('listing_master_id')
                                        ->from('latest_listings');
                                      });
    }

    if(isset($request->price_min) || isset($request->price_max))
    {
      array_push($where,'10');
      $search_result = $search_result->whereBetween('listing_master.price', [$min_price, $max_price]);
    }

    if(isset($request->state))
    {
      array_push($where,'11');
      if($request->state == 'all_state')
      {
        array_push($where,'11-1');
        $search_result = $search_result->whereIn('listing_master.state_id', function($q){
                                        $q->select('id')
                                        ->from('state');
                                      });
      }
      else{
        array_push($where,'12');
        array_push($search_state, (int)$request->state);
        $search_result = $search_result->where('listing_master.state_id',$request->state);
      }
    }

    if(isset($request->search_state))
    {
      array_push($where,'13');
      $search_state = $request->search_state;
      $search_result = $search_result->where('listing_master.state_id',$search_state);
    }

    if(isset($request->quick_search_type))
    {
      array_push($where,'15');
      $quick_search = '';
      if($request->quick_search_type == 'free' || $request->quick_search_type == 'negotiable')
      {
        array_push($where,'16');
        $quick_search = $request->quick_search_type;
        $search_result = $search_result->where('item_show_type',$quick_search);
      }
      elseif($request->quick_search_type == 'under1000')
      {
        array_push($where,'17');
        $search_result = $search_result->where('price','<=',1000);
      }
      elseif($request->quick_search_type == 'over5000')
      {
        array_push($where,'18');
        $search_result = $search_result->where('price','>=', 5000);
      }
      elseif($request->quick_search_type == 'last24hours')
      {
        array_push($where,'19');
        $search_result = $search_result->where('listing_master.created_at','>', Carbon::now()->subDays(1));
      }
    }

    if(isset($request->category) || isset($request->by_category))
    {
      array_push($where,'19-1');
      $top_category = isset($request->category) ? $request->category : $request->by_category;
    }

    /*Horases*/
      if($top_category == 'horses' || $top_category == 'Horses')
      {
        array_push($where,'20');
        $search_result = $search_result->where('listing_master.category_id',1);

        if(isset($request->discipline) || isset($request->breed) || isset($request->sex))
        {
          array_push($where,'21');
          $cnt++;
          if(isset($request->discipline))
          {
            array_push($where,'22');
            array_push($search_discipline, $request->discipline);
            $discipline = $request->discipline;
          }
          if(isset($request->breed))
          {
            array_push($where,'23');
            array_push($search_breed_primary, $request->breed);
            $breed = $request->breed;
          }
          if(isset($request->sex))
          {
            array_push($where,'24');
            array_push($search_gender, $request->sex);
            $sex = $request->sex;
          }
            $search_result = $search_result->join('listing_dynamic_field_values',
                                                    function($join) use ($discipline, $breed, $sex,$where)
                                            {
                                              $join->on('listing_dynamic_field_values.listing_master_id','=','listing_master.id');
                                              $join->where(function($query) use ($discipline, $breed, $sex,$where){

                                                if($discipline != ''){
                                                  array_push($where,'22-1');
                                                  $query->orWhere('dynamic_field_id','=',$discipline);
                                                }

                                                if($breed != ''){
                                                  array_push($where,'22-2');
                                                  $query->orWhere('dynamic_field_id','=',$breed);
                                                }

                                                if($sex != ''){
                                                  array_push($where,'22-3');
                                                  $query->orWhere('dynamic_field_id','=',$sex);
                                                }
                                                // if($discipline == 'all_discipline'){
                                                //   $query->orWhere('field_id','=',1);
                                                // }
                                                // else{
                                                //   $query->orWhere('dynamic_field_id','=',$discipline);
                                                // }

                                                // if($breed == 'all_breed'){
                                                //   $query->orWhere('field_id','=',2);
                                                // }
                                                // else{
                                                //   $query->orWhere('dynamic_field_id','=',$breed);
                                                // }

                                                // if($sex == 'all_sex'){
                                                //   $query->orWhere('field_id','=',5);
                                                // }
                                                // else{
                                                //   $query->orWhere('dynamic_field_id','=',$sex);
                                                // }
                                              });
                                            });
        }
        if(isset($request->search_discipline) || isset($request->search_breed_primary) || isset($request->search_height)|| isset($request->search_age) || isset($request->search_gender) || isset($request->search_rider_Level) ||   isset($request->search_color))
        {
          array_push($where,'25');
          $cnt++;

          $listing_dynamic_field_ids = array();

          if(isset($request->search_discipline))
          {
            array_push($where,'26');
            array_push($search_discipline, $request->search_discipline);
            array_push($listing_dynamic_field_ids, $search_discipline);
          }
          if(isset($request->search_breed_primary))
          {
            array_push($where,'27');
            array_push($search_breed_primary, $request->search_breed_primary);
            array_push($listing_dynamic_field_ids, $search_breed_primary);
          }
          if(isset($request->search_height))
          {
            array_push($where,'28');
            array_push($search_height, $request->search_height);
            array_push($listing_dynamic_field_ids, $search_height);
          }
          if(isset($request->search_age))
          {
            array_push($where,'29');
            array_push($search_age, $request->search_age);
            array_push($listing_dynamic_field_ids, $search_age);
          }
          if(isset($request->search_gender))
          {
            array_push($where,'30');
            array_push($search_gender, $request->search_gender);
            array_push($listing_dynamic_field_ids, $search_gender);
          }
          if(isset($request->search_rider_Level))
          {
            array_push($where,'31');
            array_push($search_rider_Level, $request->search_rider_Level);
            array_push($listing_dynamic_field_ids, $search_rider_Level);
          }
          if(isset($request->search_color))
          {
            array_push($where,'32');
            array_push($search_color, $request->search_color);
            array_push($listing_dynamic_field_ids, $search_color);
          }

          $search_discipline = Arr::flatten($search_discipline);
          $search_breed_primary = Arr::flatten($search_breed_primary);
          $search_height = Arr::flatten($search_height);
          $search_age = Arr::flatten($search_age);
          $search_gender = Arr::flatten($search_gender);
          $search_rider_Level = Arr::flatten($search_rider_Level);
          $search_color = Arr::flatten($search_color);
          $listing_dynamic_field_ids = Arr::flatten($listing_dynamic_field_ids);

          $search_result = $search_result->join('listing_dynamic_field_values',
                                                    function($join) use ( $listing_dynamic_field_ids)
                                            {
                                              $join->on('listing_dynamic_field_values.listing_master_id','=','listing_master.id');
                                              if(!empty($listing_dynamic_field_ids))
                                              {
                                                $join->whereIn('listing_dynamic_field_values.dynamic_field_id',$listing_dynamic_field_ids);
                                              }
                                            });
        }
      }

    /*Transport*/
      if($top_category == 'transport' || $top_category == 'Transport')
      {
        array_push($where,'Transport');
        $search_result = $search_result->where('listing_master.category_id',2);

        if(isset($request->transport_type) && isset($request->transport_horse_number) && isset($request->transport_ramp_location))
        {
          $cnt++;

          if(isset($request->transport_type))
          {
            $transport_type = $request->all_transport_type;
          }
          if(isset($request->transport_horse_number))
          {
            $transport_horse_number = $request->transport_horse_number;
          }
          if(isset($request->transport_ramp_location))
          {
            $transport_ramp_location = $request->transport_ramp_location;
          }
          $search_result = $search_result->join('listing_dynamic_field_values',
                                                  function($join) use ($transport_type, $transport_horse_number,
                                                                        $transport_ramp_location)
                                          {
                                            $join->on('listing_dynamic_field_values.listing_master_id','=','listing_master.id');
                                            $join->where(function($query) use ($transport_type, $transport_horse_number,
                                                                        $transport_ramp_location){

                                              if($transport_type != ''){
                                                $query->orWhere('dynamic_field_id','=',$transport_type);
                                              }
                                              if($transport_horse_number != ''){
                                                $query->orWhere('dynamic_field_id','=',$transport_horse_number);
                                              }
                                              if($transport_ramp_location != ''){
                                                $query->orWhere('dynamic_field_id','=',$transport_ramp_location);
                                              }
                                            });
                                          });
        }
      }

    /*Saddlery*/
      if($top_category == 'saddlery' || $top_category == 'Saddlery')
      {
         array_push($where,'Saddlery');
        $search_result = $search_result->where('listing_master.category_id',3);

        if(isset($request->saddlery_type) && isset($request->saddlery_category))
        {
          $cnt++;

          if(isset($request->saddlery_type))
          {
            $saddlery_type = $request->all_saddlery_type;
          }
          if(isset($request->saddlery_category))
          {
            $saddlery_category = $request->saddlery_category;
          }
          $search_result = $search_result->join('listing_dynamic_field_values',
                                                  function($join) use ($saddlery_type, $saddlery_category)
                                          {
                                            $join->on('listing_dynamic_field_values.listing_master_id','=','listing_master.id');
                                            $join->where(function($query) use ($saddlery_type, $saddlery_category){

                                              if($saddlery_type != ''){
                                                $query->orWhere('dynamic_field_id','=',$saddlery_type);
                                              }

                                              if($saddlery_category != ''){
                                                $query->orWhere('dynamic_field_id','=',$saddlery_category);
                                              }
                                            });
                                          });
        }
      }

    /*Property*/
      if($top_category == 'property' || $top_category == 'Property')
      {
        array_push($where,'property');
        $search_result = $search_result->where('listing_master.category_id',4);

        if(isset($request->property_category) && isset($request->property_Bathrooms) && isset($request->property_Bedrooms))
        {
          $cnt++;
          if($request->property_category == 'all_property_category')
          {
            $all_property_category = ['N/A', 'Agistment', 'For lease', 'For sale'];
            $search_result = $search_result->whereIn('property_category', $all_property_category);
          }
          else
          {
            $search_result = $search_result->where('property_category',$request->property_category);
          }
          if(isset($request->property_Bathrooms))
          {
            $property_Bathrooms = $request->property_Bathrooms;
          }
          if(isset($request->property_Bedrooms))
          {
            $property_Bedrooms = $request->property_Bedrooms;
          }
          $search_result = $search_result->join('listing_dynamic_field_values',
                                                  function($join) use ($property_Bathrooms, $property_Bedrooms)
                                          {
                                            $join->on('listing_dynamic_field_values.listing_master_id','=','listing_master.id');
                                            $join->where(function($query) use ($property_Bathrooms, $property_Bedrooms){
                                              if($property_Bathrooms != ''){
                                                $query->orWhere('dynamic_field_id','=',$property_Bathrooms);
                                              }
                                              if($property_Bedrooms != ''){
                                                $query->orWhere('dynamic_field_id','=',$property_Bedrooms);
                                              }
                                            });
                                          });
        }
      }

    if($cnt > 0)
    {
      array_push($where,'33');
      //$search_result = $search_result->groupBy('listing_dynamic_field_values.listing_master_id');
    }
    else
    {
      //$search_result = $search_result->groupBy('listing_master.listing_id');
    }

    if(isset($request->sortby))
    {
      array_push($where,'34');
      $sortby = $request->sortby;

      if($sortby == 'a_z' || $listing == '')
      {
        array_push($where,'35');
        $search_result = $search_result->orderBy('listing_master.title', 'DESC');
      }
      if($sortby == 'z_a')
      {
        array_push($where,'36');
        $search_result = $search_result->orderBy('listing_master.title', 'ASC');
      }
      if($sortby == 'price_high_to_low')
      {
        array_push($where,'37');
        $search_result = $search_result->orderBy('listing_master.price', 'DESC');
      }
      if($sortby == 'price_low_to_high')
      {
        array_push($where,'38');
        $search_result = $search_result->orderBy('listing_master.price', 'ASC');
      }
    }
    $search_result = $search_result->distinct();
    $search_result = $search_result->paginate($perpage)->onEachSide(1);

    return view('front.search_results',compact('all_top_categories',
                                                'top_category',
                                                'get_deynemic_values',
                                                'all_state',
                                                'search_state',
                                                'listing',
                                                'search_discipline',
                                                'search_breed_primary',
                                                'search_height',
                                                'search_age',
                                                'search_gender',
                                                'search_rider_Level',
                                                'search_color',
                                                'sortby',
                                                'perpage',
                                                'search_result'));
  }

  public function view_listing(Request $request)
  {
    $current_page = 'view_listing';
    $listing = ListingMaster::where('identification_code',$request->token)
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
}
