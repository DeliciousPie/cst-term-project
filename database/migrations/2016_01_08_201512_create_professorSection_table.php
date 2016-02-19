<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessorSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('ProfSection', function(Blueprint $table){
        
            $table->string('userID', 25);
            $table->string('sectionID', 20);
            $table->timestamps();
            $table->primary(['userID', 'sectionID']);
            
        });
        
        Schema::table('ProfSection', function ($table) {
            $table->foreign('userID')->references('userID')->on('Professor')->onDelete('cascade');
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
        Schema::drop('ProfSection');
    }
}