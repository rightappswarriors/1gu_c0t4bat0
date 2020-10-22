<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTr01CheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rssys.tr01_check', function (Blueprint $table) {
            $table->increments('id');
            $table->string('j_code', 4);
            $table->string('j_num', 8);
            $table->date('t_date')->nullable();
            $table->string('payee', 450)->nullable();
            $table->string('chk_no', 16)->nullable();
            $table->string('chk_bank', 100)->nullable();
            $table->boolean('isprinted');
            $table->date('r_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rssys.tr01_check');
    }
}
