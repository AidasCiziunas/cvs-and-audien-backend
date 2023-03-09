<?php

namespace App\Http\Controllers;

use App\Models\Sound;
use Illuminate\Http\Request;

class SoundController extends Controller
{
    
    public function index()
    {
        $sound = Sound::all();

        return response()->json(['message'=>'Sound listing','data'=>$sound]);
    }

   
}
