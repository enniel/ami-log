<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonglePortFailTable extends Migration
{
    /**
     * Table name.
     *
     * @var string
     */
    public $table = 'ami_dongle_port_fail';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->string('privilege')->nullable();
            $table->string('device')->nullable();
            $table->string('message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop($this->table);
    }
}
