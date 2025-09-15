<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
      return view('home', ['pageTitle' => 'Home']);
    }
}
