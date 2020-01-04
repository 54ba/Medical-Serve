<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNurseReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nurse_reservations', function (Blueprint $table) {
            $table->uuid('id'); 
            $table->string('gender');
            
            $table->uuid('reservation_id');
            $table->uuid('hosptial_id'); 
            $table->timestamps();

            $table->primary('id');
            $table->foreign('reservation_id')->references('id')->on('reservations')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('hosptial_id')->references('id')->on('hospital_hospitalizations')
                  ->onDelete('cascade')->onUpdate('cascade');

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
        Schema::table('nurse_reservations', function (Blueprint $table)
        {
            $table->dropPrimary('id');
            $table->dropForeign(['reservation_id']);
            $table->dropForeign(['hosptial_id']);
        });
        Schema::dropIfExists('nurse_reservations');
        Schema::enableForeignKeyConstraints();
    }
}
