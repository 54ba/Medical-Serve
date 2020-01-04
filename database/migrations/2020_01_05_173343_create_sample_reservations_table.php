<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sample_reservations', function (Blueprint $table) {
            $table->uuid('id'); 
            $table->uuid('reservation_id');

            $table->uuid('lab_id'); 
            $table->timestamps();

            $table->primary('id');

            $table->foreign('reservation_id')->references('id')->on('reservations')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('lab_id')->references('id')->on('lab_hospitalizations')
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
        Schema::table('sample_reservations', function (Blueprint $table)
        {
            $table->dropPrimary('id');
            $table->dropForeign(['reservation_id']);
            $table->dropForeign(['lab_id']);
        });
        Schema::dropIfExists('sample_reservations');
        Schema::enableForeignKeyConstraints();
    }
}
