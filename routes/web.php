<?php

use Illuminate\Support\Facades\Route;

/*User rutes*/
//use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\GoogleController;
use App\Http\Controllers\Frontend\MessageController;
use App\Http\Controllers\Frontend\AdsController;
use App\Http\Controllers\Frontend\MyProfileController;
use App\Http\Controllers\Frontend\SearchResultController;
use App\Http\Controllers\Frontend\WishListController;
use App\Http\Controllers\Frontend\BlogsController;
use App\Http\Controllers\Frontend\EnquiryController;
use App\Http\Controllers\Frontend\MySearchController;
use App\Http\Controllers\Frontend\MyHomeController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\SearchHomeController;
use App\Http\Controllers\Frontend\SearchFilterController;
use App\Http\Controllers\Frontend\ListingViewController;
use App\Http\Controllers\Frontend\SiteMapController;

/*Admin rutes*/
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminAdsController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\HomepageSettingController;
use App\Http\Controllers\Admin\ContactEnquiriesController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ExploreByHorseController;

/*Script*/
use App\Http\Controllers\Script\ScriptController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MyHomeController::class, 'index']);
Route::get('get_dynamic_category_list', [MyHomeController::class, 'dynamic_category_tab_list']);
Route::get('sitemapcreate', [SiteMapController::class, 'index']);

// ----- changes on 01-08-2022
Route::get('horses-for-sale', [SearchController::class, 'searchHorseForSale']);
Route::get('transport-for-horses', [SearchController::class, 'searchTransportForSale']);
Route::get('property-for-sale', [SearchController::class, 'searchPropertyForSale']);
Route::get('saddlery-and-tack', [SearchController::class, 'searchSaddleryAndTack']);

//---------------------------------

//Top Menu Search - final as of 6th apr 2022
Route::get('search/{by_category}', [SearchController::class, 'topCategorySearch']);
Route::get('search/{by_category}/{quick_search_type}', [SearchController::class, 'topCategorySearchWFilters']);

// Home Bottom Search - final as of 6th apr 2022
Route::get('horses-for-sale/location/{state_name}', [SearchController::class, 'searchByLocation']);
Route::get('horses-for-sale/{attr_name}', [SearchController::class, 'searchByAttribute']);
Route::get('saddlery-and-tack/{attr_name}', [SearchController::class, 'searchBySaddleryAttr']);
Route::get('transport-for-horses/{attr_name}', [SearchController::class, 'searchByTransportAttribute']);
Route::get('property-for-sale/{attr_name}', [SearchController::class, 'searchByPropertyAttribute']);
Route::get('field-sex/{attr_name}', [SearchController::class, 'searchByGender']);
//Route::get('field-age/{attr_name}', [SearchController::class, 'searchByAge']);
Route::get('horse-colour/{attr_name}', [SearchController::class, 'searchByColour']);
Route::get('rider-level/{attr_name}', [SearchController::class, 'searchByRiderLevel']);
Route::get('field-height/{attr_name}', [SearchController::class, 'searchFieldByHeight']);
Route::get('max-field-height/{attr_name}', [SearchController::class, 'searchFieldMaxByHeight']);
Route::get('saddlery-type/{attr_name}', [SearchController::class, 'searchBySaddleryType']);

Route::get('suburb/{suburb_code}', [SearchController::class, 'searchBySuburb']);
Route::get('ramp-location/{attr_name}', [SearchController::class, 'searchByRampLocation']);
Route::get('axles/{attr_name}', [SearchController::class, 'searchByRampAxles']);
Route::get('field-location-of-vehicle-state/{attr_name}', [SearchController::class, 'searchByRegistrationState']);

Route::post('quick-search-category', [SearchHomeController::class, 'category_quicksearch']);
Route::post('search_page_filter', [SearchFilterController::class, 'search_page_filter']);

Route::group(['middleware' => 'FromAttributes'], function () {
  Route::get('search-listing-classifieds', [MySearchController::class, 'show_search_results']);
});

Route::get('search-results/{all_params}', [MySearchController::class, 'show_search_results1']);
Route::get('ad/{all_params}', [ListingViewController::class, 'view_listing']);


//Route::get('search/{by_category}/{dynamic_category_type}/{category_name}/{dynamic_category_id}', [
//  MySearchController::class, 'search_horse_dynamic_categories']);

Route::get('search_by_all_breed', [MySearchController::class, 'search_all_horse_breeds']);
Route::get('search-latest-featured/{latest_featured}', [MySearchController::class, 'search_latest_featured_listing']);
//Route::get('search/{all_params}', [MySearchController::class, 'show_search_results']);

//Route::get('ad/{attributes}/{breed}/{breed_name}/{location}/{ad_id}', [MySearchController::class, 'view_listing']);
//Route::get('ad/{attributes}/{type_name}/{location}/{ad_id}', [MySearchController::class, 'view_listing']);

//Route::any('search-results/{args?}', [MySearchController::class, 'search_result'])->where('args', '(.*)');;

//Route::post('get_dynamic_category_tabs', [HomeController::class, 'dynamic_category_tabs']);
//Route::get('search-by-state/{state_name}/{state}', [SearchResultController::class, 'search_result']);
//Route::get('search-by-breed/{by_category}/{category_name}/{search_breed_primary}', [SearchResultController::class, 'search_result']);
// Route::get('search-by-color/{by_category}/{category_name}/{search_color}', [SearchResultController::class, 'search_result']);
// Route::get('search-by-gender/{by_category}/{category_name}/{search_gender}', [SearchResultController::class, 'search_result']);
// Route::get('search-by-discipline/{by_category}/{category_name}/{search_discipline}', [SearchResultController::class, 'search_result']);

// Route::get('quick-search/{quick_search_type}', [SearchResultController::class, 'search_result']);
//Route::get('search-results', [SearchResultController::class, 'search_result']);


Route::get('all-news', [BlogsController::class, 'view_all_blogs']);
Route::get('blogs/{type}', [BlogsController::class, 'view_news_article_blogs']);
Route::get('horse-articles-news/{blog_slug}', [BlogsController::class, 'view_blog_details']);
Route::get('blog_search', [BlogsController::class, 'blog_search']);

Route::get('advertise', [MyHomeController::class, 'view_advertise_page']);
//Route::view('/advertise', 'front.advertise');
Route::view('/safety-centre', 'front.safety-center');
Route::view('/scams-selling', 'front.scam-selling');
Route::view('/scams-buying', 'front.scam-buyer');
Route::view('/blog', 'front.blog');
Route::view('/about', 'front.about');
Route::view('/imprint', 'front.imprint');
Route::view('/terms-a-conditions', 'front.terms');
Route::view('/rights_of_withdrawal', 'front.rights_withdrawal');
Route::view('/help', 'front.help');
Route::view('/privacy-policy', 'front.data_privacy');
Route::post('contact_enquiry', [EnquiryController::class, 'save_send_message']);

Route::group(['middleware' => 'guest'], function () {
    /*User*/
    Route::get('user/login', [LoginController::class, 'login_view']);
    Route::post('login', [LoginController::class, 'authenticate']);
    Route::get('signup', [LoginController::class, 'sign_up_view']);
    Route::post('signup', [LoginController::class, 'register_user']);

    Route::get('forgotpassword', [LoginController::class, 'forgot_password_email']);
    Route::post('forgotpassword', [LoginController::class, 'forgot_password_verify_emailaddress']);
    Route::get('forgotpassword_verify/{token}', [LoginController::class, 'signup_verify']);
    Route::get('changepassword/{token}', [LoginController::class, 'changepassword_view']);
    Route::post('changepassword', [LoginController::class, 'changepassword']);

    Route::get('signup_verify/{token}', [LoginController::class, 'signup_verify']);
    Route::post('verify_account', [LoginController::class, 'verify_account_code']);
    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

    /*Admin*/
    Route::get('siteadmin', [AdminLoginController::class, 'login_view']);
    Route::post('siteadmin', [AdminLoginController::class, 'authenticate']);
    Route::get('admin/forgotpassword', [AdminLoginController::class, 'forgot_password_email']);
    Route::post('admin/forgotpassword', [AdminLoginController::class, 'forgot_password_verify_emailaddress']);
    Route::post('admin/verify_account', [AdminLoginController::class, 'verify_account_code']);
    Route::get('admin_changepassword/{token}', [AdminLoginController::class, 'changepassword_view']);
    Route::post('admin/changepassword', [AdminLoginController::class, 'changepassword']);
});

Route::get('/logout', function () {
    Auth::logout();
    return Redirect::to('/');
});

Route::group(['middleware' => 'front_user'], function () {
    /*message*/
    Route::get('inbox', [MessageController::class, 'inbox_view']);
    Route::get('compose', [MessageController::class, 'compose_view']);
    Route::get('search_user', [MessageController::class, 'search_user']);
    Route::get('inbox_list', [MessageController::class, 'inbox_list_view']);
    Route::post('send_message', [MessageController::class, 'send_message']);
    Route::post('change_message_status', [MessageController::class, 'change_message_status']);
    Route::post('remove_message', [MessageController::class, 'remove_message']);
    Route::get('download_file', [MessageController::class, 'download_file']);
    Route::get('block_user_list', [MessageController::class, 'block_user_list']);
    Route::get('message/detail/{id}/{userId}', [MessageController::class, 'message_detail_view']);
    Route::get('message/message_detail_partial/{id}/{userId}', [MessageController::class, 'message_detail_partial']);
    Route::post('block_user', [MessageController::class, 'block_user']);
    Route::post('unblock_user', [MessageController::class, 'unblock_user']);

    /*Ads*/
    Route::get('manage-ads', [AdsController::class, 'ad_list_created_by_user']);
    Route::get('create-listing', [AdsController::class, 'create_listing']);
    Route::get('create-listing/{cate_type}', [AdsController::class, 'create_listing']);
    Route::post('get_user_category_suburb_list', [AdsController::class, 'subrub_list']);
    Route::post('categoryType_dynemic_fileds', [AdsController::class, 'categoryType_dynemic_fileds']);
    Route::post('create-listing', [AdsController::class, 'create_ad']);
    Route::get('view-listing/{ad_slug_url}/{token}', [AdsController::class, 'view_listing']);
    Route::get('edit-listing/{ad_slug_url}/{token}', [AdsController::class, 'edit_ad']);
    Route::post('user_listing_image_delete', [AdsController::class, 'delete_listing_image']);
    Route::post('user_update_listing', [AdsController::class, 'update_ad']);
    Route::post('user_update_ad_status', [AdsController::class, 'ad_status_update']);
    Route::post('listing_report', [AdsController::class, 'add_report']);

    /*My profile*/
    Route::get('my-profile', [MyProfileController::class, 'user_view_profile']);
    Route::get('edit-my-profile', [MyProfileController::class, 'user_edit_profile']);
    Route::post('get_user_profile_suburb_list', [MyProfileController::class, 'subrub_list']);
    Route::post('my-profile', [MyProfileController::class, 'user_update_profile_details']);
    Route::post('user_change_password', [MyProfileController::class, 'update_password']);

    /*Wishlist*/
    Route::get('wishlist', [WishListController::class, 'view_wishlist']);
    Route::post('listing_add_into_wishlist', [WishListController::class, 'listing_add_into_wishlist']);
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('dashboard', [AdminLoginController::class, 'view_dashboard']);
    Route::get('change-password', [AdminLoginController::class, 'admin_change_password_view']);
    Route::post('change-password', [AdminLoginController::class, 'admin_update_password']);

    /*home_page_setting*/
    Route::get('featured-listing-settings', [HomepageSettingController::class, 'home_page_featured_listing_settings']);
    Route::get('blog-settings', [HomepageSettingController::class, 'home_page_blog_settings']);
    Route::get('latest-listing-settings', [HomepageSettingController::class, 'home_page_latest_listing_settings']);
    Route::get('stallions_listing_settings', [HomepageSettingController::class, 'home_page_stallions_listing_settings']);
    Route::get('add-homepage-setting-listing/{from}', [HomepageSettingController::class, 'new_featured_latest_blog_listing']);
    Route::post('add-new-featured-latest-blog-listing', [HomepageSettingController::class, 'ads_add_into_featured_latest_listing']);
    Route::post('featured-listing-blog-delete', [HomepageSettingController::class, 'delete_featured_listing_blog']);
    Route::post('featured-listing-ad-ids-session', [HomepageSettingController::class, 'create_ads_session']);
    Route::post('featured-listing-remove-ids-session', [HomepageSettingController::class, 'create_removes_session']);

    /*ads*/
    Route::get('ads', [AdminAdsController::class, 'view_ads_created_by_admin']);    
    Route::get('ads/{ad_status_type}', [AdminAdsController::class, 'ads_status_list']);    
    Route::get('ad/{report}/{details}/{ad_id}', [AdminAdsController::class, 'ad_all_reports']);
    Route::get('ad_blocke_unblocked/{status}/{ad_id}', [AdminAdsController::class, 'un_blocked_ads']);
    Route::post('get-admin-suburb-list', [AdminAdsController::class, 'subrub_list']);
    Route::get('post-ad', [AdminAdsController::class, 'create_ad_view']);
    Route::post('get-categorytype-dynamic-fields', [AdminAdsController::class, 'categoryType_dynemic_fileds']);
    Route::post('post-ad', [AdminAdsController::class, 'create_ad']);
    Route::get('edit-ad/{ad_slug_url}/{token}', [AdminAdsController::class, 'edit_ad']);
    Route::post('listing-image-delete', [AdminAdsController::class, 'delete_listing_image']);
    Route::post('update-ad-status', [AdminAdsController::class, 'ad_status_update']);
    Route::post('update-ad', [AdminAdsController::class, 'update_ad']);
    Route::post('admin-approved-reject-ad', [AdminAdsController::class, 'approved_reject_ad']);
    Route::post('admin-delete-ad', [AdminAdsController::class, 'delete_ad']);

    /*blog*/
    Route::get('all-blogs', [AdminBlogController::class, 'blog_list']);
    Route::get('create-blog', [AdminBlogController::class, 'create_blog_view']);
    Route::post('create-blog', [AdminBlogController::class, 'create_blog']);
    Route::get('edit-blog/{id}/{slug}', [AdminBlogController::class, 'edit_blog_view']);
    Route::get('edit-blog/{id}', [AdminBlogController::class, 'edit_blog_view']);
    Route::post('update-blog', [AdminBlogController::class, 'update_blog']);
    Route::post('update-blog-status', [AdminBlogController::class, 'update_blog_status']);
    Route::get('delete-blog/{id}', [AdminBlogController::class, 'delete_blog']);

    /*Contact Enquiries*/
    Route::get('contact-enquiries', [ContactEnquiriesController::class, 'contact_enquiries_view']);
    Route::get('delete-contact-enquiry/{userid}', [ContactEnquiriesController::class, 'delete_contact_enquiry']);
    Route::get('contact-enquiry-detail/{enqid}', [ContactEnquiriesController::class, 'contact_enquiry_detail_view']);
    Route::post('send-enquiry-response', [ContactEnquiriesController::class, 'contact_enquiry_send_response']);

    /*ExploreByHorse*/
    Route::get('explore_by_horse', [ExploreByHorseController::class, 'view_explore_horse_list']);
    Route::get('create-explore-breed', [ExploreByHorseController::class, 'view_add_new_explore_horse']);
    Route::post('create-explore-breed', [ExploreByHorseController::class, 'add_new_explore_horse']);
    Route::post('update-explore-breed-status', [ExploreByHorseController::class, 'update_explore_horse_status']);
    Route::get('edit-explore-breed-status/{slug}/{id}', [ExploreByHorseController::class, 'view_edir_new_explore_horse']);
    Route::post('update-explore-breed', [ExploreByHorseController::class, 'pdate_explore_horse']);

    /*Manage Admin*/
    Route::get('manage-admin-users', [AdminUsersController::class, 'manage_admin_view']);
    Route::get('add-admin-user', [AdminUsersController::class, 'add_admin_view']);
    Route::post('checkEmail', [AdminUsersController::class, 'checkEmail']);
    Route::post('checkMobile', [AdminUsersController::class, 'checkMobile']);
    Route::post('save-admin-user', [AdminUsersController::class, 'save_admin_user']);
    Route::get('edit-admin-user/{userid}/{token}', [AdminUsersController::class, 'edit_admin_view']);
    Route::post('update-admin-user', [AdminUsersController::class, 'update_admin_user']);
    Route::post('admin-delete-user', [AdminUsersController::class, 'admin_delete_user']);
    Route::post('update-blog', [AdminBlogController::class, 'update_blog']);

    /* User add & List */
    Route::get('users',  [UsersController::class, 'index']);
    Route::get('add_users',  [UsersController::class, 'create']);
    Route::post('UsercheckEmail', [UsersController::class, 'UsercheckEmail']);
    Route::post('UsercheckMobile', [UsersController::class, 'UsercheckMobile']);
    Route::get('blocked-users',  [UsersController::class, 'blocked_users']);
    Route::post('save_user',  [UsersController::class, 'store']);
    Route::post('get_user_suburb_list', [UsersController::class, 'subrub_list']);
    Route::get('edit_user/{id}/{token}', [UsersController::class, 'edit_user']);
    Route::post('update_user', [UsersController::class, 'update_user']);
    Route::post('user_update_status', [UsersController::class, 'user_status_update']);
});

Route::get('script_update_user_details', [ScriptController::class, 'update_password_and_token_into_user']);
Route::get('script_update_listing_details', [ScriptController::class, 'update_identification_code_into_listing']);
Route::get('script_update_free_listing', [ScriptController::class, 'update_free_listing_to_null']);
Route::get('script_update_blog_details', [ScriptController::class, 'update_slug_into_blogs']);
Route::get('script_update_dynamic_fields', [ScriptController::class, 'update_slug_into_dynamic_fields']);
Route::get('resizes_listing_images', [ScriptController::class, 'resizes_listing_images']);
Route::get('resizes_blog_images', [ScriptController::class, 'resizes_blog_images']);
Route::get('resizes_explore_by_horse_images', [ScriptController::class, 'resizes_explore_by_horse_images']);
Route::get('script_update_suburb_slug', [ScriptController::class, 'update_suburb_slug']);
