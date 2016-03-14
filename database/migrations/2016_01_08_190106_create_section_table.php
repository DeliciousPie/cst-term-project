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
        
            $table->string('sectionID', 20);
            $table->string('sectionType',20); 
            $table->string('courseID', 25);
            $table->date('date');
            $table->timestamps();
            $table->primary(array('sectionID', 'courseID'));

        });
        
        Schema::table('Section', function ($table) {
            $table->foreign('courseID')->references('courseID')->on('Course')->onDelete('cascade');
//            $table->foreign('sectionType')->references('sectionID')->on('SectionType')->onDelete('cascade');
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
