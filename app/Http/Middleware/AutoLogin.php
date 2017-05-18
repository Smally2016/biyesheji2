<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Validation\UnauthorizedException;
use Someline\Models\Foundation\City;
use Someline\Models\Foundation\Country;
use Someline\Models\Foundation\Favourite;
use Someline\Models\Foundation\Province;
use Someline\Models\Foundation\User;

class AutoLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $oauth_user = session('wechat.oauth_user');

        $is_login = Auth::check();
        if ($oauth_user && $is_login) {
            $user = User::where('open_id', $oauth_user->id)->first();
            if ($user) {
                $user->update([
                    'open_id' => $oauth_user->id
                ]);
            }
        }


        if ($is_login || empty($oauth_user)) {
            return $next($request);
        }


        return $next($request);
    }

}
