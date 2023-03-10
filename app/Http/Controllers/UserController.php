<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(UserRequest $request){

        $ip = $request->ip();
        $user = User::where('ip_address',$ip)->first();
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email     = $request->email;
        $user->contact_number = $request->contact_number;
        $user->save();
        return response()->json(['message'=>'User Data Save succesfully','data'=>$user]);
    }
}
