<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class UserAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
      if(Auth::check())
      {
        if(Auth::user()->isActive() && Auth::user()->isDelete())
        {
          if(Auth::user()->isUser())
          {
            return $next($request);
          }
          else
          {
            return redirect('/');
          }
        }
        else{
          Auth::logout();
          return redirect('/');
        }
      }
      else{
        return redirect('/');
      }

      return $next($request);
    }
}
