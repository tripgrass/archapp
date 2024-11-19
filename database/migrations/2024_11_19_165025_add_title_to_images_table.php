<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->tinytext('title')->nullable();
            $table->text('alttext')->nullable();
            $table->smallInteger('year')->nullable();
            $table->bigInteger('person_id')->unsigned()->index()->nullable(); 
        });

        Schema::table('images', function($table) {
           $table->foreign('person_id')->references('id')->on('persons');
       });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('alttext');
            $table->dropColumn('year');
            $table->dropColumn('persons_id');
        });
    }
};
