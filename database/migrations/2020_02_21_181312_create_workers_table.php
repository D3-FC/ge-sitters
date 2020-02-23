<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');

            $table->tinyInteger('min_child_age')->nullable()->unsigned();
            $table->tinyInteger('max_child_age')->nullable()->unsigned();

            $table->text('description')->nullable();
            $table->text('animal_relationship')->nullable();

            $table->decimal('meeting_price', 8, 2)->nullable()->unsigned();
            $table->decimal('coords_x', 10, 6)->nullable();
            $table->decimal('coords_y', 10, 6)->nullable();


            $table->boolean('has_card_payment')->nullable();
            $table->boolean('sits_special_children')->nullable();
            $table->boolean('has_training')->nullable();
            $table->boolean('can_overwork')->nullable();


            $table->date('birthday')->nullable();
            $table->timestamp('mobile_number_confirmed_at')->nullable();
            $table->timestamp('passport_confirmed')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workers');
    }
}
