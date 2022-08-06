<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use GeneralTrait;
    public function show()
    {
        try{
            $Users=User::all();
            if($Users)
            {
                return $this->returnData('Users',$Users);
            }
            else{
                return $this->returnError('E001','Data Not Found');
            }
        }
        catch(Exception $ex)
        {
            return $this->returnError('E001','Something Went Error Please Try Again');
        }
    }
    public function delete(Request $request)
    {
        try{
            $Users=User::find($request->id);
            if(!$Users)
            {
                return $this->returnError('E001','Id not Found');
            }
            $delete=$Users->delete();
            if(!$delete)
                return $this->returnsuccessMessage('Data Deleted Successfuly');
        }catch(Exception $ex)
        {
            return $this->returnError('E001','Something Went Error Please Try Again');
        }
    }
}
