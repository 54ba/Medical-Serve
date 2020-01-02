<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelephonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telephones', function (Blueprint $table) {
            $table->uuid('id'); 
            $table->bigInteger('telephone');
            $table->uuid('hospitalization_id');
            $table->timestamps();

            $table->primary('id');

            $table->foreign('hospitalization_id')->references('id')->on('hospitalizations')
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
        Schema::table('telephones', function (Blueprint $table)
        {
            $table->dropPrimary('id');
            $table->dropForeign(['hospitalization_id']);
        });
        Schema::dropIfExists('telephones');
        Schema::enableForeignKeyConstraints();
    }
}
