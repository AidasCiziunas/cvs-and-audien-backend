<?php

namespace App\Http\Controllers;

use App\Http\Requests\EarRequest;
use App\Models\TestConfguration;
use App\Models\User;
use Illuminate\Http\Request;

class TestConfgurationController extends Controller
{

    public function storeSoundFrequency($user, Request $request)
    {

        $soudFrequency = TestConfguration::where('user_id', $user)->first();
        $soudFrequency->sound_frequency = $request->frequency;
        $soudFrequency->save();
        return response()->json(['user' => $this->getUser($user), 'test-configuration' => $this->getTestConfiguration($user)]);
    }

    public function getUser($id)
    {
        return User::select(['id','first_name', 'last_name', 'ip_address', 'email', 'contact_number'])->where('id', $id)->first();
    }


    public function store($user, EarRequest $request)
    {

       
        $ear = TestConfguration::where('user_id',$user)->first();
        $ear->ear = $request->ear;
        $ear->user_id = $user;
        $ear->save();
        return response()->json(
            [
                'user' => $this->getUser($user),
                'test-configuration' => $this->getTestConfiguration($user)
            ]
        );
    }


    public function getTestConfiguration($user)
    {
        return  TestConfguration::where('user_id', $user)->first();
    }


    public function storeBirthyear(Request $request)
    {
        $user = new User();
        $user->ip_address = $request->ip();
        $user->save();
        $ear = new TestConfguration();
        $ear->birth_year = $request->birth_year;
        $ear->user_id = $user->id;
        $ear->save();
       

        return response()->json(
            [
                'user' => $this->getUser($user->id),
                'test-configuration' => $this->getTestConfiguration($user->id)
            ]
        );
    }
}
