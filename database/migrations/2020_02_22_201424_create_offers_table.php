<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('advertisement_id');
            $table->unsignedBigInteger('published_worker_id');

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('advertisement_id')->references('id')->on('advertisements');
            $table->foreign('published_worker_id')->references('id')->on('published_workers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
