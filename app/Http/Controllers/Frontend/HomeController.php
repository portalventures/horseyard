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

class HomeController extends Controller
{
  public $listing_master;

  public function __construct(ListingMaster $listing_master)
  {
    $this->listing_master = $listing_master;
  }
  
  public function index()
  {
    $featured_listings = FeaturedListing::join('listing_master', function($join)
                                          {
                                            $join->on('featured_listings.listing_master_id','=','listing_master.id');
                                          })
                                          ->where(['listing_master.is_active' => '1', 
                                                    'listing_master.is_approved' => '1', 
                                                    'listing_master.is_delete' => '0'])
                                          ->orderBy('listing_master.id', 'DESC')
                                          ->take(10)->get();

    $latest_listings = LatestListings::join('listing_master', function($join)
                                      {
                                        $join->on('latest_listings.listing_master_id','=','listing_master.id');
                                      })
                                      ->where(['listing_master.is_active' => '1', 
                                                'listing_master.is_approved' => '1', 
                                                'listing_master.is_delete' => '0'])
                                      ->orderBy('listing_master.id', 'DESC')
                                      ->take(10)->get();
    
    $blog_listings = BlogListings::join('blogs', function($join)
                                  {
                                    $join->on('blog_listings.blog_id','=','blogs.id');
                                  })
                                  ->orderBy('blogs.id', 'DESC')
                                  ->take(10)->get();
    
    $all_state = State::get();

    $category = 'horses';

    $horses_deynemic_fileds = $this->listing_master->get_deynemic_fileds('horses');    
    $horses_discipline = $horses_deynemic_fileds['horses_discipline'];
    $horses_gender = $horses_deynemic_fileds['horses_gender'];
    $horses_breed = $horses_deynemic_fileds['horses_breed_primary'];
    $horses_color = $horses_deynemic_fileds['horses_color'];

    return view('front.index',compact('featured_listings','latest_listings','blog_listings', 'all_state','category','horses_discipline','horses_gender','horses_breed','horses_color')); 
  }

  public function dynamic_category_tabs(Request $request)
  {
    $category = $request->category;

    $horses_discipline = '';
    $horses_gender = '';
    $horses_breed = '';
    $transport_type = '';
    $horse_number = '';
    $ramp_location = '';
    $saddlery_type = '';
    $saddlery_category = '';
    $property_category = '';
    $property_bedrooms = '';
    $property_bathrooms = '';
    
    $all_state = State::get();

    if($category == 'horses')
    {
      $horses_deynemic_fileds = $this->listing_master->get_deynemic_fileds('horses');    
      $horses_discipline = $horses_deynemic_fileds['horses_discipline'];
      $horses_gender = $horses_deynemic_fileds['horses_gender'];
      $horses_breed = $horses_deynemic_fileds['horses_breed_primary'];
    }
    elseif($category == 'transport')
    {
      $transport_deynemic_fileds = $this->listing_master->get_deynemic_fileds('transport');    
      $transport_type = $transport_deynemic_fileds['transport_type'];
      $horse_number = $transport_deynemic_fileds['transport_no_of_horse_to_carry'];
      $ramp_location = $transport_deynemic_fileds['transport_ramp_location'];
    }
    elseif($category == 'saddlery')
    {
      $saddlery_deynemic_fileds = $this->listing_master->get_deynemic_fileds('saddlery');    
      $saddlery_type = $saddlery_deynemic_fileds['saddlery_type'];
      $saddlery_category = $saddlery_deynemic_fileds['saddlery_category'];
    }
    elseif($category == 'property')
    {
      $property_deynemic_fileds = $this->listing_master->get_deynemic_fileds('property');
      $property_category = ['N/A', 'Agistment', 'For lease', 'For sale'];
      $property_bedrooms = $property_deynemic_fileds['property_Bedrooms'];
      $property_bathrooms = $property_deynemic_fileds['property_Bathrooms'];
    }

    return view('front.dynamic_category_tabs',compact('category','all_state','horses_discipline','horses_gender','horses_breed','transport_type','horse_number','ramp_location','saddlery_type','saddlery_category','property_category','property_bedrooms','property_bathrooms')); 
  }

  public function view_advertise_page($value='')
  {
    $current_page = 'advertise';
    return view('front.advertise',compact('current_page'));
  }
}
