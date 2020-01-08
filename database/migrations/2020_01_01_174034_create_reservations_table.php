<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->bigInteger('mobile_number');
            $table->bigInteger('telephone');
            $table->integer('age');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary('id');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('reservations', function (Blueprint $table)
        {
            $table->dropPrimary('id');
            $table->dropForeign(['user_id']);

        });
        Schema::dropIfExists('reservations');
        Schema::enableForeignKeyConstraints();
    }
}
