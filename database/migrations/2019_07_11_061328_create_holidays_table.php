<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->date('start');
            $table->date('end')->nullable();
            $table->string('link', 200)->nullable();
            $table->string('status', 10)->nullable(); // google uses confirmed value to mark holiday.
            $table->string('google_event_id', 150)->unique(); // please use random string to fill when creating manual holiday
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
        Schema::dropIfExists('holidays');
    }
}
