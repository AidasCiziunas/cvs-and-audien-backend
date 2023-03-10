<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestConfguration extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function attemptedTest(){
        return $this->hasMany(HearingTest::class,'test_id','id');
    }

    public function testResult(){
      return $this->belongsTo(HearingTestResult::class,'id','test_id');

    }
}
