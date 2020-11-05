<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRssystr01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rssys.tr01', function(Blueprint $table) {
            $table->decimal('fy', 4, 0);
            $table->decimal('mo', 2, 0);
            $table->string('j_code', 4);
            $table->string('j_cnum', 8);
            $table->date('t_date')->nullable();
            $table->string('t_desc', 750)->nullable();
            $table->string('payee', 450)->nullable();
            $table->date('ck_date')->nullable();
            $table->string('user_id', 8);
            $table->string('systime', 5)->nullable();
            $table->string('cancel', 1)->nullable();
            $table->string('relsd', 1)->nullable();
            $table->string('rec_num', 9)->nullable();
            $table->string('asci_code', 1)->nullable();
            $table->string('jo_code', 15)->nullable();
            $table->string('pr_code', 15)->nullable();
            $table->string('purc_ord', 15)->nullable();
            $table->string('inv_num', 15)->nullable();
            $table->string('dr_code', 15)->nullable();
            $table->string('vp_num', 8)->nullable();
            $table->date('sysdate')->nullable();
            $table->string('ck_num', 16)->nullable();
            $table->string('branch', 15)->nullable();
            $table->string('collectorid', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rssys.tr01');
    }
}
