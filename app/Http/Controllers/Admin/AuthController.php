<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use GeneralTrait;
    public function login(Request $request)
    {
        try
        {
            $rules=[
                'email'=>"required|exists:admins,email",
                'password'=>"required"
            ];
            $validator=Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                $code=$this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
            }
            $credients=$request->only(['email','password']);
            $token=Auth::guard('admin-api')->attempt($credients);
            if(!$token)
            {
                return $this->returnError('E001','Invalid Data');
            }
            else
            {
                $user =Auth::guard('admin-api')->user();
                $user ->api_token =$token;
                return $this->returnData('auth-token',$token);
            }
        }
        catch(\Exception $ex)
        {
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }
    }
    public function logout(Request $request)
    {
        $token =$request->header('auth-token');
        if($token)
        {
            try{
                JWTAuth::setToken($token)->invalidate();
            }
            catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('','some thing went wrong');
            }
            return $this->returnsuccessMessage('logged out sucessfully');
        }
        else
        {
            return $this->returnError('','some thing went wrong');
        }
    }

}
