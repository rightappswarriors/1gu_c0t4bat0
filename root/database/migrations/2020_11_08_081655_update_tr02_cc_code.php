<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTr02CcCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rssys.tr02', function(Blueprint $table) {
            $table->string('cc_code', 15)->nullable(true)->change();
            $table->string('pay_code', 15)->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rssys.tr02', function(Blueprint $table) {
            $table->string('cc_code', 3)->nullable(true)->change();
            $table->string('pay_code', 4)->nullable(true)->change();
        });
    }
}
