<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    use GeneralTrait;
    public function profile_data(Request $request)
    {
        $token=$request->header('auth-token');
        if($token)
        {
            $admin =Auth::guard('admin-api')->user();
            return $this->returnData('admin',$admin);
        }
        else
        {
            return $this->returnError('','Unauthenticated user');
        }
    }
}
