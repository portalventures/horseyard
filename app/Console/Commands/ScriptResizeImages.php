<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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


class ScriptResizeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'script:ImagesResizes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      try {
        echo"************************************************************************";
        echo "\n";
        echo "resizes listing images";
        echo "\n";
        echo "Start";
          $ListingCorruptedImages = [];

          $listing_images = ListingImages::get();

          foreach ($listing_images as $key => $value)
          {
            $path = public_path().'/listing_images_250/';

            if(!\File::isDirectory($path))
            {
              \File::makeDirectory($path, 0775, true, true);
            }

            $path = public_path().'/listing_images_250/' . $value->listing_master_id;

            if(!\File::isDirectory($path))
            {
              \File::makeDirectory($path, 0775, true, true);
            }
            
            if($value->image_name != null || $value->image_name != '')
            {
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
                  array_push($ListingCorruptedImages,$value->image_name);
                }
              }
              else
              {
                array_push($ListingCorruptedImages,$value->image_name);
              }
            }
          }
        echo "\n";
        echo "End";
        echo "\n";
        echo "Listing Corrupted Images";
        echo "\n";
        print_r($ListingCorruptedImages);
        
        echo "\n";
        echo"************************************************************************";
        echo "\n";

        echo "resizes blog images";
        echo "\n";
        echo "Start";
          $BlogCorruptedImages = [];
          $blog_images = Blog::get();

          $path = public_path().'/blog_images_250/';

          if(!\File::isDirectory($path))
          {
            \File::makeDirectory($path, 0775, true, true);
          }

          foreach ($blog_images as $key => $value)
          {
            if($value->image != null || $value->image != '')
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
                  array_push($BlogCorruptedImages,$value->image);
                }
              }
              else
              {
                array_push($BlogCorruptedImages,$value->image);
              }
            }
          }
        echo "\n";     
        echo "End";
        echo "\n";
        echo "Blog Corrupted Images";
        echo "\n";
        print_r($BlogCorruptedImages);

        echo "\n";
        echo"************************************************************************";
        echo "\n";

        echo "resizes explore by horse images";
        echo "\n";
        echo "Start";
          $ExploreByHorseCorruptedImages = [];
          $blog_images = ExploreByHorse::get();

          $path = public_path().'/explore_by_horse_250/';

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
                array_push($ExploreByHorseCorruptedImages,$value->image);
              }
            }
            else
            {
              array_push($ExploreByHorseCorruptedImages,$value->image);
            }
          }
        echo "\n";     
        echo "End";
        echo "\n";
        echo "Explore ByHorse Corrupted Images";
        echo "\n";
        print_r($ExploreByHorseCorruptedImages);
        echo "\n";
      } catch (Exception $e) {
          echo $e;
      }
    }
}
