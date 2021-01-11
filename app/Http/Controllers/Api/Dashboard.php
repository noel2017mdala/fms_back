<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class Dashboard extends Controller
{
    public function index(Request $request){
        
        if(auth()->user()){
            return $request->user();
        }
    }
}
