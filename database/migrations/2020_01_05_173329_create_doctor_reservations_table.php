<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_reservations', function (Blueprint $table) {
            $table->uuid('id'); 
            $table->uuid('reservation_id');

            $table->uuid('doctor_id'); 

            $table->primary('id');
            $table->foreign('reservation_id')->references('id')->on('reservations')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('doctor_id')->references('id')->on('doctor_hospitalizations')
                  ->onDelete('cascade')->onUpdate('cascade');
            $table->softDeletes();
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
        Schema::disableForeignKeyConstraints();
        Schema::table('doctor_reservations', function (Blueprint $table)
        {
            $table->dropPrimary('id');
            $table->dropForeign(['reservation_id']);
            $table->dropForeign(['doctor_id']);
        });
        Schema::dropIfExists('doctor_reservations');
        Schema::enableForeignKeyConstraints();
    }
}
