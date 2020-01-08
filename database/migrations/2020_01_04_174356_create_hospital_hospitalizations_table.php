<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalHospitalizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital_hospitalizations', function (Blueprint $table) {
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
        Schema::table('hospital_hospitalizations', function (Blueprint $table)
        {
            $table->dropPrimary('id');
            $table->dropForeign(['hospitalization_id']);
        });
        Schema::dropIfExists('hospital_hospitalizations');
        Schema::enableForeignKeyConstraints();
    }
}
