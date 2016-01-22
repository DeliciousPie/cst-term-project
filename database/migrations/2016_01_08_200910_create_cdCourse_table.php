<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCdCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('CDCourse', function(Blueprint $table){
        
            $table->string('userID', 25);
            $table->string('courseID', 15);
            $table->primary(['userID', 'courseID']);

        });
        
        Schema::table('CDCourse', function ($table) {
            $table->foreign('userID')->references('userID')->on('CD')->onDelete('cascade');
            $table->foreign('courseID')->references('courseID')->on('Course')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('CDCourse');
    }
}
