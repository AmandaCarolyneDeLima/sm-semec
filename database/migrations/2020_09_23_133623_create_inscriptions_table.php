<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reason');
            $table->timestamps();

            $table->unsignedBigInteger('servant_id')->index();
            $table->foreign('servant_id')
                    ->references('id')
                    ->on('servants');

            $table->unsignedBigInteger('contract_id')->index();
            $table->foreign('contract_id')
                    ->references('id')
                    ->on('contracts');

            $table->unsignedBigInteger('current_unit_id')->index();
            $table->foreign('current_unit_id')
                  ->references('id')
                  ->on('units');

            $table->unsignedBigInteger('interested_unit_id')->index();
            $table->foreign('interested_unit_id')
                    ->references('id')
                    ->on('units');

            $table->unsignedBigInteger('edict_id')->index();
            $table->foreign('edict_id')
                    ->references('id')
                    ->on('edicts');

            $table->unsignedBigInteger('removal_type_id')->index();
            $table->foreign('removal_type_id')
                    ->references('id')
                    ->on('removal_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inscriptions');
    }
}
