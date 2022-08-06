<?php
namespace App\Http\Traits;

trait GeneralTrait
{
    public function getcurrentlang()
    {
       return app()->getLocale();
    }
    public function returnError($errNum="E001" , $msg)
    {
        return response()->json
        ([
            'status' => false,
            'errNum' => $errNum,
            'msg'    => $msg,
        ]);
    }
    public function returnsuccessMessage($msg="",$errNum="SOOO")
    {
        return response()->json
        ([
            'status' => True,
            'errNum' => $errNum,
            'msg'    => $msg,
        ]);
    }
    public function returnData($key,$value,$msg="")
    {
        return response()->json
        ([
            'status' =>'true',
            'errNum' =>"SOOO",
            'msg'    =>$msg,
            $key     =>$value
        ]);
    }
    public function returnValidationError($code = "E001", $validator)
    {
        return $this->returnError($code, $validator->errors()->first());
    }


    public function returnCodeAccordingToInput($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());
        $code = $this->getErrorCode($inputs[0]);
        return $code;
    }

    public function getErrorCode($input)
    {
        if ($input == "name")
            return 'E001';

        else if ($input == "password")
            return 'E002';

        else if ($input == "phone")
            return 'E003';

        else if ($input == "gender")
            return 'E004';

        else if ($input == "collage")
            return 'E005';

        else if ($input == "unveristy")
            return 'E006';

        else if ($input == "email")
            return 'E007';

        else if ($input == "nationality")
            return 'E008';

        else if ($input == "squad")
            return 'E009';

        else if ($input == "title")
            return 'E010';

        else if ($input == "sub-title")
            return 'E011';

        else if ($input == "location")
            return 'E012';

        else if ($input == "image")
            return 'E013';

        else
            return "";
    }
}
