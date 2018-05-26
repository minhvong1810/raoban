<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\AppHelpers;

class UserController extends Controller
{
    public function index(Request $request)
    {
        //echo $request->ip();
        //get value and aupdate db here
        $urlQueryString = $request->query();

        return "0 | Ban da dang ky tai khoan thanh cong";
        //return response()->json($urlQueryString, 200);
    }

    public function testHelper()
    {
        $helper = new AppHelpers();
        $response = $helper->getGuzzleRequest('http://raoban.local/api/sms?Command_Code=CSKH&User_ID=84902866568&Service_ID=8077&Reques%20t_ID=89078288&Message=CSKH+ABC');

        return $response;
    }
}
