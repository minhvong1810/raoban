<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Helpers\AppHelpers;

class TestController extends Controller
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

    public function testStore()
    {
        $user = new User();

        $user->phone_number = '093333221100';
        $user->name = 'abc';
        $res = $user->save();

        if($res){
            return "0 | Ban da dang ky tai khoan thanh cong";
        }
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
}
