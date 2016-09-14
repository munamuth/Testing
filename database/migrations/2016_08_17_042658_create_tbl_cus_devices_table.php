<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateTblCusDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_cus_devices', function (Blueprint $table) {
            //$table->engine = 'InnoDB';
            $table->increments('cus_dev_id');
            $table->integer('cus_id_for')->unsign();            
            $table->integer('dev_id_for')->unsign();
            $table->string('local_ip');
            $table->string('public_ip');
            $table->string('port');
            $table->string('username');
            $table->string('password');
            $table->timestamps();

            $table->foreign('cus_id_for')->references('cus_id')->on('tbl_customers');            
            $table->foreign('dev_id_for')->references('dev_id')->on('tbl_cus_devices');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_cus_devices');
    }
}
