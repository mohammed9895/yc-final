<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Interfaces\MustVerifyMobile;
use Illuminate\Support\Facades\Redirect;

class EnsureMobileIsVerifiedMiddleware
{
    public function handle(Request $request, Closure $next, $redirectToRoute = null)
    {
        if (!$request->user()->hasVerifiedPhone()) {
            if ($request->getPathInfo() != '/cp') {
                return redirect('cp');
            }
        }

        return $next($request);
    }
}
