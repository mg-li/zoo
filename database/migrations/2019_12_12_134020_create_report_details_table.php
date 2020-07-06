<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('report_id')->comment('作業日ID');
            $table->unsignedInteger('customer_id')->nullable()->comment('得意先ID');
            $table->unsignedInteger('item_id')->nullable()->comment('商品ID');
            $table->unsignedInteger('category_id')->nullable()->comment('機械ID');
            $table->unsignedInteger('facility_id')->nullable()->comment('設備ID');
            $table->string('instruction_num')->nullable()->comment('製造指示数');
            $table->unsignedInteger('finish_num')->nullable()->comment('製造完了数');
            $table->unsignedDecimal('setup_time', 8, 2)->nullable()->comment('段取り時間');
            $table->unsignedDecimal('facility_time', 8, 2)->nullable()->comment('設備稼動時間');
            $table->unsignedDecimal('work_time', 8, 2)->nullable()->comment('作業時間');
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
        Schema::dropIfExists('report_details');
    }
}
