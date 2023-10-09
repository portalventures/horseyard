<?php

namespace App\Http\Controllers\Frontend;

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

use App\Models\User;

use App\Models\State;
use App\Models\Suburb;
use App\Models\TopCategory;
use App\Models\CategoryDynamicFields;
use App\Models\DynamicFieldValues;
use App\Models\ListingMaster;
use App\Models\ListingDynamicFieldValues;
use App\Models\ListingImages;
use App\Models\ListingReports;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Filesystem\Filesystem;
use App\helpers;
use App\Http\Traits\EmailTrait;

class AdsController extends Controller
{
    use EmailTrait;

    public $listing_master;
    public $suburb;
    public $State;

    public function __construct(ListingMaster $listing_master, Suburb $suburb, State $State)
    {
        $this->listing_master = $listing_master;
        $this->suburb = $suburb;
        $this->State = $State;
    }

    public function ad_list_created_by_user($value = '')
    {
        $current_page = 'manage-ads';
        $user_ads = Auth()->user()->user_listings()
            ->where('is_delete', '0')
            ->orderBy('id', 'DESC')
            ->paginate(5);
        return view('front.account.ads.manage_ads', compact('current_page', 'user_ads'));
    }

    public function create_listing(Request $request)
    {
        $current_page = 'create_listing';
        $all_state = State::get();
        $all_top_categories = TopCategory::get();

        $get_all_horses_dynamicFields = '';
        $category_type = '';
        $category_id = '';
        $property_category_array = '';

        if (isset($request->cate_type)) {
            $category_type = $request->cate_type;
            $top_category = TopCategory::where('category_name', $category_type)->first();
            $category_id = $top_category->id;
            $property_category_array = ['N/A', 'Agistment', 'For lease', 'For sale'];
            $get_all_horses_dynamicFields = $this->listing_master->get_deynemic_fileds($category_type);
        }

        return view('front.account.ads.create-listing', compact(
            'current_page',
            'all_state',
            'all_top_categories',
            'get_all_horses_dynamicFields',
            'category_type',
            'category_id',
            'property_category_array'
        ));
    }

    public function subrub_list(Request $request)
    {
        $suburb_list = $this->suburb->get_suburb_list_based_on_state($request->state);
        $from = 'admin';
        return view('shared.suburb_list', compact('suburb_list', 'from'));
    }

    public function categoryType_dynemic_fileds(Request $request)
    {
        $get_all_horses_dynamicFields =  $this->listing_master->get_deynemic_fileds($request->categoryType);

        if ($request->ad_slug_url != '0') {
            $ad_data = ListingMaster::where('slug', $request->ad_slug_url)->first();
        } else {
            $ad_data = '';
        }

        if ($request->categoryType == 'transport') {
            if (!empty($ad_data)) {
                $transport_type = ListingDynamicFieldValues::where(['field_id' => 10, 'listing_master_id' => $ad_data->id])->first();
                $transport_no_of_horse_to_carry = ListingDynamicFieldValues::where(['field_id' => 11, 'listing_master_id' => $ad_data->id])->first();
                $transport_ramp_location = ListingDynamicFieldValues::where(['field_id' => 12, 'listing_master_id' => $ad_data->id])->first();
                $transport_axles = ListingDynamicFieldValues::where(['field_id' => 13, 'listing_master_id' => $ad_data->id])->first();
                $transport_registration_state = ListingDynamicFieldValues::where(['field_id' => 14, 'listing_master_id' => $ad_data->id])->first();
            } else {
                $transport_type = '';
                $transport_no_of_horse_to_carry = '';
                $transport_ramp_location = '';
                $transport_axles = '';
                $transport_registration_state = '';
            }
            return view('front.account.ads.listingTypeTransport', compact(
                'get_all_horses_dynamicFields',
                'ad_data',
                'transport_type',
                'transport_no_of_horse_to_carry',
                'transport_ramp_location',
                'transport_axles',
                'transport_registration_state'
            ));
        } elseif ($request->categoryType == 'saddlery') {
            if (!empty($ad_data)) {
                $saddlery_type = ListingDynamicFieldValues::where(['field_id' => 15, 'listing_master_id' => $ad_data->id])->first();
                $saddlery_category = ListingDynamicFieldValues::where(['field_id' => 16, 'listing_master_id' => $ad_data->id])->first();
                $saddlery_condition = ListingDynamicFieldValues::where(['field_id' => 17, 'listing_master_id' => $ad_data->id])->first();
            } else {
                $saddlery_type = '';
                $saddlery_category = '';
                $saddlery_condition = '';
            }
            return view('front.account.ads.listingTypeSaddlery', compact(
                'get_all_horses_dynamicFields',
                'ad_data',
                'saddlery_type',
                'saddlery_category',
                'saddlery_condition'
            ));
        } elseif ($request->categoryType == 'property') {
            if (!empty($ad_data)) {
                $property_Bedrooms = ListingDynamicFieldValues::where(['field_id' => 18, 'listing_master_id' => $ad_data->id])
                    ->first();
                $property_Bathrooms = ListingDynamicFieldValues::where(['field_id' => 19, 'listing_master_id' => $ad_data->id])->first();
            } else {
                $property_Bedrooms = '';
                $property_Bathrooms = '';
            }

            $property_category_array = ['N/A', 'Agistment', 'For lease', 'For sale'];
            return view('front.account.ads.listingTypeProperty', compact(
                'get_all_horses_dynamicFields',
                'property_category_array',
                'ad_data',
                'property_Bedrooms',
                'property_Bathrooms'
            ));
        } elseif ($request->categoryType == "horses") {
            if (!empty($ad_data)) {
                $horses_discipline = ListingDynamicFieldValues::where([
                    'field_id' => 1,
                    'listing_master_id' => $ad_data->id
                ])->first();
                $horses_breed_primary = ListingDynamicFieldValues::where([
                    'field_id' => 2,
                    'listing_master_id' => $ad_data->id
                ])->first();
                $horses_breed_secondary = ListingDynamicFieldValues::where([
                    'field_id' => 3,
                    'listing_master_id' => $ad_data->id
                ])->first();
                $horses_color = ListingDynamicFieldValues::where([
                    'field_id' => 4,
                    'listing_master_id' => $ad_data->id
                ])->first();
                $horses_gender = ListingDynamicFieldValues::where([
                    'field_id' => 5,
                    'listing_master_id' => $ad_data->id
                ])->first();
                $horses_temperament = ListingDynamicFieldValues::where([
                    'field_id' => 6,
                    'listing_master_id' => $ad_data->id
                ])->first();
                $horses_age = ListingDynamicFieldValues::where([
                    'field_id' => 7,
                    'listing_master_id' => $ad_data->id
                ])->first();
                $horses_rider_Level = ListingDynamicFieldValues::where([
                    'field_id' => 8,
                    'listing_master_id' => $ad_data->id
                ])->first();
                $horses_height = ListingDynamicFieldValues::where([
                    'field_id' => 9,
                    'listing_master_id' => $ad_data->id
                ])->first();
            } else {
                $horses_discipline = '';
                $horses_breed_primary = '';
                $horses_breed_secondary = '';
                $horses_color = '';
                $horses_gender = '';
                $horses_temperament = '';
                $horses_age = '';
                $horses_rider_Level = '';
                $horses_height = '';
            }
            return view('front.account.ads.listingTypeHorses', compact(
                'get_all_horses_dynamicFields',
                'ad_data',
                'horses_discipline',
                'horses_breed_primary',
                'horses_breed_secondary',
                'horses_color',
                'horses_gender',
                'horses_temperament',
                'horses_age',
                'horses_rider_Level',
                'horses_height'
            ));
        }
    }

    public function create_ad(Request $request)
    {
        $slug_url = Str::slug($request->title);
        $is_active = '0';
        $is_approved = null;
        $is_blocked = '0';
        $new_listing = $this->listing_master->create_new_ad_listing($request, 'admin', $slug_url, $is_active, $is_approved, $is_blocked);

        $all_admin_emails = User::where(['is_active' => '1', 'role' => 'superadmin'])->pluck('email');

        foreach ($all_admin_emails as $key => $email) {
            $subj = "New listing request";
            $message = "New listing request : " . $request->title;
            $toAddr = $email;
            $email_response =  $this->sendMail("", $toAddr, $subj, $message);
        }

        return $new_listing;
    }

    public function edit_ad(Request $request)
    {
        $current_page = 'edit-listing';
        $ad_data = ListingMaster::where('identification_code', $request->token)->first();
        $all_state = State::get();
        $suburb_list = $this->suburb->get_suburb_list_based_on_state($ad_data->state_id);
        $all_top_categories = TopCategory::get();

        $ad_images = $ad_data->images()->get();
        return view('front.account.ads.edit-listing', compact('current_page', 'ad_data', 'all_state', 'ad_images', 'all_top_categories', 'suburb_list'));
    }

    public function view_listing(Request $request)
    {
        $current_page = 'view_ad';
        $ad_data = ListingMaster::where([
            'identification_code' => $request->token,
            'is_delete' => '0'
        ])
            ->first();
        $ad_images = $ad_data->images()->get();
        return view('front.account.ads.view_ad', compact(
            'current_page',
            'ad_data',
            'ad_images'
        ));
    }

    public function delete_listing_image(Request $request)
    {
        $get_image = ListingImages::where('id', $request->image_id)->first();
        ListingImages::where('id', $request->image_id)->delete();
        $path = $get_image->image_url . '/' . $get_image->image_name;
        unlink(public_path($path));
    }

    public function ad_status_update(Request $request)
    {
        $ad_data = ListingMaster::where('id', $request->ad_id)->first();
        $new_status = '';
        if ($ad_data->is_active == '0') {
            $new_status = '1';
        } else {
            $new_status = '0';
        }

        $ad_data->fill(['is_active' => $new_status])->save();
    }

    public function update_ad(Request $request)
    {
        $ad_data = ListingMaster::where('slug', $request->ad_slug_url)->first();

        $slug_url = Str::slug($request->title);
        $is_active = $ad_data->is_active;
        $is_approved = $ad_data->is_approved;
        $is_blocked = $ad_data->is_blocked;
        $update_listing = $this->listing_master->update_ad_listing($request, 'admin', $slug_url, $ad_data, $is_active, $is_approved, $is_blocked);
        return $update_listing;
    }

    public function add_report(Request $request)
    {
        $listing = ListingMaster::where('identification_code', $request->listing_id)->firstOrFail();
        ListingReports::create([
            'listing_master_id' => $listing->id,
            'name' => $request->name,
            'email' => $request->email,
            'reason' => $request->report_reason,
            'message' => $request->report_message
        ]);
        return true;
    }
}
