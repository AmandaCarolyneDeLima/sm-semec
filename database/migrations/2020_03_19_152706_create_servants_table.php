    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('birthed_at');
            $table->string('natural_from');
            $table->string('marital_status');
            $table->string('mother_name');
            $table->string('father_name');
            $table->string('CPF');
            $table->string('RG');
            $table->string('PIS');
            $table->string('CTPS');
            $table->string('title');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('password');
            $table->string('image')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('servants');
    }
}
