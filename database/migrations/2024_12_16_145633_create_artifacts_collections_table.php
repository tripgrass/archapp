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
        Schema::create('artifacts_collections', function (Blueprint $table) {
                $table->id();

                $table->foreignId('artifacts_id')->constrained();
                $table->foreignId('collections_id')->constrained();
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
        Schema::dropIfExists('artifacts_collections');
    }
};
