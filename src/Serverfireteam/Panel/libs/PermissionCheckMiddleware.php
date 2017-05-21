<?php

namespace Serverfireteam\Panel\libs;

use Lang;
use Closure;
use Gate;

use App\User;
use Spatie\Permission\Models\Permission;
use Serverfireteam\Panel\Admin;

class PermissionCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    protected $app;
    public function handle($request, Closure $next)
    {   

        $admin= User::find((\Auth::user()->id));
        
        $urlSegments   = $request->segments();

        if ($admin->hasRole('admin')){

            return $next($request);
        }else{
            if (key_exists(2 , $urlSegments)){

                $permissionToCheck = 'view /' . $urlSegments[1] . '/' . $urlSegments[2];

                if (Permission::whereName($permissionToCheck)->count()) {
                    if ($admin->hasPermissionTo($permissionToCheck)) {

                        return $next($request);
                    } else {
                        /**
                         * Show Access denied page to User
                         */
                        
                        abort(403);
                    }
                } else {
                    abort(404);
                }
            }
            return $next($request);

        }

    }
}
