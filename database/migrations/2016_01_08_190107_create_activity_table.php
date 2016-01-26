<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('Activity', function(Blueprint $table){
        
            $table->integer('activityID', true);
            $table->integer('sectionID', false);
            $table->string('activityType', 20);
            $table->date('assignDate');
            $table->date('dueDate');
            $table->decimal('estTime', 2, 1);
            $table->decimal('proffEstimate', 2, 1);
            $table->decimal('cdAlocatedTime', 2, 1);
            $table->string('comments', 1000);

        });
        
        Schema::table('Activity', function ($table) {
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
        Schema::drop('Activity');
    }
}
