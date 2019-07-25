<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actuals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('title', 50);
            $table->text('description')->nullable();
            $table->datetime('actual_date_start');
            $table->datetime('actual_date_end');
            // $table->integer('duration_hours')->default(0);
            // $table->integer('duration_minutes')->default(0);
            $table->string('code', 10)->nullable();
            $table->string('color', 10)->nullable();
            $table->string('site', 50)->nullable();
            $table->string('pm_sales', 100)->nullable();
            $table->float('overtime')->default(0); // it has to be calculated when saving actuals
            $table->unsignedBigInteger('actual_category_id')->nullable();
            // $table->foreign('actual_category_id')->references('id')->on('actual_categories')->onDelete('set null');
            $table->unsignedBigInteger('project_id')->nullable(); // to fill this value you need to get project_id from plan first. it is imposible to have belongsToThrough though...
            // $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');
            $table->unsignedBigInteger('plan_id')->nullable();
            // $table->foreign('plan_id')->references('id')->on('plans')->onDelete('set null');
            $table->unsignedBigInteger('user_id')->nullable(); // bisa tidak butuh, tergantung kebutuhan aja
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('actuals');
    }
}
