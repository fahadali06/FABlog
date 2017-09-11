<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\BlogCategory;
use App\Blogs;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth', ['except' => ['index']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $blog = Blogs::with(['blogcategory' => function($blogs){
            //$blogs->select();
        }])
        ->with(['bloguser' => function($user){
            //$user->select();
        }])
        ->limit(2)
        ->get()
        ->toArray();
        //echo "<pre>";print_r($blog);exit;
        return view('home')->with(compact('blog'));
    }

    public function dashboard() {
        $title = 'Blog Dashboard';
        $totalblogcategory = BlogCategory::count();
        return view('welcome')->with(compact('title', 'totalblogcategory'));
    }

}
