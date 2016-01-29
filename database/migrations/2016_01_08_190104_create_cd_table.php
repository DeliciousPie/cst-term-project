<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('CD', function(Blueprint $table){
            
            $table->increments('id');
            $table->string('userID', 25)->unique();
            $table->string('fName', 15);
            $table->string('lName', 25);
            $table->string('educationalInstitution', 30);
            $table->string('areaOfStudy', 20);
            $table->string('email', 50);
            $table->timestamps();
            
        });
        
        Schema::table('CD', function ($table) {
            
            
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
        Schema::drop('CD');
    }
}
