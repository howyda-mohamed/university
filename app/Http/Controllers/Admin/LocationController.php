<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Models\Location;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    use GeneralTrait;
    public function insert(Request $request)
    {
        try{
            $rules=[
                'title' => 'required|max:255|unique:locations',
                'sub_title' => ['required','min:4','max:255' ],
                'location' => ['required', 'string'],
                'phone'    =>['required'],
                'email' => ['required', 'email', 'unique:locations,email'],
                'image'    =>['required','max:255'],
            ];
            $validator=Validator::make($request->all(),$rules);

            if($validator->fails())
            {
                $code=$this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
            }
            else
            {
                $image=$request->file('image')->store('images/locations');
                $locations=Location::create([
                    'title' => $request->title,
                    'sub_title' => $request->sub_title,
                    'location' => $request->location,
                    'email'=> $request->email ,
                    'phone' => $request->phone,
                    'image' => $request->file('image')->hashName(),
                ]);
                if(!$locations)
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
            $locations=Location::all();
            if($locations)
            {
                return $this->returnData('locations',$locations);
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
            $locations=Location::find($request->id);
            if(!$locations)
            {
                return $this->returnError('E001','Id not Found');
            }
            $delete=$locations->delete();
            if($delete)
                return $this->returnsuccessMessage('Data Deleted Successfuly');
        }catch(Exception $ex)
        {
            return $this->returnError('E001','Something Went Error Please Try Again');
        }
    }
}
