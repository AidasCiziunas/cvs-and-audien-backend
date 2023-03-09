<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestConfgurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_confgurations', function (Blueprint $table) {
            $table->id();
            $table->string('birth_year')->nullable();
            $table->string("ear")->nullable();
            $table->string("sound_frequency")->nullable();
            $table->enum('status',['inprogress','completed'])->default('inprogress');
            $table->integer("user_id")->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_confgurations');
    }
}
