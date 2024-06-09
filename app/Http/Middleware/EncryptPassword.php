<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Hash;

class EncryptPassword
{
    public function handle($request, Closure $next)
    {
        if ($request->has('password')) {
            $request->merge(['password' => Hash::make($request->password)]);
        }

        return $next($request);
    }
}
