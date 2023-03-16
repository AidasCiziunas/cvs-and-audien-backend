<?php

namespace App\Http\Controllers;

use App\Http\Requests\EarRequest;
use App\Models\TestConfguration;
use App\Models\User;
use Illuminate\Http\Request;

class TestConfgurationController extends Controller
{
    public $ip, $userAgent;
    public function __construct(Request $request)
    {
        $this->ip = $request->ip();
        $this->userAgent = $request->userAgent();
    }

    public function storeSoundFrequency(Request $request)
    {
        $id= $request->id;
        $userId = $this->getUser($this->ip)->id;
        $soudFrequency = TestConfguration::where('id', $id)->first();
        $soudFrequency->sound_frequency = $request->frequency;
        $soudFrequency->save();
        return response()->json(['user' => $this->getUser($this->ip), 'test-configuration' => $this->getTestConfiguration($userId)]);
    }

    public function getUser($ip)
    {
        return User::select(
            [
                'id', 'first_name',
                'last_name', 'ip_address',
                'email', 'contact_number'
            ]
        )
            ->where('ip_address', $this->ip)->where('user_agent', $this->userAgent)
            ->first();
    }


    public function store(EarRequest $request)
    {
        $id= $request->id;

        $userId = $this->getUser($this->ip)->id;
        $ear = TestConfguration::where('id', $id)->first();
        $ear->ear = $request->ear;
        $ear->user_id = $userId;
        $ear->save();
        return response()->json(
            [
                'user' => $this->getUser($this->ip),
                'test-configuration' => $this->getTestConfiguration($userId)
            ]
        );
    }


    public function getTestConfiguration($user)
    {
        return  TestConfguration::where('user_id', $user)
            ->latest()
            ->first();
    }


    public function storeBirthyear(Request $request)
    {
        $id =  $request->id;
       
        $userId = null;
        if (User::where('ip_address', $this->ip)->where('user_agent', $this->userAgent)->count() == 0) {

            $user = new User();
            $user->ip_address = $this->ip;
            $user->user_agent = $this->userAgent;
            $user->save();
            $userId = $user->id;
        } else {
            $user = User::where('ip_address', $this->ip)->where('user_agent', $this->userAgent)->first();
            $userId =  $user->id;
        }
        if ($id==null) {
            $ear = new TestConfguration();
            $ear->birth_year = $request->birth_year;
            $ear->user_id = $userId;
            $ear->status = 'inprogress';
            $ear->save();
        } else {
            // dd('yes');
            // $ear =null;
            if(TestConfguration::find($id)){
                $ear = TestConfguration::where('id', $id)
               
                ->first();
            }else{
                $ear = new TestConfguration();
                $ear->id = $id;
            }
            // $ear = TestConfguration::where('id', $id)
               
            //     ->first();
            $ear->birth_year = $request->birth_year;
            $ear->user_id = $userId;
            $ear->status = 'inprogress';
            $ear->save();
        }


        return response()->json(
            [
                'user' => $this->getUser($user->id),
                'test-configuration' => $this->getTestConfiguration($user->id)
            ]
        );
    }
}
