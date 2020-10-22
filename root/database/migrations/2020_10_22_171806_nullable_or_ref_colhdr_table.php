<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableOrRefColhdrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rssys.colhdr', function(Blueprint $table) {
            $table->string('or_ref', 50)->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rssys.colhdr', function(Blueprint $table) {
            $table->string('or_ref', 50)->nullable(false)->change();
        });
    }
}
