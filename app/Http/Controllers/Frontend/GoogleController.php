<?php

namespace App\Http\Controllers\Frontend;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Pipeline;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Str;

class GoogleController  extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function redirectToGoogle()
  {   
    return Socialite::driver('google')->redirect();
  }
      
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function handleGoogleCallback()
  {
    try
    {
      $user = Socialite::driver('google')->user();
      $find_normal_user = User::where('email', $user->email)->first();
      if(!empty($find_normal_user) && $find_normal_user->google_id == null)
      {
        return redirect('user/login')->with('error','Already registered');
      }
      else
      {
        $finduser = User::where('google_id', $user->id)->first();
        if($finduser)
        {
          Auth::login($finduser);
          return redirect('/');
        }
        else
        {
          $newUser = User::create([          
            'email' => $user->email,
            'google_id'=> $user->id,
            'social_type'=> 'google',
            'token' => Str::random(32),
            'role' => 'user',
            'is_verifed' => '1',
            'is_active' => '1',
            'password' => encrypt('my-google')
          ]);
   
          Auth::login($newUser);
          return redirect('/');
        }
      }

    }
    catch (Exception $e)
    {
      dd($e);
    }
  }
}
