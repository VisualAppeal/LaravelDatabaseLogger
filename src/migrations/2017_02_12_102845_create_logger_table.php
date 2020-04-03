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
        if (env('LOG_DATABASE', false) !== false && Schema::connection(env('LOG_DATABASE', config('database.default')))->hasTable(env('LOG_TABLE', 'logs')) === false) {
            Schema::connection(env('LOG_DATABASE', config('database.default')))->create(env('LOG_TABLE', 'logs'), function (Blueprint $table) {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('LOG_DATABASE', config('database.default')))->dropIfExists(env('LOG_TABLE', 'logs'));
    }
}
