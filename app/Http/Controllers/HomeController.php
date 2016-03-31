<?php

namespace App\Http\Controllers;

use App\Common;
use App\User;
use Illuminate\Routing\Controller as BaseController;

class HomeController extends BaseController
{
    /**
     * Display the home page.
     *
     * @return Response
     */
    public function index()
    {
        return view('home.index');
    }



    /**
     * Responds to requests to GET /home/User
     */
    public function getUser(){
        return response()->json(User::all());
    }


    /**
     * Responds to requests to GET /home/common
     */
    public function getCommon(){
        $commons = [];
        $t= Common::all();
        /** @var Common $common */
        foreach($t as $common){
            $commons[$common->name] = json_decode($common->value);
        }
        return response()->json($commons);
    }
}
