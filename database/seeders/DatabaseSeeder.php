<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;

use App\Models\User;

use App\Models\Country;
use App\Models\State;
use App\Models\Suburb;

use App\Models\TopCategory;
use App\Models\CategoryDynamicFields;
use App\Models\DynamicFieldValues;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
  public function run()
  {
    TopCategory::truncate();
    CategoryDynamicFields::truncate();
    DynamicFieldValues::truncate();
    
    $top_categories = ['horses','transport','saddlery','property'];

    $Horses_dynamic_fields = ['Discipline','Breed_Primary','Breed_Secondary','Colour','Gender','Temperament','Age','Rider_Level','Height'];

      $Horses_Discipline = ['Adult Riding Club','All Rounders','Barrel','Breeding','Campdraft','Cutting','Dressage','Driving','Endurance','Eventing','Harness','Off the track','Other','Performance','Pleasure','Polo','Pony Club','Racing','Reining','Rodeo','School Masters','Show','Showjumping','Sport','Trail Riding'];

      $Horses_Breed_Primary_Secondary = ["American Saddlebred","Andalusian","Appaloosa","Arabian","Australian Stock Horse","Azteca","Brumby","Cleveland Bay","Clydesdale","Coloured Breeds","Connemara","Donkeys / Mules","Draught","Fjord","Friesian","Gypsy","Hackney","Haflinger","Hanoverian","Holsteiner","Icelandic","Irish Sport Horse","Knabstrupper","Miniature","Morgan","Native Pony Breeds","Paint","Palouse","Percheron","Pinto","Ponies","Quarter Horse","Riding Pony","Shetland","Shire","Sport","Sportaloosa","Standardbred","Thoroughbred","Trakehner","Waler","Warmblood","Welsh"];

      $Horses_Colour = ['Albino','Bay','Black','Brown','Buckskin','Champagne','Chestnut','Coloured','Cremello','Dun','Grey','Other','Palomino','Perlino','Pinto','Roan','Spotted','White'];
      
      $Horses_Gender = ['Colt','Filly','Gelding','Mare','Stallion','Stud'];

      $Horses_Temperament = ['1-Calm','2','3','4','5-Hot'];

      $Horses_Age = ['0-Foal/Weanling','1-Yearling','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];
      
      $Horses_Rider_Level = ['Anyone but Novice','Experienced','Extreme Rider Needed!!','Not Applicable','Novice','Pony Club','Beginner','Intermediate','Advance'];

      $Horses_Height = ['6','6.1','6.2','6.3','7','7.1','7.2','7.3','8','8.1','8.2','8.3','9','9.1','9.2','9.3','10','10.1','10.2','10.3','11','11.1','11.2','11.3','12','12.1','12.2','12.3','13','13.0','13.1','13.2','13.3','14','14.1','14.2','14.3','15','15.1','15.2','15.3','16','16.1','16.2','16.3','17','17.1','17.2','17.3','18'];

    $Transport_dynamic_fields = ['Transport_Type','No_of_Horse_to_Carry','Ramp_Location','Axles','Registration_state'];
      $Transport_Type = ['Horse Floats','Gooseneck','Horse Trucks','Other'];
      $Transport_No_of_Horse_to_Carry = ['1','2','3','4','5','6','7','8','9+'];
      $Transport_Ramp_Location = ['Front','Rear','Side'];
      $Transport_Axles = ['1','2','3','4','5','6','7','8','9','10'];
      $Transport_Registration_state = ['ACT','NSW','NT','NZ (North Island)','NZ (South Island)','QLD','SA','TAS','VIC','WA'];

    $Saddlery_dynamic_fields = ['Saddlery_Type','Saddlery_Category','Condition'];
      $Saddlery_Saddlery_Type = ['All Purpose Saddles','Appaloosas','Arabians','Bitless Bridles','Bridle Accessories','Dressage saddle','Dressage Saddles','English Bridles','Four wheel electric brakes','Half Breed Saddles','Horse Accessories','Horse Clothing','Horse Drawn','Horse Drawn Vehicles','Horse Harness','Horse Rugs','Jumping Saddles','Miscellaneous','Other Bridles','Other Saddles','Riding Boots','Riding Helmets','Saddle Accessories','Stable &amp; Training','Stock Saddles','Treeless saddles','Wanted Second Hand Gear','Western Bridles','Western saddles'];
      $Saddlery_Saddlery_Category = ['Saddlery_Category_1','Saddlery_Category_2','Saddlery_Category_3','Saddlery_Category_4'];
      $Saddlery_Condition = ['Condition_1', 'Condition_2','Condition_3','Condition_4'];

    $Property_dynamic_fields = ['Bedrooms','Bathrooms'];
      $Property_Bedrooms = ['1','2','3','4','5','6','7','8','9','10'];
      $Property_Bathrooms = ['1','2','3','4','5','6','7','8','9','10'];


    foreach ($top_categories as $value)
    {
      $main_category = TopCategory::create([
        'category_name' => $value
      ]);

      if($value == 'horses')
      {
        foreach ($Horses_dynamic_fields as $value)
        {
          $Horses_category_dynamic_field = CategoryDynamicFields::create([
            'category_id' => $main_category->id,
            'field_name' => $value
          ]);

          if($value == 'Discipline')
          {
            $Horses_DynamicFieldValues = $Horses_Discipline;
          }
          elseif($value == 'Breed_Primary' || $value == 'Breed_Secondary')
          {
            $Horses_DynamicFieldValues = $Horses_Breed_Primary_Secondary;
          }
          elseif($value == 'Colour')
          {
            $Horses_DynamicFieldValues = $Horses_Colour;
          }
          elseif($value == 'Gender')
          {
            $Horses_DynamicFieldValues = $Horses_Gender;
          }
          elseif($value == 'Temperament')
          {
            $Horses_DynamicFieldValues = $Horses_Temperament;
          }
          elseif($value == 'Age')
          {
            $Horses_DynamicFieldValues = $Horses_Age;
          }
          elseif($value == 'Rider_Level')
          {
            $Horses_DynamicFieldValues = $Horses_Rider_Level;
          }
          elseif($value == 'Height')
          {
            $Horses_DynamicFieldValues = $Horses_Height;
          }
          if(!empty($Horses_DynamicFieldValues))
          {
            foreach ($Horses_DynamicFieldValues as $value)
            {
              DynamicFieldValues::create([
                'field_id' => $Horses_category_dynamic_field->id,
                'field_value' => $value
              ]);
            }
          }
        }
      }

      if($value == 'transport')
      {
        foreach ($Transport_dynamic_fields as $value)
        {
          $Transport_category_dynamic_field = CategoryDynamicFields::create([
            'category_id' => $main_category->id,
            'field_name' => $value
          ]);

          if($value == 'Transport_Type')
          {
            $Transport_DynamicFieldValues = $Transport_Type;
          }
          elseif($value == 'No_of_Horse_to_Carry')
          {
            $Transport_DynamicFieldValues = $Transport_No_of_Horse_to_Carry;
          }
          elseif($value == 'Ramp_Location')
          {
            $Transport_DynamicFieldValues = $Transport_Ramp_Location;
          }
          elseif($value == 'Axles')
          {
            $Transport_DynamicFieldValues = $Transport_Axles;
          }
          elseif($value == 'Registration_state')
          {
            $Transport_DynamicFieldValues = $Transport_Registration_state;
          }
          if(!empty($Transport_DynamicFieldValues))
          {
            foreach ($Transport_DynamicFieldValues as $value)
            {
              DynamicFieldValues::create([
                'field_id' => $Transport_category_dynamic_field->id,
                'field_value' => $value
              ]);
            }
          }
        }
      }

      if($value == 'saddlery')
      {
        foreach ($Saddlery_dynamic_fields as $value)
        {
          $Saddlery_category_dynamic_field = CategoryDynamicFields::create([
            'category_id' => $main_category->id,
            'field_name' => $value
          ]);

          if($value == 'Saddlery_Type')
          {
            $Saddlery_DynamicFieldValues = $Saddlery_Saddlery_Type;
          }
          elseif($value == 'Saddlery_Category')
          {
            $Saddlery_DynamicFieldValues = $Saddlery_Saddlery_Category;
          }
          elseif($value == 'Condition')
          {
            $Saddlery_DynamicFieldValues = $Saddlery_Condition;
          }
          if(!empty($Saddlery_DynamicFieldValues))
          {
            foreach ($Saddlery_DynamicFieldValues as $value)
            {
              DynamicFieldValues::create([
                'field_id' => $Saddlery_category_dynamic_field->id,
                'field_value' => $value
              ]);
            }
          }
        }
      }

      if($value == 'property')
      {
        foreach ($Property_dynamic_fields as $value)
        {
          $Property_category_dynamic_field = CategoryDynamicFields::create([
            'category_id' => $main_category->id,
            'field_name' => $value
          ]);

          if($value == 'Bedrooms')
          {
            $Property_DynamicFieldValues = $Property_Bedrooms;
          }
          elseif($value == 'Bathrooms')
          {
            $Property_DynamicFieldValues = $Property_Bathrooms;
          }

          foreach ($Property_DynamicFieldValues as $value)
          {
            DynamicFieldValues::create([
              'field_id' => $Property_category_dynamic_field->id,
              'field_value' => $value
            ]);
          }            
        }
      }
    }
  
    $Country_category = Country::create([
      'country_name' => 'Australia',
      'country_code' => 'AU'
    ]);
    
    $addSuperAdmin = User::where('email', 'horseyard_superadmin@inuscg.com')->first();
    
    if(empty($addSuperAdmin))
    {
      User::create([
        'email' => 'horseyard_superadmin@inuscg.com',
        'password' => Hash::make('P@assw0rd'),
        'is_verifed' => '1',
        'is_active' => '1',
        'role' => 'superadmin',
        'token' => Str::random(32),
      ]);  
    }
  }
}
