<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('title', 50);
            $table->text('description')->nullable();
            $table->date('start');
            $table->date('end');
            $table->string('status', 20);
            $table->string('code', 10)->nullable();
            $table->string('color', 10)->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            // $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');
            $table->unsignedBigInteger('plan_category_id')->nullable();
            // $table->foreign('plan_category_id')->references('id')->on('plan_categories')->onDelete('set null');
            $table->unsignedBigInteger('plan_sub_category_id')->nullable();
            // $table->foreign('plan_sub_category_id')->references('id')->on('plan_sub_categories')->onDelete('set null');
            $table->unsignedBigInteger('user_id')->nullable();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->boolean('important')->default(0);
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
        Schema::dropIfExists('plans');
    }
}
