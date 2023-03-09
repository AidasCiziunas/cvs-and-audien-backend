<?php

namespace App\Http\Controllers;

use App\Models\HearingTest;
use App\Models\HearingTestResult;
use App\Models\TestConfguration;
use App\Models\User;
use Illuminate\Http\Request;

class HearingTestResultController extends Controller
{

    public function store(Request $request)
    {
        $user = User::where('ip_address', $request->ip())->first();
        $test = TestConfguration::where('status', 'inprogress')
            ->where('user_id', $user->id)->first();
        $test->status = 'completed';
        $test->save();
        $hearingTest = HearingTest::where('test_id', $test->id)->sum('score');
        $score = ($hearingTest / 25) * 10;
        $testResult = new HearingTestResult();
        $testResult->test_id = $test->id;
        $testResult->score = $score;
        $testResult->save();
        return response()->json(['message' => 'Hearing test completed', 'data' => $testResult]);
    }
}
