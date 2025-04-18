<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Student;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    { 

        if ($this->auth->guard($guard)->guest()) {

            return response(['message' => 'unauthorized'], '401');
        }
        
        if($this->auth->user()->is_lock == 1){

            return response(['message' => 'That You Are Not Qualified Anymore.'],401);
        }

        return $next($request);
    }
}
