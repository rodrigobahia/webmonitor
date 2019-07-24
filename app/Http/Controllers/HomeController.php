<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Site;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['status']]);
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
        $result = "===== WEB MONITOR STATUS =====\n";

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


    function status($email){

        //Search user
        $user = User::where('email',$email)->first();

        //Validate user
        if ($user == null){

            exit;

        } else {

            //Get sites
            $sites = Site::where('user_id',$user->id)->orderBy('name')->get();

            //Define message telegram
            $result = "===== WEB MONITOR STATUS =====\n";
            $offlineCount = 0;

            //Read sites to get status
            foreach($sites as $site){

                if($socket =@ fsockopen($site->url, $site->port, $errno, $errstr, 30)) {
                    
                    //Define return telegram
                    $result .= $site->name;
                    $result .= " = Online";
                    $result .= "\n";
                    
                } else {
                    
                    //Define return telegram
                    $result .= $site->name;
                    $result .= "Offline";
                    $result .= "\n";

                    //Increment offline
                    $offlineCount++;

                }
                
            }
            //End read sites to get status

            //Validate offline count
            if ($offlineCount > 0){

                //Define token telegram
                $token = env('TELEGRAM_TOKEN');

                //Define message telegram
                $data = [
                    'text' => $result,
                    'chat_id' => env('TELEGRAM_CHAT_ID')
                ];

                //Send message telegram
                file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data) );

            } else {

            }
            //End Validate offline count    

        }
        //End Validate user

    }
}
