<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_employee', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('report_id')->comment('作業日ID');
            $table->unsignedInteger('employee_id')->comment('従業員ID');
            $table->timestamps();
            $table->foreign('report_id')
                ->references('id')
                ->on('reports')
                ->onDelete('cascade');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_employee');
    }
}
