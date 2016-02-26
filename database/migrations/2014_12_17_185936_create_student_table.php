<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
              
        Schema::create('Student', function(Blueprint $table){
            
            $table->increments('id');
            $table->string('userID', 25)->unique(); //ASK IF WE NEED TO RECORD THIS TWICE.
            $table->integer('age', false)->nullable();
            $table->string('areaOfStudy', 20);
            $table->string('fName', 15)->nullable();
            $table->string('lName', 25)->nullable();
            $table->string('educationalInstitution', 30);
            $table->string('email', 50);
            $table->nullableTimestamps();
        });
        
        Schema::table('Student', function ($table) {
            $table->foreign('id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            $table->foreign('userID')
                    ->references('userID')
                    ->on('users')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Student');
    }
}
