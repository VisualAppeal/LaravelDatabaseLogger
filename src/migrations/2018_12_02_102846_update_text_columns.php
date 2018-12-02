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
        Schema::table(env('LOG_TABLE', 'logs'), function (Blueprint $table) {
            $table->longText('message')->change();
            $table->longText('context')->change();
            $table->longText('extra')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(env('LOG_TABLE', 'logs'), function (Blueprint $table) {
            $table->text('message')->change();
            $table->text('context')->change();
            $table->text('extra')->change();
        });
    }
}
