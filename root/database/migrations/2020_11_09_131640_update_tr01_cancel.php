<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTr01Cancel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rssys.tr01', function(Blueprint $table) {
            $table->dropColumn('cancel');
        });

        Schema::table('rssys.tr01', function(Blueprint $table) {
            $table->boolean('cancel')->defalut(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rssys.tr01', function(Blueprint $table) {
            $table->dropColumn('cancel');
        });

        Schema::table('rssys.tr01', function(Blueprint $table) {
            $table->string('cancel', 1)->nullable();
        });
    }
}
