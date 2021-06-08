<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('started_at');
            $table->date('ended_at');
            $table->string('number');
            $table->string('time');
            $table->unsignedBigInteger('contract_id')->index();
            $table->foreign('contract_id')
                    ->references('id')
                    ->on('contracts')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('acts');
    }
}
