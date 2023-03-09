<?php

namespace App\Http\Controllers;

use App\Models\HearingTest;
use App\Models\TestConfguration;
use App\Models\User;
use Illuminate\Http\Request;

class HearingTestController extends Controller
{
  
    
  
    public function store(Request $request)
    {
        $hearingTest = new HearingTest();
        $hearingTest->sound_id = $request->sound_id;
        $hearingTest->sound_volume = $request->sound_volume;
        $hearingTest->score = max(0, 5 * (1 - $request->sound_volume / 10));
        $user = User::where('ip_address', $request->ip())->first();
        $hearingTest->test_id = TestConfguration::where('user_id', $user->id)->where('status', 'inprogress')->first()->id;
        $hearingTest->save();

        return response()->json(['message' => 'Sound hearing paramenters added', 'data' => $hearingTest]);
    }
    
   
  
}
