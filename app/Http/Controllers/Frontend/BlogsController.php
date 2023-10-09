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
use App\Models\ContactCustomerWishList;

class BlogsController extends Controller
{
  public function view_all_blogs($value='')
  {
    $current_page = 'blogs';
    $blogs = Blog::where(['is_delete' => '0','is_active'=> '1'])->paginate(12);
    return view('front.blogs.blogs',compact('current_page','blogs'));
  }

  public function view_news_article_blogs($blog_type)
  {
    $current_page = $request->type;
    $blogs = Blog::where(['category_id' => $request->type, 'is_delete' => '0', 'is_active' => '1'])->paginate(12);
    return view('front.blogs.blogs',compact('current_page','blogs'));
  }

  public function view_blog_details(Request $request)
  {    
    if($request->blog_slug == 'news' || $request->blog_slug == 'article')
    {      
      $current_page = $request->blog_slug;
      $blogs = Blog::where(['category_id' => $request->blog_slug, 'is_delete' => '0', 'is_active' => '1'])->paginate(12);
      return view('front.blogs.blogs',compact('current_page','blogs'));
    }
    else{
      $current_page = 'blogs';
      $blog = Blog::where('slug',$request->blog_slug)->first();
      return view('front.blogs.blog_detail',compact('current_page','blog')); 
    }
  }

  public function blog_search(Request $request)
  {
    $current_page = 'blogs';
    $search_key_word = $request->blog_search_key;
    if($search_key_word != '')
    {
      $blogs = Blog::where(['is_delete' => '0','is_active'=> '1'])
                      ->where(function($q) use($search_key_word) {
                        return $q->where('title','LIKE','%'.$search_key_word.'%')
                                  ->orWhere('detailed_text','LIKE','%'.$search_key_word.'%');
                      })->paginate(12)->onEachSide(1)->appends(request()->query());;
      return view('front.blogs.blogs',compact('current_page','blogs','search_key_word'));
    }
    else{
      return redirect('blogs');
    }
  }
}
