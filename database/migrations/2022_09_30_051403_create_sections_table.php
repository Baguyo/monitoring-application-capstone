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
    // public function up()
    // {
    //     Schema::create('sections', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name');

    //         $table->unsignedBigInteger('year_level_id')->index();            
    //         $table->foreign('year_level_id')->references('id')->on('year_levels')->onDelete('cascade');

    //         $table->timestamps();
    //         $table->softDeletes();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  *
    //  * @return void
    //  */
    // public function down()
    // {
    //     Schema::dropIfExists('sections');
    // }
};
