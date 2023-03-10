<?php

namespace App\Http\Controllers;

use App\Models\HearingTest;
use App\Models\HearingTestResult;
use App\Models\TestConfguration;
use App\Models\User;
use Illuminate\Http\Request;

class HearingTestResultController extends Controller
{
   public $user;
   
   public function __construct(Request $request)
   {
     $this->user = User::where('ip_address', $request->ip())->where('user_agent',$request->userAgent())->first();
   }
    public function index(){
    
      $testHistory = TestConfguration::with(['attemptedTest','testResult'])->where('user_id',$this->user->id)->latest()->first();
      $testHistory->user= $this->user;
      return response()->json(['message'=>'User added data','data'=>$testHistory]);
    }

    public function store(Request $request)
    {
        $user = User::where('ip_address', $request->ip())->where('user_agent',$request->user_agent)->latest()->first();
        $test = TestConfguration::where('status', 'inprogress')
            ->where('user_id', $this->user->id)->latest()->first();
         $test->status = 'completed';
        $test->save();
        $hearingTest = HearingTest::where('test_id', $test->id)->sum('score');
        $score = ($hearingTest / 40) * 10;
        $testResult = new HearingTestResult();
        $testResult->test_id = $test->id;
        $testResult->score = $score;
        $testResult->save();
        return response()->json(['message' => 'Hearing test completed', 'data' => $testResult]);
    }
}
