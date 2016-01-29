<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('StudentActivity', function(Blueprint $table){
            
            $table->string('userID', 25);
            $table->integer('activityID', false);
            $table->double('timeSpent', 4, 1);
            $table->integer('stressLevel', false);
            $table->string('comments', 300);
            $table->double('timeEstimated', 4, 1);
            $table->primary(['userID', 'activityID']);
        });
        
        Schema::table('StudentActivity', function ($table) {
            $table->foreign('userID')->references('userID')->on('users')->onDelete('cascade');
            $table->foreign('activityID')->references('activityID')->on('Activity')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('StudentActivity');
    }
}
