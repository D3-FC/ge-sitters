<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishedWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('published_workers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('worker_id');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('worker_id')->references('id')->on('workers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('published_workers');
    }
}
