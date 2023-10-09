<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\State;
use App\Models\Suburb;
use App\Models\ListingMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Traits\EmailTrait;

class UsersController extends Controller
{
  use EmailTrait;
  public $suburb;
  public $State;

  public function __construct(Suburb $suburb,State $State)
  {
    $this->suburb = $suburb;
    $this->State = $State;
  }

  public function index()
  {
    $current_page = 'user_list';
    $users = User::where(['role' => 'user', 'is_active' => '1', 'is_delete' => '0'])
                  ->paginate(25);

    return view('admin.user.index', compact('users','current_page'));
  }

  public function blocked_users()
  {
    $current_page = 'blocked_user_list';
    $users = User::where(['role' => 'user', 'is_active' => '0', 'is_delete' => '0'])->paginate(25);

    return view('admin.user.blocked_users', compact('users','current_page'));
  }

  public function create()
  {
    $current_page = 'add_users';
    $all_state = State::get();
    return view('admin.user.create', compact('current_page','all_state'));
  }

  public function UsercheckEmail(Request $request)
  {
    if($request->get('email'))
    {
      $email = $request->get('email');
      $adminUser = DB::table("users")
      ->where('email', $email)
      ->count();

      if($adminUser > 0)
      {
        echo 'not_unique';
      }
      else
      {
        echo 'unique';
      }
    }
  }

  public function UsercheckMobile(Request $request)
  {
    if($request->get('phone_number'))
    {
      $phone_number = $request->get('phone_number');
      $adminUser = DB::table("users")
      ->where('phone_number', $phone_number)
      ->count();

      if($adminUser > 0)
      {
        echo 'not_unique';
      }
      else
      {
        echo 'unique';
      }
    }
  }

  public function store(Request $request)
  {
    
    $this->validate($request, [
      'first_name' => 'required',
      'last_name'    => 'required',
      'email' => 'required|email|unique:users',
      'phone_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
    ]);

    $newpassword = Str::random(16);

    User::create([
      'first_name' => $request->first_name,
      'company_name' => $request->company_name,
      'last_name' => $request->last_name,
      'address_line_1' => $request->address_line_1,
      'email' => $request->email,
      'password' => \Hash::make($newpassword),
      'state' => $request->state,
      'phone_number' => $request->phone_number,
      'suburb' => $request->suburb,
      'gender' => $request->gender,
      'postal_code' => $request->postal_code,
      'token' => Str::random(32),
      'is_active' => '1',
      'is_verifed' => '1',
      'role' => 'user',
    ]);
    
    $subj = "Horseyard password";
    $message = "Your horseyard password = " . $newpassword;
    $toAddr = $request->email;      
    $email_response =  $this->sendMail("", $toAddr, $subj, $message);

    return redirect('admin/users')->with('message','User added successfully');
  }

  public function subrub_list(Request $request)
  {
    $suburb_list = $this->suburb->get_suburb_list_based_on_state($request->state);
    $from = 'admin';
    return view('shared.suburb_list', compact('suburb_list','from'));
  }

  public function user_status_update(Request $request)
  {
    $new_status = '';
    $user_data = User::where('id', $request->user_id)->first();

    if($user_data->is_active == '0')
    {
      $new_status = '1';
      $email_response_msg = "Activated";
    }
    else{
      $new_status = '0';
      $email_response_msg = "Deactivated";
    }

    $user_data->fill(['is_active' => $new_status])->save();

    $update_listings = ListingMaster::where('user_id',$request->user_id)->update(['is_active' => $new_status]);

    // $subj = "Account " . $email_response_msg;
    // $message = "Your account has been " . $email_response_msg;
    // $toAddr = $user_data->email;
    // $email_response =  $this->sendMail("", $toAddr, $subj, $message);
  }

  public function edit_user(Request $request)
  {
    $current_page = 'edit_user';
    $user = User::where('id',$request->id)->first();
    $all_state = State::get();
    $suburb_list = $this->suburb->get_suburb_list_based_on_state($user->state);
    return view('admin.user.edit_user',compact('current_page','user','all_state','suburb_list'));
  }

  public function update_user(Request $request)
  {
    $this->validate($request, [
      'first_name' => 'required',
      'company_name' => 'required',
      'last_name'    => 'required',
      'address_line_1'  => 'required',
      'email' => 'required|email',
      'state' => 'required',
      'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
      'suburb' => 'required',
      'gender' => 'required',
      'postal_code' => 'required',
    ]);

    $current_page = 'edit_user';
    $user = User::where('id',$request->user_id)->firstOrFail();

    $user->fill([
      'first_name' => $request->first_name,
      'company_name' => $request->company_name,
      'last_name' => $request->last_name,
      'address_line_1' => $request->address_line_1,
      'email' => $request->email,
      'state' => $request->state,
      'phone_number' => $request->phone_number,
      'suburb' => $request->suburb,
      'gender' => $request->gender,
      'postal_code' => $request->postal_code,
    ])->save();

    return back()->with('success','User updated successfully');
  }
}
