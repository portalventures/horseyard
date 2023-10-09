<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClearFromAttributes
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
      if ($request->has('page') && $request->page == '1') {
        return redirect()->to($request->fullUrlWithoutQuery('page'));
      }

      return $next($request);
    }
}
