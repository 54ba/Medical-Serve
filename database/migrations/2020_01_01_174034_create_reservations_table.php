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
            $table->softDeletes();
            $table->timestamps();

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
        });
        Schema::dropIfExists('reservations');
        Schema::enableForeignKeyConstraints();
    }
}
