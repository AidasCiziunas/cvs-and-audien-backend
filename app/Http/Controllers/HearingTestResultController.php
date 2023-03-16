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
    public function index(Request $request){
      $id = $request->id;
      $testHistory = TestConfguration::with(['attemptedTest','testResult'])->where('id',$id)->first();
      $testHistory->user= User::where('id',$testHistory->user_id)->first();
      return response()->json(['message'=>'User added data','data'=>$testHistory]);
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $test = TestConfguration::where('id',$id)->first();
        $user = User::where('id', $test->user_id)->first();
        
         $test->status = 'completed';
        $test->save();
        $hearingTest = HearingTest::where('test_id', $id)->sum('score');
        $score = ($hearingTest / 35) * 10;
        $testResult = new HearingTestResult();
        $testResult->test_id = $id;
        $testResult->score = $score;
        $testResult->save();
        return response()->json(['message' => 'Hearing test completed', 'data' => $testResult]);
    }
}
