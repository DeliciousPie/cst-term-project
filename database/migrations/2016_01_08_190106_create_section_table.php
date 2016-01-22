<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Section', function(Blueprint $table){
        
            $table->integer('sectionID', true);
            $table->string('courseID', 15);
            $table->date('date');
            

        });
        
        Schema::table('Section', function ($table) {
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
        Schema::drop('Section');
    }
}
