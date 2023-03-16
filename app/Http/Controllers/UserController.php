<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\TestConfguration;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(UserRequest $request){
        $id= $request->id;
       $test = TestConfguration::where('id',$id)->first();

        $ip = $request->ip();
        $user = User::where('id',$test->user_id)->first();
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email     = $request->email;
        $user->contact_number = $request->contact_number;
        $user->save();
        return response()->json(['message'=>'User Data Save succesfully','data'=>$user]);
    }
}
