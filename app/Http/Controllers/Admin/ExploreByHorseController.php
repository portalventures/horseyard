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
use App\Models\User;
use App\Models\State;
use App\Models\Suburb;
use App\Models\TopCategory;
use App\Models\CategoryDynamicFields;
use App\Models\DynamicFieldValues;
use App\Models\ExploreByHorse;
use Illuminate\Filesystem\Filesystem;
use App\helpers;
use Image;

class ExploreByHorseController extends Controller
{
  public function view_explore_horse_list($value='')
  {
    $current_page = 'explore_horse';
    $ExploreByHorse_count = ExploreByHorse::count();
    $explore_horse = ExploreByHorse::select('explore_by_horse.id as explore_by_horse_id',
                                            'explore_by_horse.image as image',
                                            'explore_by_horse.is_active as is_active',  
                                            'dynamic_field_values.field_value as brand_name')
                                    ->join('dynamic_field_values', function($join)
                                    {
                                      $join->on('explore_by_horse.primary_breed_id','=','dynamic_field_values.id');
                                    })
                                    ->get();
    return view('admin.explore_horse.index',compact('explore_horse','current_page','ExploreByHorse_count'));
  }

  public function view_add_new_explore_horse($value='')
  {
    $ExploreByHorse_count = ExploreByHorse::count();
    if($ExploreByHorse_count < 7)
    {
      $all_primary_breed = DynamicFieldValues::where('field_id', 2)->whereNotIn('id', function($q){
        $q->select('primary_breed_id')->from('explore_by_horse');      
      })->get();
      $current_page = 'explore_horse';
      return view('admin.explore_horse.create_explore_horse',compact('all_primary_breed','current_page'));
    }
    else{
      return redirect('admin/explore_by_horse');
    }      
  }

  public function add_new_explore_horse(Request $request)
  {
    $current_page = 'explore_horse';

    $this->validate($request, [
      'breed' => 'required',
      'explore_by_horse_image' => 'required|mimes:jpeg,png,jpg', 
    ]);

    $path = 'explore_by_horse/';

    if(!\File::isDirectory($path))
    {
      \File::makeDirectory($path, 0775, true, true);
    }
    
    $resize_path = 'explore_by_horse_250/';

    if(!\File::isDirectory($resize_path))
    {
      \File::makeDirectory($resize_path, 0775, true, true);
    }

    if ($request->hasfile('explore_by_horse_image')) {
      if($files = $request->file('explore_by_horse_image')){  
        $image_name = time().'-'.$files->getClientOriginalName();  
        $files->move(public_path('explore_by_horse'),$image_name); 
      }

      if(file_exists(public_path('/explore_by_horse_image/'.$image_name)))
      {
        $check_img = getimagesize(public_path('/explore_by_horse_image/'.$image_name));

        if($check_img)
        {
          $img = Image::make(public_path('/explore_by_horse_image/'.$image_name));          
          $img->resize(250, 250, function ($constraint) {
            $constraint->aspectRatio();
          })->save($resize_path.$image_name);
        }
      }
    }

    ExploreByHorse::create([
      'created_by' => Auth()->user()->id, 
      'primary_breed_id' => $request->breed,
      'image' => $image_name
    ]);
    
    return redirect('admin/explore_by_horse')->with('success','Added successfully');
  }

  public function view_edir_new_explore_horse(Request $request)
  {
    $current_page = 'explore_horse';
    
    $explore_horse = ExploreByHorse::find($request->id);
    
    $all_primary_breed = DynamicFieldValues::where('field_id', 2)->whereNotIn('id', function($q){
      $q->select('primary_breed_id')->from('explore_by_horse');      
    })->get();
    
    return view('admin.explore_horse.edit_explore_horse',compact('explore_horse','all_primary_breed','current_page'));  
  }

  public function pdate_explore_horse(Request $request)
  {
    $this->validate($request, [
      'breed' => 'required',
      'explore_by_horse_image' => 'mimes:jpeg,png,jpg', 
    ]);

    $current_page = 'edit_blog';
    $explore_horse = ExploreByHorse::find($request->explore_horse_id);
    
    $explore_horse->fill([
      'primary_breed_id' => $request->breed,
    ])->save();

    if ($request->hasfile('explore_by_horse_image')){
      if($files = $request->file('explore_by_horse_image'))
      {
        $resize_path = 'explore_by_horse_250/';

        if(!\File::isDirectory($resize_path))
        {
          \File::makeDirectory($resize_path, 0775, true, true);
        }

        $delete_path = public_path('explore_by_horse'.'/'.$explore_horse->image);
        $delete_resize_path = public_path('explore_by_horse_250'.'/'.$explore_horse->image);

        if(file_exists($delete_path))
        {
          unlink($delete_path);
        }

        if(file_exists($delete_resize_path))
        {
          unlink($delete_resize_path);
        }

        $image_name = time().'-'.$files->getClientOriginalName();
        $files->move(public_path('explore_by_horse'),$image_name);

        if(file_exists(public_path('/explore_by_horse/'.$image_name)))
        {
          $check_img = getimagesize(public_path('/explore_by_horse/'.$image_name));

          if($check_img)
          {
            $img = Image::make(public_path('/explore_by_horse/'.$image_name));          
            $img->resize(250, 250, function ($constraint) {
              $constraint->aspectRatio();
            })->save(public_path('explore_by_horse_250/').$image_name);
          }
        }

        $explore_horse->fill([       
          'image' => $image_name          
        ])->save();        
      }
    }
    return redirect('admin/explore_by_horse')->with('success','Updated successfully');
  } 

  public function update_explore_horse_status(Request $request)
  {
    $explore_horse = ExploreByHorse::find($request->explore_horse_id);

    if($explore_horse->is_active == '1') {
      $explore_horse->is_active = '0';
    } else {
      $explore_horse->is_active = '1';
    }

    $explore_horse->save();
  }  
}
