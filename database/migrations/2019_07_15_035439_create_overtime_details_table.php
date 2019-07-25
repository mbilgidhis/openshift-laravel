<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOvertimeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtime_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_code', 150)->nullable();
            $table->string('activity', 150);
            $table->datetime('start');
            $table->datetime('end');
            $table->string('type', 20)->nullable(); // workday or offday
            $table->string('pm_sales', 150)->nullable();
            $table->boolean('claimed')->default(0);
            $table->unsignedBigInteger('overtime_id')->nullable();
            $table->foreign('overtime_id')->references('id')->on('overtimes')->onDelete('set null');
            $table->unsignedBigInteger('actual_id')->nullable();
            $table->foreign('actual_id')->references('id')->on('actuals')->onDelete('set null');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('created_by')->nullable();
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('updated_by')->nullable();
            // $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('deleted_by')->nullable();
            // $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('overtime_details');
    }
}
