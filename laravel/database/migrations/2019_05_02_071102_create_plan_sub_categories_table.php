<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_sub_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->string('description', 150)->nullable();
            $table->unsignedBigInteger('plan_category_id')->nullable();
            // $table->foreign('plan_categories_id')->references('id')->on('plan_categories')->onDelete('set null');
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
        Schema::dropIfExists('plan_sub_categories');
    }
}
