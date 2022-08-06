<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    use GeneralTrait;
    public function insert(Request $request)
    {
        try{
            $rules=[
                'title' => 'required|max:255',
                'description' => ['required'],
            ];
            $validator=Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                $code=$this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
            }
            else
            {
                $notification=Notification::create([
                    'title' => $request->title,
                    'description' => $request->description,
                ]);
                if(!$notification)
                {
                    return $this->returnError('E001','Something Went Error Please Try Again');
                }
                else
                {
                    return $this->returnsuccessMessage('Data Inserted Successfuly');
                }
            }
        }
        catch(Exception $ex)
        {
            return $this->returnError('E001','Something Went Error Please Try Again');
        }

    }
    public function show()
    {
        try{
            $notification=Notification::all();
            if($notification)
            {
                return $this->returnData('Notifications',$notification);
            }
            else
            {
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
            $notification=Notification::find($request->id);
            if(!$notification)
            {
                return $this->returnError('E001','Id not Found');
            }
            $delete=$notification->delete();
            if($delete)
                return $this->returnsuccessMessage('Data Deleted Successfuly');
        }catch(Exception $ex)
        {
            return $this->returnError('E001','Something Went Error Please Try Again');
        }
    }
}

