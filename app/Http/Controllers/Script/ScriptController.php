<?php

namespace App\Http\Controllers\Script;

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
use Illuminate\Support\Str;
use Image;

class ScriptController extends Controller
{
  public function update_password_and_token_into_user($value='')
  {
    $users = User::where('id','!=','1')->where('password','=',null)->where('token','=',null)->take(500)->get();
    
    foreach ($users as $key => $user) {
      $user->fill([        
        'is_verifed' => '1',
        'is_active' => '1',
        'token' => Str::random(32),        
        'role' => 'user',
      ])->save();
    }
    dd('done');
  }

  public function update_identification_code_into_listing($value='')
  {
    $Listings = ListingMaster::where('identification_code','=',null)->take(500)->get();
    
    foreach ($Listings as $key => $Listing) {
      $Listing->fill([
        'slug' => Str::slug($Listing->title),
        'is_approved' => '1',
        'is_active' => '1',
        'identification_code' => Str::random(32)
      ])->save();
    }
    dd('done');
  }

  public function update_free_listing_to_null($value='')
  {
    $free_Listings = ListingMaster::where('item_show_type','=','free')->where('price','!=',0.00)->take(500)->get();
    
    foreach ($free_Listings as $key => $Listing) {
      $Listing->fill([
        'item_show_type' => null
      ])->save();
    }
    dd('done');
  }

  public function update_slug_into_blogs($value='')
  {
    $blogs = Blog::get();    
    foreach ($blogs as $key => $blog) {
      $blog->fill([
        'slug' => $blog->ad_id.'-'.Str::slug($blog->title)
      ])->save();
    }
    dd('done');
  }

  public function update_slug_into_dynamic_fields($value='')
  {
    $dynamic_fields = DynamicFieldValues::get();    
    foreach ($dynamic_fields as $key => $field) {
      $field->fill([
        'slug' => Str::slug($field->field_value)
      ])->save();
    }
    dd('done');
  }

  public function resizes_listing_images($value='')
  {
    ini_set('max_execution_time', 18000);

    $corrupted_images = [];

    $listing_images = ListingImages::get();

    foreach ($listing_images as $key => $value)
    {
      $path = 'listing_images_250/' . $value->listing_master_id;

      if(!\File::isDirectory($path))
      {
        \File::makeDirectory($path, 0775, true, true);
      }

      if(file_exists(public_path('/listing_images/'.$value->listing_master_id.'/'.$value->image_name)))
      {
        $check_img = getimagesize(public_path('/listing_images/'.$value->listing_master_id.'/'.$value->image_name));

        if($check_img)
        {
          $img = Image::make(public_path('/listing_images/'.$value->listing_master_id.'/'.$value->image_name));
          $img->resize(250, 250, function ($constraint) {
            $constraint->aspectRatio();
          })->save($path.'/'.$value->image_name);
        }
        else
        {
          array_push($corrupted_images,$value->image_name);
        }
      }
      else
      {
        array_push($corrupted_images,$value->image_name);
      }      
    }
    dd('done',$corrupted_images);
  }

  public function resizes_blog_images($value='')
  {
    $corrupted_images = [];

    $blog_images = Blog::get();

    $path = 'blog_images_250/';

    if(!\File::isDirectory($path))
    {
      \File::makeDirectory($path, 0775, true, true);
    }

    foreach ($blog_images as $key => $value)
    {
      if(file_exists(public_path('/blog_images/'.$value->image)))
      {
        $check_img = getimagesize(public_path('/blog_images/'.$value->image));

        if($check_img)
        {
          $img = Image::make(public_path('/blog_images/'.$value->image));          
          $img->resize(250, 250, function ($constraint) {
            $constraint->aspectRatio();
          })->save($path.$value->image);
        }
        else
        {
          array_push($corrupted_images,$value->image);
        }
      }
      else
      {
        array_push($corrupted_images,$value->image);
      }
    }
    dd('done',$corrupted_images);
  }

  public function resizes_explore_by_horse_images($value='')
  {
    $corrupted_images = [];

    $blog_images = ExploreByHorse::get();

    $path = 'explore_by_horse_250/';

    if(!\File::isDirectory($path))
    {
      \File::makeDirectory($path, 0775, true, true);
    }

    foreach ($blog_images as $key => $value)
    {
      if(file_exists(public_path('/explore_by_horse/'.$value->image)))
      {
        $check_img = getimagesize(public_path('/explore_by_horse/'.$value->image));

        if($check_img)
        {
          $img = Image::make(public_path('/explore_by_horse/'.$value->image));          
          $img->resize(250, 250, function ($constraint) {
            $constraint->aspectRatio();
          })->save($path.$value->image);
        }
        else
        {
          array_push($corrupted_images,$value->image);
        }
      }
      else
      {
        array_push($corrupted_images,$value->image);
      }
    }
    dd('done',$corrupted_images);
  }

  public function update_suburb_slug($value='')
  {
    $Suburbs = Suburb::get();    
    foreach ($Suburbs as $key => $Suburb) {
      $Suburb->fill([
        'suburb_code' => Str::slug($Suburb->suburb_name)
      ])->save();
    }
    dd('done');
  }
}
