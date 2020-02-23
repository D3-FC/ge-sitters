<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('client_id');

            $table->tinyInteger('children_count')->unsigned()->nullable();

            $table->enum('payment_method', ['cash', 'card']);

            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->time('from')->nullable();
            $table->time('to')->nullable();

            $table->decimal('price', 8, 2)->nullable()->unsigned();
            $table->decimal('meeting_price', 8, 2)->nullable()->unsigned();
            $table->decimal('coords_x', 10, 6)->nullable();
            $table->decimal('coords_y', 10, 6)->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisements');
    }
}
