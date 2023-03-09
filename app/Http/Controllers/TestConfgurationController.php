<?php

namespace App\Http\Controllers;

use App\Http\Requests\EarRequest;
use App\Models\TestConfguration;
use App\Models\User;
use Illuminate\Http\Request;

class TestConfgurationController extends Controller
{

    public function storeSoundFrequency(Request $request)
    {
        $userId=$this->getUser($request->ip())->id;
        $soudFrequency = TestConfguration::where('user_id', $userId)->first();
        $soudFrequency->sound_frequency = $request->frequency;
        $soudFrequency->save();
        return response()->json(['user' => $this->getUser($request->ip()), 'test-configuration' => $this->getTestConfiguration($userId)]);
    }

    public function getUser($ip)
    {
        return User::select(['id', 'first_name', 'last_name', 'ip_address', 'email', 'contact_number'])->where('ip_address', $ip)->first();
    }


    public function store(EarRequest $request)
    {

        $userId=$this->getUser($request->ip())->id;
        $ear = TestConfguration::where('user_id', $userId)->first();
        $ear->ear = $request->ear;
        $ear->user_id = $userId;
        $ear->save();
        return response()->json(
            [
                'user' => $this->getUser($request->ip()),
                'test-configuration' => $this->getTestConfiguration($userId)
            ]
        );
    }


    public function getTestConfiguration($user)
    {
        return  TestConfguration::where('user_id', $user)->first();
    }


    public function storeBirthyear(Request $request)
    {
        $userId=null;
        if (User::where('ip_address', $request->ip())->count() == 0) {
            $user = new User();
            $user->ip_address = $request->ip();
            $user->save();
            $userId = $user->id;
        }else{
            $user = User::where('ip_address',$request->ip())->first();
            $userId =  $user->id;
        }
        $ear = new TestConfguration();
        $ear->birth_year = $request->birth_year;
        $ear->user_id = $userId;
        $ear->status ='inprogress';
        $ear->save();


        return response()->json(
            [
                'user' => $this->getUser($user->id),
                'test-configuration' => $this->getTestConfiguration($user->id)
            ]
        );
    }
}
