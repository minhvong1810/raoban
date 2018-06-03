<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClassifiedAds;

class ClassifiedAdsController extends Controller
{
    public function index()
    {

    }

    public function getAll()
    {
        $title = 'Home';
        $classifiedAds = ClassifiedAds::all();

        $data = [
            'title' => $title,
            'classifiedAds' => $classifiedAds
        ];

        return view('home', $data);
    }
}
