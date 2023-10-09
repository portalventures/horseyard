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
use App\helpers;

class MyProfileController extends Controller
{
  public $suburb;
  public $State;

  public function __construct(Suburb $suburb,State $State)
  {
    $this->suburb = $suburb;
    $this->State = $State;
  }

  public function user_view_profile($value='')
  {
    $current_page = 'my_profile';
    return view('front.account.my_profile.my_profile', compact('current_page'));
  }

  public function user_edit_profile($value='')
  {
    $states = State::get();
    $suburb_list = '';
    if(!empty(Auth()->user()->state))
    {
      $suburb_list =  $this->suburb->get_suburb_list_based_on_state(Auth()->user()->state);
    }

    $current_page = 'my_profile';
    return view('front.account.my_profile.edit_my_profile', compact('current_page','states','suburb_list'));
  }

  public function subrub_list(Request $request)
  {
    $suburb_list =  $this->suburb->get_suburb_list_based_on_state($request->state);
    $from = 'user';
    return view('shared.suburb_list', compact('suburb_list','from'));
  }

  public function user_update_profile_details(Request $request)
  {   
    $user = User::findOrFail(Auth()->user()->id);    
    //dd($request->date_of_birth);
    $user->fill([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'state' => $request->state,
      'suburb' => $request->suburb,
      'gender' => $request->gender,
      'date_of_birth' => $request->date_of_birth,
      'phone_number' => $request->phone_number,
      'company_name' => $request->company_name,
      'address_line_1' => $request->address_line_1,
      'postal_code' => $request->postal_code
    ])->save();

    
    return redirect('my-profile')->with('success','Details updated successfully');
  }

  public function update_password(Request $request)
  {
    $user = User::findOrFail(Auth()->user()->id);
   
    $this->validate($request,[
      'new_password' => 'required',
      "confpassword" => 'required|same:new_password',
    ]);

    if(Hash::check($request->oldpassword, $user->password))
    { 
      $user->fill([
        'password' => Hash::make($request->new_password)
      ])->save();

      return back()->with('success','Password changed');
    }
    else
    {
      return back()->with('error','Password does not match');
    }
  }
}
