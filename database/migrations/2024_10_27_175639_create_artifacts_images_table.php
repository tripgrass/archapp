<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('artifacts_images', function (Blueprint $table) {
                $table->id();
                $table->unsignedBiginteger('artifacts_id')->unsigned();
                $table->unsignedBiginteger('images_id')->unsigned();

                $table->foreign('artifacts_id')->references('id')
                     ->on('artifacts')->onDelete('cascade');
                $table->foreign('images_id')->references('id')
                    ->on('images')->onDelete('cascade');

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
        Schema::dropIfExists('artifacts_images');
    }
};
