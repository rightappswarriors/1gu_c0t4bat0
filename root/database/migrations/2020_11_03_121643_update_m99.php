<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateM99 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            'comp_name' => 'City of Cotabato',
            'comp_addr' => 'Province of Maguindanao',
            'comp_tel'  => ''
        ];
        DB::table('rssys.m99')
            ->update($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
