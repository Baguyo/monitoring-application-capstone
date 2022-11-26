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
        Schema::table('sections', function(Blueprint $table){
            $table->unsignedBigInteger('strands_id')->after('year_level_id');
            $table->foreign('strands_id')->references('id')->on('strands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sections', function(Blueprint $table){
            $table->dropForeign(['strands_id']);
            $table->dropColumn('strands_id');
        });
    }
};
