<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Log;
use Image;

class ListingMaster extends Model
{
  use HasFactory;

  public $timestamps = true;

  protected $table = "listing_master";

  protected $fillable = ['id', 'category_id', 'user_id', 'price', 'item_show_type', 'country_id', 'state_id', 'suburb_id', 'pic_number', 'title', 'description', 'horse_name', 'horse_registration_no', 'sire', 'dam', 'make', 'transport_model', 'year', 'kms', 'vehicle_registration_number', 'brand', 'saddlery_model', 'land_size', 'property_category', 'featured_image_url', 'video_url', 'contact_name', 'contact_number', 'contact_email', 'is_active', 'is_approved', 'is_blocked', 'is_delete', 'blocked_dt', 'approval_dt', 'slug', 'identification_code', 'ad_id', 'created_at', 'updated_at'];

  public function listing_owner()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function listing_meta()
  {
    return $this->hasOne(ListingMeta::class);
  }

  public function images()
  {
    return $this->hasMany(ListingImages::class);
  }

  public function dynamic_fields()
  {
    return $this->hasMany(ListingDynamicFieldValues::class);
  }

  public function get_deynemic_fileds($field_type)
  {
    if($field_type == 'horses')
    {
      $horses_discipline = DynamicFieldValues::where('field_id',1)->get();
      $horses_breed_primary = DynamicFieldValues::where('field_id',2)->get();
      $horses_breed_secondary = DynamicFieldValues::where('field_id',3)->get();
      $horses_color = DynamicFieldValues::where('field_id',4)->get();
      $horses_gender = DynamicFieldValues::where('field_id',5)->get();
      $horses_temperament = DynamicFieldValues::where('field_id',6)->get();
      $horses_age = DynamicFieldValues::where('field_id',7)->get();
      $horses_rider_Level = DynamicFieldValues::where('field_id',8)->get();
      $horses_height = DynamicFieldValues::where('field_id',9)->get();

      return ['horses_discipline' => $horses_discipline,
              'horses_breed_primary' => $horses_breed_primary,
              'horses_breed_secondary' => $horses_breed_secondary,
              'horses_color' => $horses_color,
              'horses_gender' => $horses_gender,
              'horses_temperament' => $horses_temperament,
              'horses_age' => $horses_age,
              'horses_rider_Level' => $horses_rider_Level,
              'horses_height' => $horses_height];
    }

    if($field_type == 'transport')
    {
      $transport_type = DynamicFieldValues::where('field_id',10)->get();
      $transport_no_of_horse_to_carry = DynamicFieldValues::where('field_id',11)->get();
      $transport_ramp_location = DynamicFieldValues::where('field_id',12)->get();
      $transport_axles = DynamicFieldValues::where('field_id',13)->get();
      $transport_registration_state = DynamicFieldValues::where('field_id',14)->get();

      return [  'transport_type' => $transport_type,
                'transport_no_of_horse_to_carry' => $transport_no_of_horse_to_carry,
                'transport_ramp_location' => $transport_ramp_location,
                'transport_axles' => $transport_axles,
                'transport_registration_state' => $transport_registration_state];
    }

    if($field_type == 'saddlery')
    {
      $saddlery_type = DynamicFieldValues::where('field_id',15)->get();
      $saddlery_category = DynamicFieldValues::where('field_id',16)->get();
      $saddlery_condition = DynamicFieldValues::where('field_id',17)->get();

      return [
        'saddlery_type' => $saddlery_type,
        'saddlery_category' => $saddlery_category,
        'saddlery_condition' => $saddlery_condition
      ];
    }

    if($field_type == 'property')
    {
      $property_Bedrooms = DynamicFieldValues::where('field_id',18)->get();
      $property_Bathrooms = DynamicFieldValues::where('field_id',19)->get();

      return [
        'property_Bedrooms' => $property_Bedrooms,
        'property_Bathrooms' => $property_Bathrooms
      ];
    }
  }

  public function create_new_ad_listing($request, $from, $slug_url, $is_active='', $is_approved='', $is_blocked='')
  {
    // try
    // {
      $insert_ad = ListingMaster::create([
        'category_id' => $request->listing_category,
        'user_id' => Auth()->user()->id,
        'price' => $request->price,
        'item_show_type'=> $request->item_show_type,
        'country_id' => $request->country,
        'state_id' => $request->state,
        'suburb_id' => $request->suburb,
        'pic_number' => $request->pic_number,
        'title' => $request->title,
        'description' => $request->description,

        'horse_name' => $request->has('horse_name') ? $request->horse_name : '',
        'horse_registration_no' => $request->has('horse_registration_no') ? $request->horse_registration_no : '',
        'sire' => $request->has('sire') ? $request->sire : '',
        'dam' => $request->has('dam') ? $request->dam : '',

        'make' => $request->has('make') ? $request->make : '',
        'transport_model' => $request->has('transport_model') ? $request->transport_model : '',
        'year' => $request->has('year') ? $request->year : '',
        'kms' => $request->has('kms') ? $request->kms : '',
        'vehicle_registration_number' => $request->has('vehicle_registration_number') ? $request->vehicle_registration_number : '',

        'brand' => $request->has('brand') ? $request->brand : '',
        'saddlery_model' => $request->has('saddlery_model') ? $request->saddlery_model : '',

        'land_size' => $request->has('land_size') ? $request->land_size : '',
        'property_category' => $request->has('property_category') ? $request->property_category : '',

        'video_url' => $request->video_url,
        'contact_name' => $request->contact_name,
        'contact_number' => $request->contact_number,
        'contact_email' => $request->contact_email,
        'is_active' => $is_active,
        'is_approved' => $is_approved,
        'is_blocked' => $is_blocked,
        'slug' => $slug_url,
        'identification_code' => Str::random(32),
        'ad_id' => strtoupper(str_pad(rand(0,999), 5, STR_PAD_LEFT))
      ]);

      $listing_master_insertedId = $insert_ad->id;

      $all_top_categories = TopCategory::where('id',$request->listing_category)->first();

      self::create_new_ad_DynamicFieldValues($request, $all_top_categories, $listing_master_insertedId);

      self::create_ad_images($request, $listing_master_insertedId);

      return true;
    // }
    // catch (\Exception\Database\QueryException $e)
    // {
    //   Log::info('Query: '.$e->getSql());
    //   Log::info('Query: Bindings: '.$e->getBindings());
    //   Log::info('Error: Code: '.$e->getCode());
    //   Log::info('Error: Message: '.$e->getMessage());
    //   return false;
    // }
    // catch (\Exception $e)
    // {
    //   Log::info('Error: Code: '.$e->getCode());
    //   Log::info('Error: Message: '.$e->getMessage());
    //   return false;
    // }
  }

  public function update_ad_listing($request,$from,$slug_url, $ad_data)
  {
    try
    {
      $listing_master_insertedId = $ad_data->id;

      $ad_update_data = [
        'category_id' => $request->listing_category,
        'price' => $request->price,
        'item_show_type'=> $request->item_show_type,
        'country_id' => $request->country,
        'state_id' => $request->state,
        'suburb_id' => $request->suburb,
        'pic_number' => $request->pic_number,
        'title' => $request->title,
        'description' => $request->description,

        'horse_name' => $request->has('horse_name') ? $request->horse_name : '',
        'horse_registration_no' => $request->has('horse_registration_no') ? $request->horse_registration_no : '',
        'sire' => $request->has('sire') ? $request->sire : '',
        'dam' => $request->has('dam') ? $request->dam : '',

        'make' => $request->has('make') ? $request->make : '',
        'transport_model' => $request->has('transport_model') ? $request->transport_model : '',
        'year' => $request->has('year') ? $request->year : '',
        'kms' => $request->has('kms') ? $request->kms : '',
        'vehicle_registration_number' => $request->has('vehicle_registration_number') ? $request->vehicle_registration_number : '',

        'brand' => $request->has('brand') ? $request->brand : '',
        'saddlery_model' => $request->has('saddlery_model') ? $request->saddlery_model : '',

        'land_size' => $request->has('land_size') ? $request->land_size : '',
        'property_category' => $request->has('property_category') ? $request->property_category : '',

        'video_url' => $request->video_url,
        'contact_name' => $request->contact_name,
        'contact_number' => $request->contact_number,
        'contact_email' => $request->contact_email,
        'slug' => $slug_url
      ];

      $listing_master_update = ListingMaster::where('id',$listing_master_insertedId)->update($ad_update_data);

      $all_top_categories = TopCategory::where('id',$request->listing_category)->first();

      if($all_top_categories->id == $ad_data->category_id)
      {
        if($all_top_categories->category_name == "horses")
        {
          if(isset($request->discipline))
          {          
            $discipline_values = explode(',',$request->discipline);
            $discipline = ListingDynamicFieldValues::where(['field_id' => 1, 'listing_master_id' => $ad_data->id])->first();

            if(!empty($discipline))
            {
              $discipline->update(['dynamic_field_id' => $discipline_values[1]]);
            }
            else
            {
              $new_discipline = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $discipline_values[0],
                'dynamic_field_id' => $discipline_values[1]
              ]);              
            }
          }
          
          if(isset($request->temperament))
          {          
            $temperament_values = explode(',',$request->temperament);
            $horses_temperament = ListingDynamicFieldValues::where(['field_id'=> 6, 'listing_master_id' => $ad_data->id] )->first();

            if(!empty($horses_temperament))
            {
              $horses_temperament->update(['dynamic_field_id' => $temperament_values[1]]);
            }
            else{
              $new_temperament = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $temperament_values[0],
                'dynamic_field_id' => $temperament_values[1]
              ]);
            }
          }

          if(isset($request->breed_primary))
          {          
            $breed_primary_values = explode(',',$request->breed_primary);
            $horses_breed_primary = ListingDynamicFieldValues::where(['field_id'=> 2,'listing_master_id' => $ad_data->id])->first();

            if(!empty($horses_breed_primary))
            {
              $horses_breed_primary->update(['dynamic_field_id' => $breed_primary_values[1]]);
            }
            else{
              $new_breed_primary = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $breed_primary_values[0],
                'dynamic_field_id' => $breed_primary_values[1]
              ]);
            }
          }                                                              
          
          if(isset($request->breed_secondary))
          {          
            $breed_secondary_values = explode(',',$request->breed_secondary);
            $horses_breed_secondary = ListingDynamicFieldValues::where(['field_id'=> 3,'listing_master_id' => $ad_data->id] )->first();

            if(!empty($horses_breed_secondary))
            { 
              $horses_breed_secondary->update(['dynamic_field_id' => $breed_secondary_values[1]]);
            }
            else{
              $new_breed_secondary = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $breed_secondary_values[0],
                'dynamic_field_id' => $breed_secondary_values[1]
              ]);
            }
          }

          if(isset($request->age))
          {          
            $age_values = explode(',',$request->age);
            $horses_age = ListingDynamicFieldValues::where(['field_id'=> 7, 'listing_master_id' => $ad_data->id] )->first();

            if(!empty($horses_age))
            {
              $horses_age->update(['dynamic_field_id' => $age_values[1]]);
            }
            else{
              $new_age = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $age_values[0],
                'dynamic_field_id' => $age_values[1]
              ]);
            }                                                 
          }
          
          if(isset($request->horses_rider_Level))
          {          
            $horses_rider_Level_values = explode(',',$request->horses_rider_Level);
            $horses_rider_Level = ListingDynamicFieldValues::where(['field_id'=> 8, 'listing_master_id' => $ad_data->id] )->first();

            if(!empty($horses_rider_Level))
            {
              $horses_rider_Level->update(['dynamic_field_id' => $horses_rider_Level_values[1]]);
            }
            else{
              $new_horses_rider_Level = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $horses_rider_Level_values[0],
                'dynamic_field_id' => $horses_rider_Level_values[1]
              ]);
            }                                                          
          }
          
          if(isset($request->color))
          {          
            $color_values = explode(',',$request->color);
            $horses_color = ListingDynamicFieldValues::where(['field_id'=> 4, 'listing_master_id' => $ad_data->id] )->first();

            if(!empty($horses_color))
            {
              $horses_color->update(['dynamic_field_id' => $color_values[1]]);
            }
            else{
              $new_color = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $color_values[0],
                'dynamic_field_id' => $color_values[1]
              ]);
            }
          }
          
          if(isset($request->height))
          {
            $height_values = explode(',',$request->height);
            $horses_height = ListingDynamicFieldValues::where(['field_id'=> 9, 'listing_master_id' => $ad_data->id])->first();

            if(!empty($horses_height))
            {
              $horses_height->update(['dynamic_field_id' => $height_values[1]]);
            }
            else
            {
              $new_height = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $height_values[0],
                'dynamic_field_id' => $height_values[1]
              ]);
            }                                                   
          }

          if(isset($request->gender))
          {          
            $gender_values = explode(',',$request->gender);
            $horses_gender = ListingDynamicFieldValues::where(['field_id'=> 5, 'listing_master_id' => $ad_data->id] )->first();

            if(!empty($horses_gender))
            {
              $horses_gender->update(['dynamic_field_id' => $gender_values[1]]);
            }
            else
            {
              $new_gender = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $gender_values[0],
                'dynamic_field_id' => $gender_values[1]
              ]);
            }
          }
        }
        elseif($all_top_categories->category_name == "transport")
        {
          if(isset($request->transport_type))
          {
            $transport_type_values = explode(',',$request->transport_type);
            $transport_type = ListingDynamicFieldValues::where(['field_id' => 10, 'listing_master_id' => $ad_data->id])->first();
            if(!empty($transport_type))
            {
              $transport_type->update(['dynamic_field_id' => $transport_type_values[1]]);
            }
            else
            {
              $new_transport_type = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $transport_type_values[0],
                'dynamic_field_id' => $transport_type_values[1]
              ]);
            }
          }
          
          if(isset($request->axles))
          {
            $axles_values = explode(',',$request->axles);
            $transport_axles = ListingDynamicFieldValues::where(['field_id' => 13, 'listing_master_id' => $ad_data->id])->first();
            if(!empty($transport_axles))
            {
              $transport_axles->update(['dynamic_field_id' => $axles_values[1]]);
            }
            else
            {
              $new_axles = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $axles_values[0],
                'dynamic_field_id' => $axles_values[1]
              ]);
            }
          }

          if(isset($request->transport_no_of_horse_to_carry))
          {
            $transport_no_of_horse_to_carry_values = explode(',',$request->transport_no_of_horse_to_carry);
            $transport_no_of_horse_to_carry = ListingDynamicFieldValues::where(['field_id' => 11,'listing_master_id' => $ad_data->id])->first();

            if(!empty($transport_no_of_horse_to_carry))
            {
              $transport_no_of_horse_to_carry->update(['dynamic_field_id' => $transport_no_of_horse_to_carry_values[1]]);
            }
            else
            {
              $new_transport_no_of_horse_to_carry = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $transport_no_of_horse_to_carry_values[0],
                'dynamic_field_id' => $transport_no_of_horse_to_carry_values[1]
              ]);
            }
          }

          if(isset($request->transport_registration_state))
          {
            $transport_registration_state_values = explode(',',$request->transport_registration_state);
            $transport_registration_state = ListingDynamicFieldValues::where(['field_id' => 14, 'listing_master_id' => $ad_data->id])->first();

            if(!empty($transport_registration_state))
            {
              $transport_registration_state->update(['dynamic_field_id' => $transport_registration_state_values[1]]);
            }
            else
            {
              $new_transport_registration_state = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $transport_registration_state_values[0],
                'dynamic_field_id' => $transport_registration_state_values[1]
              ]);
            }
          }

          if(isset($request->transport_ramp_location))
          {
            $transport_ramp_location_values = explode(',',$request->transport_ramp_location);
            $transport_ramp_location = ListingDynamicFieldValues::where(['field_id' => 12,'listing_master_id' => $ad_data->id])->first();

            if(!empty($transport_ramp_location))
            {
              $transport_ramp_location->update(['dynamic_field_id' => $transport_ramp_location_values[1]]);
            }
            else
            {
              $new_transport_ramp_location = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $transport_ramp_location_values[0],
                'dynamic_field_id' => $transport_ramp_location_values[1]
              ]);
            }
          }
        }
        elseif($all_top_categories->category_name == "saddlery")
        {
          if(isset($request->saddlery_type))
          {          
            $saddlery_type_values = explode(',',$request->saddlery_type);
            $saddlery_type = ListingDynamicFieldValues::where(['field_id' => 15, 'listing_master_id' => $ad_data->id])->first();
            
            if(!empty($saddlery_type))
            {
              $saddlery_type->update(['dynamic_field_id' => $saddlery_type_values[1]]);
            }
            else
            {
              $new_saddlery_type = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $saddlery_type_values[0],
                'dynamic_field_id' => $saddlery_type_values[1]
              ]);
            }
          }
          
          if(isset($request->saddlery_condition))
          {
            $saddlery_condition_values = explode(',',$request->saddlery_condition);
            $saddlery_condition = ListingDynamicFieldValues::where(['field_id' => 17,'listing_master_id' => $ad_data->id])->first();
            if(!empty($saddlery_condition))
            {
              $saddlery_condition->update(['dynamic_field_id' =>$saddlery_condition_values[1]]);
            }
            else
            {
              $new_saddlery_condition = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $saddlery_condition_values[0],
                'dynamic_field_id' => $saddlery_condition_values[1]
              ]);
            }
          }
          
          if(isset($request->saddlery_category))
          {
            $saddlery_category_values = explode(',',$request->saddlery_category);
            $saddlery_category = ListingDynamicFieldValues::where(['field_id' => 16,
                                                                    'listing_master_id' => $ad_data->id])->first();

            if(!empty($saddlery_category))
            {
              $saddlery_category->update(['dynamic_field_id' => $saddlery_category_values[1]]);
            }
            else
            {
              $new_saddlery_category = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $saddlery_category_values[0],
                'dynamic_field_id' => $saddlery_category_values[1]
              ]);              
            }
          }
        }
        elseif($all_top_categories->category_name == "property")
        {
          if(isset($request->property_Bedrooms))
          {
            $property_Bedrooms_values = explode(',',$request->property_Bedrooms);
            $property_Bathrooms = ListingDynamicFieldValues::where(['field_id' => 18,
                                                                    'listing_master_id' => $ad_data->id])->first();

            if(!empty($property_Bathrooms))
            {
              $property_Bathrooms->update(['dynamic_field_id' =>$property_Bedrooms_values[1]]);
            }
            else
            {
              $new_property_Bedrooms = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $property_Bedrooms_values[0],
                'dynamic_field_id' => $property_Bedrooms_values[1]
              ]);              
            }
          }

          if(isset($request->property_Bathrooms))
          {
            $property_Bathrooms_values = explode(',',$request->property_Bathrooms);
            $property_Bedrooms = ListingDynamicFieldValues::where(['field_id' => 19, 'listing_master_id' => $ad_data->id])->first();
            if(!empty($property_Bedrooms))
            {
              $property_Bedrooms->update(['dynamic_field_id' => $property_Bathrooms_values[1]]);
            }
            else
            {
              $new_property_Bathrooms = ListingDynamicFieldValues::create([
                'listing_master_id' => $listing_master_insertedId,
                'field_id' => $property_Bathrooms_values[0],
                'dynamic_field_id' => $property_Bathrooms_values[1]
              ]);              
            }
          }
        }
      }
      else
      {
        $delete_all_listing_dynamic_values = ListingDynamicFieldValues::where('listing_master_id',$listing_master_insertedId)->delete();

        self::create_new_ad_DynamicFieldValues($request, $all_top_categories, $listing_master_insertedId);
      }

      self::create_ad_images($request, $listing_master_insertedId);

      return true;
    }
    catch (\Exception\Database\QueryException $e)
    {
      Log::info('Query: '.$e->getSql());
      Log::info('Query: Bindings: '.$e->getBindings());
      Log::info('Error: Code: '.$e->getCode());
      Log::info('Error: Message: '.$e->getMessage());
      return false;
    }
    catch (\Exception $e)
    {
      Log::info('Error: Code: '.$e->getCode());
      Log::info('Error: Message: '.$e->getMessage());
      return false;
    }
  }

  public function create_new_ad_DynamicFieldValues($request, $all_top_categories, $listing_master_insertedId)
  {
    if($all_top_categories->category_name == "horses")
    {
      if(isset($request->discipline))
      {
        $discipline_values = explode(',',$request->discipline);
        $discipline = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $discipline_values[0],
          'dynamic_field_id' => $discipline_values[1]
        ]);        
      }

      if(isset($request->temperament))
      {
        $temperament_values = explode(',',$request->temperament);
        $temperament = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $temperament_values[0],
          'dynamic_field_id' => $temperament_values[1]
        ]);
      }
      if(isset($request->breed_primary))
      {
        $breed_primary_values = explode(',',$request->breed_primary);
        $breed_primary = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $breed_primary_values[0],
          'dynamic_field_id' => $breed_primary_values[1]
        ]);
      }

      if(isset($request->breed_secondary))
      {
        $breed_secondary_values = explode(',',$request->breed_secondary);
        $breed_secondary = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $breed_secondary_values[0],
          'dynamic_field_id' => $breed_secondary_values[1]
        ]);
      }

      if(isset($request->age))
      {
        $age_values = explode(',',$request->age);
        $age = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $age_values[0],
          'dynamic_field_id' => $age_values[1]
        ]);
      }

      if(isset($request->horses_rider_Level))
      {      
        $horses_rider_Level_values = explode(',',$request->horses_rider_Level);
        $horses_rider_Level = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $horses_rider_Level_values[0],
          'dynamic_field_id' => $horses_rider_Level_values[1]
        ]);
      }

      if(isset($request->color))
      {
        $color_values = explode(',',$request->color);
        $color = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $color_values[0],
          'dynamic_field_id' => $color_values[1]
        ]);
      }
      
      if(isset($request->height))
      {
        $height_values = explode(',',$request->height);
        $height = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $height_values[0],
          'dynamic_field_id' => $height_values[1]
        ]);
      }
      
      if(isset($request->gender))
      {
        $gender_values = explode(',',$request->gender);
        $gender = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $gender_values[0],
          'dynamic_field_id' => $gender_values[1]
        ]);
      }
    }
    elseif($all_top_categories->category_name == "transport")
    {
      if(isset($request->transport_type))
      {
        $transport_type_values = explode(',',$request->transport_type);
        $transport_type = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $transport_type_values[0],
          'dynamic_field_id' => $transport_type_values[1]
        ]);
      }

      if(isset($request->axles))
      { 
        $axles_values = explode(',',$request->axles);
        $axles = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $axles_values[0],
          'dynamic_field_id' => $axles_values[1]
        ]);
      }

      if(isset($request->transport_no_of_horse_to_carry))
      {            
        $transport_no_of_horse_to_carry_values = explode(',',$request->transport_no_of_horse_to_carry);
        $transport_no_of_horse_to_carry = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $transport_no_of_horse_to_carry_values[0],
          'dynamic_field_id' => $transport_no_of_horse_to_carry_values[1]
        ]);
      }

      if(isset($request->transport_registration_state))
      {      
        $transport_registration_state_values = explode(',',$request->transport_registration_state);
        $transport_registration_state = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $transport_registration_state_values[0],
          'dynamic_field_id' => $transport_registration_state_values[1]
        ]);
      }
      if(isset($request->transport_ramp_location))
      {      
        $transport_ramp_location_values = explode(',',$request->transport_ramp_location);
        $transport_ramp_location = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $transport_ramp_location_values[0],
          'dynamic_field_id' => $transport_ramp_location_values[1]
        ]);
      }
    }
    elseif($all_top_categories->category_name == "saddlery")
    {
      if(isset($request->saddlery_type))
      {      
        $saddlery_type_values = explode(',',$request->saddlery_type);
        $saddlery_type = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $saddlery_type_values[0],
          'dynamic_field_id' => $saddlery_type_values[1]
        ]);
      }
      
      if(isset($request->saddlery_condition))
      {      
        $saddlery_condition_values = explode(',',$request->saddlery_condition);
        $saddlery_condition = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $saddlery_condition_values[0],
          'dynamic_field_id' => $saddlery_condition_values[1]
        ]);
      }
      
      if(isset($request->saddlery_category))
      {      
        $saddlery_category_values = explode(',',$request->saddlery_category);
        $saddlery_category = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $saddlery_category_values[0],
          'dynamic_field_id' => $saddlery_category_values[1]
        ]);
      }
    }
    elseif($all_top_categories->category_name == "property")
    {
      if(isset($request->property_Bedrooms))
      {
        $property_Bedrooms_values = explode(',',$request->property_Bedrooms);
        $property_Bedrooms = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $property_Bedrooms_values[0],
          'dynamic_field_id' => $property_Bedrooms_values[1]
        ]);
      }
      
      if(isset($request->property_Bathrooms))
      {
        $property_Bathrooms_values = explode(',',$request->property_Bathrooms);
        $property_Bathrooms = ListingDynamicFieldValues::create([
          'listing_master_id' => $listing_master_insertedId,
          'field_id' => $property_Bathrooms_values[0],
          'dynamic_field_id' => $property_Bathrooms_values[1]
        ]);
      }
    }
  }

  public function create_ad_images($request, $listing_master_insertedId)
  {
    $path = 'listing_images/' . $listing_master_insertedId;

    if(!\File::isDirectory($path))
    {
      \File::makeDirectory($path, 0775, true, true);
    }

    $resize_path = 'listing_images_250/' . $listing_master_insertedId;

    if(!\File::isDirectory($resize_path))
    {
      \File::makeDirectory($resize_path, 0775, true, true);
    }

    if ($request->hasfile('lisintg_images')) {
      $files = $request->file('lisintg_images');
      foreach ($files as $file) {
        $filename = $file->getClientOriginalName();
        $file->move(public_path($path), $filename);
        $ad_image = ListingImages::create([
          'listing_master_id' => $listing_master_insertedId,
          'image_name' => $filename,
          'image_url' => $path
        ]);

        if(file_exists(public_path('/listing_images/'.$listing_master_insertedId.'/'.$filename)))
        {
          $check_img = getimagesize(public_path('/listing_images/'.$listing_master_insertedId.'/'.$filename));

          if($check_img)
          {
            $img = Image::make(public_path('/listing_images/'.$listing_master_insertedId.'/'.$filename));
            $img->resize(250, 250, function ($constraint) {
              $constraint->aspectRatio();
            })->save($resize_path.'/'.$filename);
          }
        }
      }
    }
  }

  public function isActive()
  {
    return $this->is_active === '1';
  }

  public function isDelete()
  {
    return $this->is_delete === '0';
  }  

  public function generateQueryURL()
  {
    $listingId = $this->id;

    $allDynamicFields = $this->dynamic_fields();

    $query_url = '';
    if($this->category_id == 1) {
      $query_url .= 'horses';
    } else if($this->category_id == 2) {
      $query_url .= 'transport';
    } else if($this->category_id == 3) {
      $query_url .= 'saddlery';
    } else if($this->category_id == 4) {
      $query_url .= 'property';
    } else {
      $query_url .= 'horses';
    }
    
    if(!empty($allDynamicFields)) {
      foreach($allDynamicFields as $key => $value) {
        $query_url .= DELIM_MAIN . $value;
      }
    }

    $stateObj = State::find($this->state_id);
    
    if(!empty($stateObj))
    {
      $query_url .= DELIM_MAIN . str_replace(' ', DELIM_SECONDARY, $stateObj->state_name) . DELIM_PRIMARY . $stateObj->state_code;
    }

    $query_url .= DELIM_MAIN . $this->ad_id;

    $query_url = strtolower($query_url);

    //error_log("listing master : " . print_r($listingId . '  ' . $query_url, TRUE) . "\n", 3, "c:\\Users\\shiva\\Desktop\\php_errors.log" );

    return $query_url;
  }
}
