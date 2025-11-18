<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\AttachmentSelectedController;


class EnsureAttachmentSelected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check() && auth()->user()->role){
            $user_role = auth()->user()->role;
            if($request->session()->has('attachment_id') && $request->session()->has('attachment_name')){
                if($user_role == 'student'){
                    if($request->session()->has('attachment_student_id')){
                        return $next($request);
                    }
                }
               elseif($user_role == 'lecturer'){
                    if($request->session()->has('attachment_lecturer_id')){
                        return $next($request);
                    }
                }else{
                    return $next($request);
                }


            }


        }


        $controllerOutput = app(\App\Http\Controllers\AttachmentSelectedController::class)
            ->index($request);

        return response()->make($controllerOutput);
    }
}
