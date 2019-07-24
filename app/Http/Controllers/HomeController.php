<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Site;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        //Get sites
        $sites = Site::where('user_id',auth()->user()->id)->orderBy('name')->get();

        //Read sites to get status
        foreach($sites as $site){

            if($socket =@ fsockopen($site->url, $site->port, $errno, $errstr, 30)) {

                $site->status = 'online';
                
            } else {

                $site->status = 'offline';

            }
            
        }
        //End read sites to get status

        return view('home',['sites'=>$sites]);
    }
}
