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
use App\Models\Blog;
use App\Models\State;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Filesystem\Filesystem;
use App\helpers;
use Image;

class AdminBlogController extends Controller
{
  public function blog_list(Request $request)
  {
    $current_page = 'blogs';
    $search_key_word = '';

    if(isset($request->search) && !empty($request->search))
    {
      $search_key_word = $request->search;
      $blogs = Blog::where('is_delete','0')
                    ->where(function ($query) use ($search_key_word) {
                      $query->orWhere('title', 'LIKE', "%{$search_key_word}%");
                      $query->orWhere('detailed_text', 'LIKE', "%{$search_key_word}%");
                      $query->orWhere('category_id', 'LIKE', "%{$search_key_word}%");        
                    })->paginate(10);
    }
    else
    {
      $blogs = Blog::where('is_delete','0')->paginate(10);
    }
    return view('admin.blog.blogs',compact('current_page','blogs','search_key_word'));
  }

  public function create_blog_view($value='')
  {
    $current_page = 'create_blog';    
    return view('admin.blog.create_blog',compact('current_page'));
  }

  public function create_blog(Request $request)
  {
    $this->validate($request, [
      'title' => 'required',
      'detailed_text' => 'required',
      'blog_image' => 'required|mimes:jpeg,png,jpg', 
    ]);

    $path = 'blog_images/';    
    
    if(!\File::isDirectory($path))
    {
      \File::makeDirectory($path, 0775, true, true);
    }
    
    $resize_path = 'blog_images_250/';

    if(!\File::isDirectory($resize_path))
    {
      \File::makeDirectory($resize_path, 0775, true, true);
    }

    if ($request->hasfile('blog_image')) {
      if($files = $request->file('blog_image')){  
        $image_name = time().'-'.$files->getClientOriginalName();  
        $files->move(public_path('blog_images'),$image_name); 
      }

      if(file_exists(public_path('/blog_images/'.$image_name)))
      {
        $check_img = getimagesize(public_path('/blog_images/'.$image_name));

        if($check_img)
        {
          $img = Image::make(public_path('/blog_images/'.$image_name));          
          $img->resize(250, 250, function ($constraint) {
            $constraint->aspectRatio();
          })->save($resize_path.$image_name);
        }
      }
    }

    /*
    $showInHdFt = 0;
    if($request->has('show_in_header') && $request->has('show_in_footer')) {
      $showInHdFt = 3;
    } else if($request->has('show_in_footer')) {
      $showInHdFt = 2;
    } else if($request->has('show_in_header')) {
      $showInHdFt = 1;
    } else {
      $showInHdFt = 0;
    }
    */
    Blog::create([
      'title' => $request->title,
      'slug' => create_slug($request->title,'blogs'),
      'detailed_text' => $request->detailed_text,
      'image' => $image_name,
      'category_id' => $request->category
    ]);

    return redirect('admin/all-blogs')->with('success','Blog added successfully');
    //return back()->with('success','Blog added successfully');
  }

  public function edit_blog_view(Request $request)
  {
    $current_page = 'edit_blog';
    $blog = Blog::where('id',$request->id)->first();

    return view('admin.blog.edit_blog',compact('current_page','blog'));
  }

  public function update_blog(Request $request)
  {
    $this->validate($request, [
      'title' => 'required',
      'detailed_text' => 'required',
      'blog_image' => 'mimes:jpeg,png,jpg', 
    ]);

    $current_page = 'edit_blog';
    $blog = Blog::where('id',$request->blog_id)->firstOrFail();
    
    $blog->fill([
      'title' => $request->title,
      'slug' => update_slug($blog->id,$request->title,'blogs'),
      'detailed_text' => $request->detailed_text,
      'category_id' => $request->category
    ])->save();

    if ($request->hasfile('blog_image')){
      if($files = $request->file('blog_image'))
      {        
        $path = public_path('blog_images'.'/'.$blog->image);
        $resize_path = public_path('blog_images_250'.'/'.$blog->image);

        if(file_exists($path))
        {
          unlink($path);
        }

        if(file_exists($resize_path))
        {
          unlink($resize_path);
        }

        $image_name = time().'-'.$files->getClientOriginalName();
        $files->move(public_path('blog_images'),$image_name);

        if(file_exists(public_path('/blog_images/'.$image_name)))
        {
          $check_img = getimagesize(public_path('/blog_images/'.$image_name));

          if($check_img)
          {
            $img = Image::make(public_path('/blog_images/'.$image_name));          
            $img->resize(250, 250, function ($constraint) {
              $constraint->aspectRatio();
            })->save(public_path('blog_images_250/').$image_name);
          }
        }

        $blog->fill([       
          'image' => $image_name          
        ])->save();        
      }
    }

    //return back()->with('success','Blog updated successfully');
    return redirect('admin/all-blogs')->with('success','Blog updated successfully');
  } 
 
  public function update_blog_status(Request $request)
  {
    
    //error_log("You messed up! : " . $id, 3, "php://stdout");
    $current_page = 'manage_blog';
    $blog = Blog::find($request->blog_id);

    if($blog->is_active == '1') {
      $blog->is_active = '0';
    } else {
      $blog->is_active = '1';
    }

    $blog->save();
  }

  public function delete_blog(Request $request, $id)
  {    
    //error_log("You messed up! : " . $id, 3, "php://stdout");
    $current_page = 'manage_blog';
    $blog = Blog::find($request->id);

    if($blog->is_delete == '1') {
      $blog->is_delete = '0';
    } else {
      $blog->is_delete = '1';
    }

    $blog->save(); 

    return redirect('admin/all-blogs')->with('blogsuccessmsg','Blog deleted successfully');
  }  
}
