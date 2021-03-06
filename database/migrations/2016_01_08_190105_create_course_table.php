<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Course', function(Blueprint $table){
        
            $table->string('courseID', 25)->primary();
            $table->string('areaOfStudy',250);
            $table->string('courseName', 50);
            $table->string('description', 150)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Course');
    }
}
