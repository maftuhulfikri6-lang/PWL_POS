<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
{
    // 1. Cek apakah user sudah login
    if (!$request->user()) {
        return redirect('login'); // Atau abort(401, 'Unauthorized');
    }

    // 2. Gunakan null-safe operator atau pengecekan method untuk keamanan
    $user_role = $request->user()->getRole(); 

    // 3. Validasi
    if(in_array($user_role, $roles)){ 
        return $next($request); 
    }
    
    // 4. Jika tidak punya akses
    abort(403, 'Forbidden. Kamu tidak punya akses ke halaman ini');
}
}