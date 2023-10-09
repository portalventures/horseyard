<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Pipeline;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;
use App\Http\Controllers\Route;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Session;

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
use App\helpers;
use App\Models\StallionListing;

class HomepageSettingController extends Controller
{
    public function home_page_featured_listing_settings($value = '')
    {
        Session::forget('listing_all_ids');
        $current_page = 'featured_listing_settings';
        $featured_listings = FeaturedListing::join('listing_master', function ($join) {
            $join->on('featured_listings.listing_master_id', '=', 'listing_master.id');
        })
            ->where([
                'listing_master.is_active' => '1',
                'listing_master.is_approved' => '1',
                'listing_master.is_delete' => '0'
            ])
            ->orderBy('listing_master.id', 'DESC')
            ->paginate(10, ['*'], 'featured');
        /*
            $latest_listings = LatestListings::join('listing_master', function($join)
                                              {
                                                $join->on('latest_listings.listing_master_id','=','listing_master.id');
                                              })
                                              ->orderBy('listing_master.id', 'DESC')
                                              ->paginate(3, ['*'], 'latest');

            $blog_listings = BlogListings::join('blogs', function($join)
                                          {
                                            $join->on('blog_listings.blog_id','=','blogs.id');
                                          })
                                          ->orderBy('blogs.id', 'DESC')
                                          ->paginate(3, ['*'], 'blog');
        */
        return view('admin.home_page_setting.featured_listing_settings', compact('current_page', 'featured_listings'));
    }

    public function home_page_latest_listing_settings($value = '')
    {
        Session::forget('listing_all_ids');
        $current_page = 'latest_listing_settings';

        $latest_listings = LatestListings::join('listing_master', function ($join) {
            $join->on('latest_listings.listing_master_id', '=', 'listing_master.id');
        })
            ->where(['listing_master.is_active' => '1', 'listing_master.is_approved' => '1', 'listing_master.is_delete' => '0'])
            ->orderBy('listing_master.id', 'DESC')
            ->paginate(10, ['*'], 'latest');

        return view('admin.home_page_setting.latest_listing_settings', compact('current_page', 'latest_listings'));
    }

    public function home_page_stallions_listing_settings($value = '')
    {
        Session::forget('listing_all_ids');
        $current_page = 'stallions_listing_settings';

        $stallion_listings = StallionListing::join('listing_master', function ($join) {
            $join->on('stallions_listing.listing_master_id', '=', 'listing_master.id');
        })
            ->where(['listing_master.is_active' => '1', 'listing_master.is_approved' => '1', 'listing_master.is_delete' => '0'])
            ->orderBy('listing_master.id', 'DESC')
            ->paginate(10, ['*'], 'latest');

        return view('admin.home_page_setting.stallion_listing_settings', compact('current_page', 'stallion_listings'));
    }

    public function home_page_blog_settings($value = '')
    {
        Session::forget('listing_all_ids');
        $current_page = 'blog_settings';

        $blog_listings = BlogListings::join('blogs', function ($join) {
            $join->on('blog_listings.blog_id', '=', 'blogs.id');
        })
            ->where(['blogs.is_delete' => '0'])
            ->orderBy('blogs.id', 'DESC')
            ->paginate(10, ['*'], 'blog');

        return view('admin.home_page_setting.blog_settings', compact('current_page', 'blog_listings'));
    }

    public function listing_master_data($value = '')
    {
        $ads = ListingMaster::whereNotIn('id', function ($q) {
            $q->select('listing_master_id')->from('featured_listings');
        })
            ->whereNotIn('id', function ($q) {
                $q->select('listing_master_id')->from('latest_listings');
            })
            ->whereNotIn('id', function ($q) {
                $q->select('listing_master_id')->from('stallions_listing');
            })
            ->where(['is_active' => '1', 'is_approved' => '1', 'is_blocked' => '0', 'is_delete' => '0']);

        return $ads;
    }

    public function new_featured_latest_blog_listing(Request $request)
    {
        $from = $request->from;
        $curRecCount = 0;
        $search_key_word = '';

        if ($from == 'featured') {
            $current_page = 'featured_listing_settings';
            $curRecCount = FeaturedListing::join('listing_master', function ($join) {
                $join->on('featured_listings.listing_master_id', '=', 'listing_master.id');
            })
                ->where([
                    'listing_master.is_active' => '1',
                    'listing_master.is_approved' => '1',
                    'listing_master.is_delete' => '0'
                ])
                ->count();
        } elseif ($from == 'latest') {
            $current_page = 'latest_listing_settings';
            $curRecCount = LatestListings::join('listing_master', function ($join) {
                $join->on('latest_listings.listing_master_id', '=', 'listing_master.id');
            })
                ->where(['listing_master.is_active' => '1', 'listing_master.is_approved' => '1', 'listing_master.is_delete' => '0'])
                ->count();
        } elseif ($from == 'stallion') {
            $current_page = 'stallions_listing_settings';
            $curRecCount = StallionListing::join('listing_master', function ($join) {
                $join->on('stallions_listing.listing_master_id', '=', 'listing_master.id');
            })
                ->where(['listing_master.is_active' => '1', 'listing_master.is_approved' => '1', 'listing_master.is_delete' => '0'])
                ->count();
        } else {
            $current_page = 'blog_settings';
            $curRecCount = BlogListings::join('blogs', function ($join) {
                $join->on('blog_listings.blog_id', '=', 'blogs.id');
            })->count();
        }

        $ads = '';
        $blogs = '';

        if ($from != 'blog') {
            $ads = $this->listing_master_data();

            if(isset($request->search) && !empty($request->search))
            {
              $search_key_word = $request->search;
              $ads = $ads->where(function ($query) use ($search_key_word) {
                                        $query->orWhere('title', 'LIKE', "%{$search_key_word}%");
                                        $query->orWhere('description', 'LIKE', "%{$search_key_word}%");
                                        $query->orWhere('ad_id', 'LIKE', "%{$search_key_word}%");
                                        $query->orWhere('item_show_type', 'LIKE', "%{$search_key_word}%");
                                      });
            }
            $ads = $ads->paginate(10);
        } else {
          $blogs = Blog::where('is_active', '1')
                        ->whereNotIn('id', function ($q) {
                          $q->select('blog_id')->from('blog_listings');
                        });
          if(isset($request->search) && !empty($request->search))
          {
            $search_key_word = $request->search;                          
            $blogs = $blogs->where(function ($query) use ($search_key_word) {
                              $query->orWhere('title', 'LIKE', "%{$search_key_word}%");
                              $query->orWhere('detailed_text', 'LIKE', "%{$search_key_word}%");
                              $query->orWhere('category_id', 'LIKE', "%{$search_key_word}%");        
                            });
          }

          $blogs = $blogs->paginate(10);
        }
        return view('admin.home_page_setting.add_featured_latest_blog_listing', compact(
            'current_page',
            'ads',
            'blogs',
            'from',
            'curRecCount','search_key_word'
        ));
    }

    public function ads_add_into_featured_latest_listing(Request $request)
    {
        $allids = Session::get('listing_all_ids');

        if ($request->from == 'featured') {
            foreach ($allids as $key => $ad_id) {
                //$ad_category_id = explode(',',$ad_id);
                FeaturedListing::create([
                    'created_by' => Auth()->user()->id,
                    'listing_master_id' => $ad_id,
                    //'category_id' => $ad_category_id[1]
                ]);
            }
        } elseif ($request->from == 'latest') {
            foreach ($allids as $key => $ad_id) {
                //$ad_category_id = explode(',',$ad_id);
                LatestListings::create([
                    'created_by' => Auth()->user()->id,
                    'listing_master_id' => $ad_id,
                    //'category_id' => $ad_category_id[1]
                ]);
            }
        } elseif ($request->from == 'stallion') {
            foreach ($allids as $key => $ad_id) {
                //$ad_category_id = explode(',',$ad_id);
                StallionListing::create([
                    'created_by' => Auth()->user()->id,
                    'listing_master_id' => $ad_id,
                    //'category_id' => $ad_category_id[1]
                ]);
            }
        } elseif ($request->from == 'blog') {
            foreach ($allids as $key => $ad_id) {
                //$ad_category_id = explode(',',$ad_id);
                BlogListings::create([
                    'created_by' => Auth()->user()->id,
                    'blog_id' => $ad_id,
                    //'category_id' => $ad_category_id[1]
                ]);
            }
        }

        $this->update_seq_no($request->from);
        return true;
    }

    public function delete_featured_listing_blog(Request $request)
    {
        if ($request->from == 'featured') {
            FeaturedListing::where('listing_master_id', $request->listing_id)->delete();
        } elseif ($request->from == 'latest') {
            LatestListings::where('listing_master_id', $request->listing_id)->delete();
        } elseif ($request->from == 'stallion') {
            StallionListing::where('listing_master_id', $request->listing_id)->delete();
        } elseif ($request->from == 'blog') {
            BlogListings::where('blog_id', $request->listing_id)->delete();
        }

        $this->update_seq_no($request->from);
        return true;
    }

    public function update_seq_no($from = '')
    {
        if ($from == 'featured') {
            $all_featured_blog_listing = FeaturedListing::get();
        } elseif ($from == 'latest') {
            $all_featured_blog_listing = LatestListings::get();
        } elseif ($from == 'stallion') {
            $all_featured_blog_listing = StallionListing::get();
        } elseif ($from == 'blog') {
            $all_featured_blog_listing = BlogListings::get();
        }
        foreach ($all_featured_blog_listing as $key => $featured_listing) {
            $featured_listing->fill([
                'seq_no' => $key + 1
            ])->save();
        }
    }

    public function create_ads_session(Request $request)
    {
        $old_seesion_data = Session::get('listing_all_ids');

        $request_ads_ids = $request->ads_ids;

        if (!empty($request_ads_ids)) {
            $listing_all_ids = [];
            foreach ($request_ads_ids as $key => $ad_id) {
                $ad_category_id = $ad_id;
                array_push($listing_all_ids, $ad_category_id);
            }

            if ($old_seesion_data != null || !empty($old_seesion_data)) {
                $listing_all_ids = array_merge($old_seesion_data, $listing_all_ids);
            }

            Session::put('listing_all_ids', array_unique($listing_all_ids));
        } else {
            Session::put('listing_all_ids', []);
        }
    }

    public function create_removes_session(Request $request)
    {
        $old_seesion_data = Session::get('listing_all_ids');

        foreach ($old_seesion_data as $key => $item) {
            if (($key = array_search($request->listing_id, $old_seesion_data)) !== false) {
                unset($old_seesion_data[$key]);
            }
        }
        Session::put('listing_all_ids', $old_seesion_data);
    }
}
