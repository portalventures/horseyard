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
use App\Models\ExploreByHorse;
use App\CustomClass\SearchParams;
use App\Models\StallionListing;

class MyHomeController extends Controller
{
    public function index()
    {
        session(['TitleTxt' => '']);
        $curTime = time();

        if (!session('is_loaded')) {
          $this->generateSessionData();
        }
        
        $explore_by_horse = $this->Explore_by_Horse();
        $featured_listings = $this->createFeaturedListing();
        $stallion_listings = $this->createStallionListing();
        $latest_listings = $this->createLatestListing();
        $blog_listings = $this->createFeaturedBlogs();

        $all_state = session('allStates');

        $category = 'horses';

        $searchParams = session('searchParams');
        
        if (!empty($searchParams)) {
            $searchParams = new SearchParams;
            $searchParams->top_category = $category;
            $searchParams->resetSearchTerms();
            session(['searchParams' => $searchParams]);
        }

        //$horses_deynemic_fileds = $this->listing_master->get_deynemic_fileds('horses');
        $horses_discipline = session('horses_discipline');
        $horses_gender = session('horses_gender');
        $horses_breed = session('horses_breed_primary');
        $horses_color = session('horses_color');
        
        return view('front.index', compact('explore_by_horse','featured_listings', 'latest_listings', 'blog_listings', 'all_state', 'category', 'horses_discipline', 'horses_gender', 'horses_breed', 'horses_color', 'stallion_listings'));
    }

    public function dynamic_category_tab_list(Request $request)
    {
        $category = $request->category;

        $horses_discipline = session('horses_discipline');
        $horses_gender = session('horses_gender');
        $horses_breed = session('horses_breed_primary');
        $transport_type = session('transport_type');
        $horse_number = session('transport_no_of_horse_to_carry');
        $ramp_location = session('transport_ramp_location');
        $saddlery_type = session('saddlery_type');
        $saddlery_category = session('saddlery_category');
        $property_category = session('property_category');
        $property_bedrooms = session('property_Bedrooms');
        $property_bathrooms = session('property_Bathrooms');

        $all_state = session('allStates');

        return view('front.dynamic_category_tabs', compact('category', 'all_state', 'horses_discipline', 'horses_gender', 'horses_breed', 'transport_type', 'horse_number', 'ramp_location', 'saddlery_type', 'saddlery_category', 'property_category', 'property_bedrooms', 'property_bathrooms'));
    }

    public function view_advertise_page($value = '')
    {
        $current_page = 'advertise';
        return view('front.advertise', compact('current_page'));
    }

    private function Explore_by_Horse() 
    {    
        return ExploreByHorse::select('explore_by_horse.id as explore_by_horse_id',
                                  'explore_by_horse.image as image',
                                  'explore_by_horse.is_active as is_active',
                                  'dynamic_field_values.id as dynamic_field_id',
                                  'dynamic_field_values.field_value as brand_name')
                                    ->join('dynamic_field_values', function($join)
                                    {
                                      $join->on('explore_by_horse.primary_breed_id','=','dynamic_field_values.id');
                                    })
                                    ->where(['explore_by_horse.is_active' => '1'])
                                    ->orderBy('dynamic_field_values.field_value', 'ASC')
                                    ->take(7)->get();
    }

    private function createFeaturedListing()
    {
        return FeaturedListing::join('listing_master', function ($join) {
            $join->on('featured_listings.listing_master_id', '=', 'listing_master.id');
        })
            ->where([
                'listing_master.is_active' => '1',
                'listing_master.is_approved' => '1',
                'listing_master.is_delete' => '0'
            ])
            ->orderBy('listing_master.id', 'DESC')
            ->take(10)->get();
    }

    private function createStallionListing()
    {
        return StallionListing::join('listing_master', function ($join) {
            $join->on('stallions_listing.listing_master_id', '=', 'listing_master.id');
        })
            ->where([
                'listing_master.is_active' => '1',
                'listing_master.is_approved' => '1',
                'listing_master.is_delete' => '0'
            ])
            ->orderBy('listing_master.id', 'DESC')
            ->take(10)->get();
    }

    private function createLatestListing()
    {
      return ListingMaster::where([
              'listing_master.is_active' => '1',
              'listing_master.is_approved' => '1',
              'listing_master.is_delete' => '0'
            ])->orderBy('listing_master.created_at', 'DESC')            
            ->take(10)->get();

        // return LatestListings::join('listing_master', function ($join) {
        //     $join->on('latest_listings.listing_master_id', '=', 'listing_master.id');
        // })->where([
        //       'listing_master.is_active' => '1',
        //       'listing_master.is_approved' => '1',
        //       'listing_master.is_delete' => '0'
        //     ])
        //     ->orderBy('listing_master.id', 'DESC')            
        //     ->take(10)->get();
    }

    private function createFeaturedBlogs()
    {
        return BlogListings::join('blogs', function ($join) {
            $join->on('blog_listings.blog_id', '=', 'blogs.id');
        })
            ->where(['blogs.is_delete' => '0'])
            ->orderBy('blogs.id', 'DESC')
            ->take(10)->get();
    }

    public function generateSessionData()
    {
        $topCategories = TopCategory::select('category_name', 'id')->get();
        session(['topCategories' => $topCategories]);
        //$dynamicFieldValues = DynamicFieldValues::select('id', 'field_id', 'field_value')->get();
        //session(['dynamicFieldValues' => $dynamicFieldValues]);

        // Horses Master Data
        $horses_discipline = $this->get_filed_value_based_on_listing_present(1);
        session(['horses_discipline' => $horses_discipline]);
        $horses_breed_primary = $this->get_filed_value_based_on_listing_present(2);
        session(['horses_breed_primary' => $horses_breed_primary]);
        $horses_breed_secondary = $this->get_filed_value_based_on_listing_present(3);
        session(['horses_breed_secondary' => $horses_breed_secondary]);
        $horses_color = $this->get_filed_value_based_on_listing_present(4);
        session(['horses_color' => $horses_color]);
        $horses_gender = $this->get_filed_value_based_on_listing_present(5);
        session(['horses_gender' => $horses_gender]);
        $horses_temperament = $this->get_filed_value_based_on_listing_present(6);
        session(['horses_temperament' => $horses_temperament]);
        $horses_age = $this->get_filed_value_based_on_listing_present(7);
        session(['horses_age' => $horses_age]);
        $horses_rider_Level = $this->get_filed_value_based_on_listing_present(8);
        session(['horses_rider_Level' => $horses_rider_Level]);
        $horses_height = $this->get_filed_value_based_on_listing_present(9);        
        session(['horses_height' => $horses_height]);

        // Transport Master Data
        $transport_type = $this->get_filed_value_based_on_listing_present(10);
        session(['transport_type' => $transport_type]);
        $transport_no_of_horse_to_carry = $this->get_filed_value_based_on_listing_present(11);
        session(['transport_no_of_horse_to_carry' => $transport_no_of_horse_to_carry]);
        $transport_ramp_location = $this->get_filed_value_based_on_listing_present(12);
        session(['transport_ramp_location' => $transport_ramp_location]);
        $transport_axles = $this->get_filed_value_based_on_listing_present(13);
        session(['transport_axles' => $transport_axles]);
        $transport_registration_state = $this->get_filed_value_based_on_listing_present(14);
        session(['transport_registration_state' => $transport_registration_state]);

        // Sadalry Master Data
        $saddlery_type = $this->get_filed_value_based_on_listing_present(15);
        session(['saddlery_type' => $saddlery_type]);
        $saddlery_category = $this->get_filed_value_based_on_listing_present(16);
        session(['saddlery_category' => $saddlery_category]);
        $saddlery_condition = $this->get_filed_value_based_on_listing_present(17);
        session(['saddlery_condition' => $saddlery_condition]);

        // Property Master Data
        $property_category = ['N/A', 'Agistment', 'For lease', 'For sale'];
        session(['property_category' => $property_category]);
        $property_Bedrooms = $this->get_filed_value_based_on_listing_present(18);
        session(['property_Bedrooms' => $property_Bedrooms]);
        $property_Bathrooms = $this->get_filed_value_based_on_listing_present(19);
        session(['property_Bathrooms' => $property_Bathrooms]);

        // All State Data
        $all_state = State::select('state.state_name as state_name', 'state.state_code as state_code', 'state.id as state_id')
            ->join('listing_master', 'listing_master.state_id', '=', 'state.id')
            ->distinct()
            ->get();

        session(['allStates' => $all_state]);
        session(['is_loaded', true]);
    }

    public function get_filed_value_based_on_listing_present($field_id = '')
    {
        return DynamicFieldValues::select('dynamic_field_values.field_value as field_value', 'dynamic_field_values.id as dynamic_field_id')
            ->join(
                'listing_dynamic_field_values',
                'listing_dynamic_field_values.dynamic_field_id',
                '=',
                'dynamic_field_values.id'
            )
            ->where('dynamic_field_values.field_id', $field_id)
            ->orderBy('dynamic_field_values.id', 'ASC')            
            ->distinct()
            ->get();
    }
    // public function getTopCategoryId($catName) {
    //   $topCategories = session('topCategories');
    //   error_log("horseval  : " . print_r($topCategories, true), 3, "c:\\Users\\shiva\\Desktop\\php_errors.log");

    //   $topCat = $topCategories->category_name;
    //   return $topCat;

    // }
}
