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
        $userId = $this->getUser($this->ip)->id;
        $soudFrequency = TestConfguration::where('user_id', $userId)->first();
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

        $userId = $this->getUser($this->ip)->id;
        $ear = TestConfguration::where('user_id', $userId)->latest()->first();
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
        if (TestConfguration::where('user_id', $user->id)->where('status', 'inporgress')->count() == 0) {
            $ear = new TestConfguration();
            $ear->birth_year = $request->birth_year;
            $ear->user_id = $userId;
            $ear->status = 'inprogress';
            $ear->save();
        } else {
            $ear = TestConfguration::where('user_id', $userId)
                ->latest()
                ->first();
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
