<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends BaseController
{
    
    /**
     * HomePageController constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weather = $this->getWeather();

        return view('welcome', compact(self::viewShareVarsHome));
    }
}
