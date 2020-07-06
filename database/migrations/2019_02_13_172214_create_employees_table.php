<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedinteger('user_id')->nullable()->comment('ユーザー');
            $table->string('first_name')->nullable()->comment('名');
            $table->string('last_name')->nullable()->comment('姓');
            $table->string('first_phonetic_name')->nullable()->comment('かな名');
            $table->string('last_phonetic_name')->nullable()->comment('かな姓');
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
        Schema::dropIfExists('employees');
    }
}
