<?php 
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use View;

class SiteMapController extends Controller
{
  protected $ApiArray;
  public function __construct()
  {
      // You must have admin access to proceed
      //$this->middleware('guest');
  }
    
  public function index(Request $request)
  {
    $content = View::make('front.sitemapxml',['type' => 'static'])->render();
	
    if(file_exists('sitemap_staticpage.xml')){
       File::delete('sitemap_staticpage.xml');
    }
    File::put('sitemap_staticpage.xml', $content);
  
    $content = View::make('front.sitemapxml',['type' => 'blog'])->render();
  
    if(file_exists('sitemap_blog.xml')){
       File::delete('sitemap_blog.xml');
    }
    File::put('sitemap_blog.xml', $content);
	
    $content = View::make('front.sitemapxml',['type' => 'listing'])->render();
	
	  if(file_exists('sitemap_listing.xml')){
       File::delete('sitemap_listing.xml');
    }
    File::put('sitemap_listing.xml', $content);
	
    $content = View::make('front.sitemapxml',['type' => 'final'])->render();
	
	  if(file_exists('sitemap.xml')){
       File::delete('sitemap.xml');
    }
    File::put('sitemap.xml', $content);
    
    exit;
  }   

  public function sitemapxml(Request $request)
  {
    $content = View::make('front.sitemapxml')->render();
    if(file_exists('sitemap.xml')){
       File::delete('sitemap.xml');
    }
    File::put('sitemap.xml', $content);
    exit;        
  }

}
 