<?php

namespace App\Traits;

use App\Providers\RouteServiceProvider;

trait AuthTrait
{
    public function chekGuard($request){

        if($request->type == 'student'){
            $guardName= 'student';
        }
        elseif ($request->type == 'parent'){
            $guardName= 'parent';
        }
        elseif ($request->type == 'teacher'){
            $guardName= 'teacher';
        }
        else{
            $guardName= 'web';
        }
        return $guardName;
    }

    public function redirect($request){
    switch ($request->type) {
    case 'student':
        return redirect()->intended(route('student.dashboard'));
    case 'teacher':
        return redirect()->intended(route('teacher.dashboard'));
    case 'parent':
        return redirect()->intended(route('parent.dashboard'));
    default:
        return redirect('/');
}
    }
}