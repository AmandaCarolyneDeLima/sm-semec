<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDependentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dependents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('birthed_at');
            $table->string('degree');
            $table->char('study');
            $table->string('works');
            $table->unsignedBigInteger('servant_id')->index();
            $table->foreign('servant_id')
                    ->references('id')
                    ->on('servants')
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
        Schema::dropIfExists('dependents');
    }
}
