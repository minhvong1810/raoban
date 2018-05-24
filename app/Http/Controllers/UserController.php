<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
