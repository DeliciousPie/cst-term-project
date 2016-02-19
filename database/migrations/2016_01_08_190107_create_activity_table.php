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
            $table->string('sectionID', 20);
            $table->string('activityType', 20);
            $table->date('assignDate');
            $table->date('dueDate');
            $table->decimal('estTime', 4, 1);
            $table->decimal('proffEstimate', 4, 1);
            $table->decimal('cdAlocatedTime', 4, 1);
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
