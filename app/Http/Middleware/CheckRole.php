<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\AdminUserPermission;
use App\Models\PermissionsCategory;
use App\Models\CpoUsers;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        

         $user_id=Auth::guard('admin')->user()->id;
         $login_type=Auth::guard('admin')->user()->type;
         if($login_type==0){
           
         }else{
            if($role=='staff_report')
         {
            return redirect('no_access');
         }

         if($role=='assign_users')
         {
            return redirect('no_access');
         }

         if($role=='users')
         {
            return redirect('no_access');
         }
             
         }
         


      
        return $next($request);
    }
}