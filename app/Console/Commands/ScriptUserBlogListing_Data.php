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

class ScriptUserBlogListing_Data extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'script:UserBlogListing_Data';

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
        echo "updating user details";
        echo "\n";
        echo "Start";
          $users = User::where('password','=',null)->where('token','=',null)->get();          
          foreach ($users as $key => $user) {
            $user->fill([
              'password' => Hash::make('P@assw0rd'),
              'is_verifed' => '1',
              'is_active' => '1',
              'token' => Str::random(32),        
              'role' => 'user',
            ])->save();
          }
        echo "\n";
        echo "End";        
        
        echo "\n";
        echo "\n";

        echo"************************************************************************";
        echo "\n";
        echo "updating slug,identification into listing";
        echo "\n";
        echo "Start";
          $Listings = ListingMaster::where('identification_code','=',null)->get();
          
          foreach ($Listings as $key => $Listing) {            
            $Listing->fill([
              'slug' => $Listing->ad_id.'-'.Str::slug($Listing->title),
              'is_approved' => '1',
              'is_active' => '1',
              'identification_code' => Str::random(32)
            ])->save();
          }
        echo "\n";
        echo "End"; 

        echo "\n";
        echo "\n";

        echo"************************************************************************";
        echo "\n";
        echo "updating free listing to null";
        echo "\n";
        echo "Start";
          $free_Listings = ListingMaster::where('item_show_type','=','free')
                                        ->where('price','!=',0.00)
                                        ->get();
          
          foreach ($free_Listings as $key => $Listing) {
            $Listing->fill([
              'item_show_type' => null
            ])->save();
          }
        echo "\n";
        echo "End"; 

        echo "\n";
        echo "\n";

        echo"************************************************************************";
        echo "\n";
        echo "updating slug into blogs";
        echo "\n";
        echo "Start";
          $blogs = Blog::get();    
          foreach ($blogs as $key => $blog) {
            $blog->fill([
              'slug' => $blog->ad_id.'-'.Str::slug($blog->title)
            ])->save();
          }
        echo "\n";
        echo "End"; 

        echo "\n";
        echo "\n";

        echo"************************************************************************";
        echo "\n";
        echo "updating slug into dynamic fields";
        echo "\n";
        echo "Start";
          $dynamic_fields = DynamicFieldValues::get();    
          foreach ($dynamic_fields as $key => $field) {
            $field->fill([
              'slug' => Str::slug($field->field_value)
            ])->save();
          }
        echo "\n";
        echo "End";         

        echo "\n";
        echo "\n";

        echo"************************************************************************";
        echo "\n";
        echo "Creating Suburb slugs";
        echo "\n";
        echo "Start";
          $Suburbs = Suburb::where('suburb_code','=', null)->get();
          foreach ($Suburbs as $key => $Suburb) {
            $Suburb->fill([
              'suburb_code' => Str::slug($Suburb->suburb_name)
            ])->save();        
          }
        echo "\n";
        echo "End";  
        
        echo "\n";
        echo "\n";

      } catch (Exception $e) {
        echo $e;
      }
    }
}
