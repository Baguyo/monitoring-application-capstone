<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring_records', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->time('first_in')->nullable();
            $table->time('first_out')->nullable();
            $table->time('second_in')->nullable();
            $table->time('second_out')->nullable();
            $table->time('third_in')->nullable();
            $table->time('third_out')->nullable();
            $table->time('fourth_in')->nullable();
            $table->time('fourth_out')->nullable();
            $table->time('fifth_in')->nullable();
            $table->time('fifth_out')->nullable();
            
            

            

            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitoring_records');
    }
};
