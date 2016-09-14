<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_customers', function (Blueprint $table) {
            //$table->engine = 'InnoDB';
            $date = date ( "Y-m-d H:i:s" );
            $table->increments('cus_id');
            $table->string('cus_name');
            $table->longText('cus_addr');
            $table->string('cus_phone');
            $table->string('cus_email');
            $table->integer('cus_status')->default(1);
            $table->date('created_at')->default($date);
            $table->date('updated_at')->default($date);

            $table->foreign('cus_status')->references('status_id')->on('tbl_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_customers');
    }
}
