<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\AppHelpers;
use App\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        //echo $request->ip();
        //get value and aupdate db here
        //return \Config::get('constants.SPEED_SMS_API_ACCESS_TOKEN');
        return $request->all();
        $urlQueryString = $request->query();

        return "0 | Ban da dang ky tai khoan thanh cong";
        //return response()->json($urlQueryString, 200);
    }

    public function store(Request $request)
    {
        $urlQueryString = $request->query();

        if($urlQueryString['Command_Code'] === 'TTV'){

            $phoneNumber = str_replace('84', '0', $urlQueryString['User_ID']);
            $message = substr($urlQueryString['Message'], 3);

            $user = User::where('phone_number', $phoneNumber)->first();

            if($user){
                //update database with new message
                $user->name = $message;
                $res = $user->save();

                if($res){
                    return "0 | Ban da cap nhat tai khoan thanh cong";
                }
            }else{
                //create new record
                $user = new User();

                $user->phone_number = $phoneNumber;
                $user->name = $message;
                $res = $user->save();

                if($res){
                    return "0 | Ban da dang ky tai khoan thanh cong";
                }
            }
        }

        return "3 | Sai Command Code";
    }

    public function testHelper()
    {
        $helper = new AppHelpers();
        $response = $helper->getGuzzleRequest('http://raoban.local/api/sms?Command_Code=CSKH&User_ID=84902866568&Service_ID=8077&Reques%20t_ID=89078288&Message=CSKH+ABC');

        return $response;
    }

    public function testPostHelper()
    {
        $helper = new AppHelpers();
        $url = 'http://raoban.local/api/sms?Command_Code=CSKH&User_ID=84902866568&Service_ID=8077&Reques%20t_ID=89078288&Message=CSKH+ABC';
        $body = ['name'=>'James'];
        $response = $helper->postGuzzleRequest($url, $body);

        return $response;
    }


    public function sendSMS()
    {
        $helper = new AppHelpers();
        $url = 'https://api.speedsms.vn/index.php/sms/send';
        $body = [
            'to' => ['0933962428'],
            'content' => 'Chào bạn, chúc ngày mới tốt lành',
            'sms_type' => 2,
            'sender' => ''
        ];

        $response = $helper->postCurlGuzzleRequest($url, $body);

        return $response;
    }

    public function getSMSResponse(Request $request)
    {
        return $request->all();
    }
}
