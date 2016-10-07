<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBridgeTable extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ami_log_bridge';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->string('privilege')->nullable();
            $table->string('bridge_state')->nullable();
            $table->string('bridge_type')->nullable();
            $table->string('channel_first')->nullable();
            $table->string('channel_second')->nullable();
            $table->string('caller_id_first')->nullable();
            $table->string('caller_id_second')->nullable();
            $table->string('unique_id_first')->nullable();
            $table->string('unique_id_second')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->table);
    }
}
