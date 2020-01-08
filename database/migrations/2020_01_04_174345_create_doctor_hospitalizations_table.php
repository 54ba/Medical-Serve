<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorHospitalizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_hospitalizations', function (Blueprint $table) {
            $table->uuid('id'); 
            $table->uuid('hospitalization_id');

            $table->primary('id');
            
            $table->foreign('hospitalization_id')->references('id')->on('hospitalizations')
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
        Schema::table('doctor_hospitalizations', function (Blueprint $table)
        {
            $table->dropPrimary('id');
            $table->dropForeign(['hospitalization_id']);
        });
        Schema::dropIfExists('doctor_hospitalizations');
        Schema::enableForeignKeyConstraints();
    }
}
