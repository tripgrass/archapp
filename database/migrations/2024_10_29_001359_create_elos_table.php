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
        Schema::create('elos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('primary_artifact_id');
            $table->foreign('primary_artifact_id')->references('id')
                ->on('artifacts')->onDelete('cascade');

            $table->unsignedBigInteger('secondary_artifact_id');
            $table->foreign('secondary_artifact_id')->references('id')
                ->on('artifacts')->onDelete('cascade');

            $table->integer('rating_signatory');
            $table->integer('rating_demos');

            $table->text('category');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elos');
    }
};
