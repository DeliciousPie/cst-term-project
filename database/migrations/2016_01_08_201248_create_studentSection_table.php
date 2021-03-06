<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('StudentSection', function(Blueprint $table){
        
            $table->string('userID', 25);
            $table->string('sectionID', 20);
            $table->timestamps();
            $table->primary(['userID', 'sectionID']);

        });
        
        Schema::table('StudentSection', function ($table) {
            $table->foreign('userID')->references('userID')->on('Student')->onDelete('cascade');
            $table->foreign('sectionID')->references('sectionID')->on('Section')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('StudentSection');
    }
}
