<?php

namespace App\Http\Controllers\Frontend;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Pipeline;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;
use App\Http\Controllers\Route;
use App\helpers;
use App\Http\Traits\EmailTrait;

class LoginController extends Controller
{
  use EmailTrait;
  public $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function login_view(Request $request)
  {
    $view = 'login';
    session(['link' => url()->previous()]);
    return view('front.login_signup.login', compact('view'));
  }

  public function sign_up_view()
  {
    $view = 'signup';
    return view('front.login_signup.signup', compact('view'));    
  }

  public function authenticate(Request $request)
  {
    $getauthuser_details = User::where('email',$request->email)->first();
    
    if(!empty($getauthuser_details->password))
    {
      if(!empty($getauthuser_details) && $getauthuser_details->isUser())
      {
        if($getauthuser_details->is_verifed == 0)
        {
          return back()->with('error','Your account is not verifed');
        }
        elseif($getauthuser_details->is_active == 0 || $getauthuser_details->is_delete == 1)
        {
          return back()->with('error','Your account is deactivated');
        }
        else
        {
          $user_data = array(
            'email'  => $request->email,
            'password' => $request->password        
          );
          
          if(Auth::attempt($user_data))
          {
            return redirect(session('link'));
          }
          else{
            return back()->with('error','Wrong credentials!');
          }
        }
      }
      else
      {
        return back()->with('error','Account not found');
      }
    }
    else
    {
      return back()->with('error','your password is expired please use forgotten password!');
    }       
  }

  public function register_user(Request $request)
  {
    $this->validate($request,[
      'email' => 'required|email',
      'password' => 'required',
      "confpassword" => 'required|same:password',
    ]);

    try
    {
      $getauthuser_details = User::where('email',$request->email)->first();
      if (!empty($getauthuser_details) && $getauthuser_details->is_verifed == '1' && $getauthuser_details->is_active == '1') 
      {
        return back()->with('error','Email address is already in use');
      }
      else
      {
        $getauthuser_details = User::where(['email' => $request->email, 'is_verifed' => '0', 'is_active' => '0',])->delete();

        $signup_code = substr(str_shuffle("0123456789"), 0, 5);
        $register_user = User::create([
          'email'  => $request->email,
          'password' => Hash::make($request->password),
          'token' => Str::random(32),
          'verification_code' => $signup_code,
          'is_verifed' => '0',
          'is_active' => '0',
          'role' => 'user',
        ]);        
        
        $message = "your verification code = " . $register_user->verification_code;
        $toAddr = $register_user->email;
        $subj = "Verification code from " . config('app.name');
        $email_response =  $this->sendMail("", $toAddr, $subj, $message);

        //$email_response =  $this->user->send_verification_code($register_user,'signup');

        return redirect("signup_verify/".$register_user->token);
      }
    }
    catch (\Exception\Database\QueryException $e)
    {
      Log::info('Query: '.$e->getSql());
      Log::info('Query: Bindings: '.$e->getBindings());
      Log::info('Error: Code: '.$e->getCode());
      Log::info('Error: Message: '.$e->getMessage());
      return back()->with('error','Something went wrong please try again');
    }
    catch (\Exception $e)
    {
      Log::info('Error: Code: '.$e->getCode());
      Log::info('Error: Message: '.$e->getMessage());
      return back()->with('error','Something went wrong please try again');
    }
  }

  public function signup_verify(Request $request)
  {
    $getauthuser_details = User::where('token',$request->token)->first();
    $from = "signup";
    return view('front.login_signup.verify_code', compact('getauthuser_details','from'));
  }
  
  public function verify_account_code(Request $request)
  {
    $getauthuser_details = User::where('token',$request->token)->first();

    if($request->from == "signup")
    {
      if($getauthuser_details->verification_code == $request->verification_code)
      {
        $update_user = User::where('token',$request->token)
                            ->update([ 'is_verifed' => '1',
                                      'is_active' => '1',
                                      'verification_code' => '']);
        Auth::login($getauthuser_details);
        return redirect('/');
      }
      else{
        return back()->with('error','Wrong verification code');
      }
    }
    else{
      if($getauthuser_details->verification_code == $request->verification_code)
      {
        return redirect("changepassword/".$getauthuser_details->token);
      }
      else{
        //return back()->with('error','Wrong verification code');
        $error = 'Wrong verification code';
                \Session::put('error', $error);
                $from = "forgot_password";
        return view('front.login_signup.verify_code', compact('getauthuser_details', 'from', 'error'));
      }
    }
  }

  public function forgot_password_email(Request $request)
  {
    $view = 'login';
    return view('front.login_signup.forgot_password_email_verify', compact('view'));
  }

  public function forgot_password_verify_emailaddress(Request $request)
  {
    $getauthuser_details = User::where('email',$request->email)->first();
   
    if(empty($getauthuser_details))
    {
      return back()->with('error','Account not found');
    }
    else
    {
      $forgot_code = substr(str_shuffle("0123456789"), 0, 5);
      $update_user_details = User::where('email',$request->email)
                                  ->update(['verification_code' => $forgot_code]);

      $getauthuser_details = User::where('email',$request->email)->first();
      //$email_response =  $this->user->send_verification_code($getauthuser_details,'');
      $from = "forgot_password";

      $message = "your verification code = " . $getauthuser_details->verification_code;
      $toAddr = $getauthuser_details->email;
      $subj = "Verification Code from : " . config('app.name');
      $email_response =  $this->sendMail("", $toAddr, $subj, $message);

      return view('front.login_signup.verify_code', compact('getauthuser_details','from'));      

    }
  }

  public function changepassword_view(Request $request)
  {
    $getauthuser_details = User::where('token',$request->token)->first();      
    if($getauthuser_details->verification_code != "")
    {
      $view = 'login';
      return view('front.login_signup.update_password', compact('getauthuser_details','view'));
    }
    else{
      return redirect('user/login');
    }
  }

  public function changepassword(Request $request)
  {
    $this->validate($request,[
      'password' => 'required',
      "confpassword" => 'required|same:password',
    ]);

    $getauthuser_details = User::where('token',$request->token)->first();
    if(!empty($getauthuser_details))
    {
      $update_user = User::where('token',$request->token)
                          ->update(['password' => Hash::make($request->password),
                                'verification_code' => '']);
      return redirect('user/login')->with('success'.'Password change successfully');
    }
    else
    {
      return redirect('user/login')->with('error'.'Something went wrong');
    }
  }

  public function user_my_profile($value='')
  {
    $current_page = 'my_profile';
    return view('front.my_profile.my_profile', compact('current_page'));
  }
}
