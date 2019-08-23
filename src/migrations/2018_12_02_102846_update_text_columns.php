<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTextColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (env('LOG_DATABASE', false) !== false) {
            Schema::connection(env('LOG_DATABASE', config('database.default')))->table(env('LOG_TABLE', 'logs'), function (Blueprint $table) {
                $table->longText('message')->change();
                $table->longText('context')
                    ->nullable()
                    ->change();
                $table->longText('extra')->change();
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
        if (env('LOG_DATABASE', false) !== false) {
            Schema::connection(env('LOG_DATABASE', config('database.default')))->table(env('LOG_TABLE', 'logs'), function (Blueprint $table) {
                $table->text('message')->change();
                $table->text('context')->change();
                $table->text('extra')->change();
            });
        }
    }
}
