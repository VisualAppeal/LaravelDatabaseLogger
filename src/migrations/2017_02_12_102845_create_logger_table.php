<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoggerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('LOG_TABLE', 'logs'), function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text('message');
            $table->text('context');
            $table->smallInteger('level')
                ->unsigned();
            $table->string('channel');
            $table->dateTime('created_at');
            $table->text('extra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(env('LOG_TABLE', 'logs'));
    }
}
