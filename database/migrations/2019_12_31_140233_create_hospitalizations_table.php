<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateHospitalizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitalizations', function (Blueprint $table) {
            $table->uuid('id'); 
            $table->string('name');
            $table->string('email')->unique();
            $table->text('password');
            $table->integer('type');
            $table->text('slug')->index('slug');
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
        Schema::table('hospitalizations', function (Blueprint $table)
        {
            $table->dropPrimary('id');
        });
        Schema::dropIfExists('hospitalizations');
     
    }

}