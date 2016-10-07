<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusTable extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ami_log_status';

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
            $table->string('bridged_unique_id')->nullable();
            $table->string('privilege')->nullable();
            $table->string('channel')->nullable();
            $table->string('context')->nullable();
            $table->string('extension')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('priority')->nullable();
            $table->string('channel_state')->nullable();
            $table->string('channel_state_desc')->nullable();
            $table->string('application')->nullable();
            $table->string('application_data')->nullable();
            $table->string('caller_id_num')->nullable();
            $table->string('duration')->nullable();
            $table->string('account_code')->nullable();
            $table->string('seconds')->nullable();
            $table->string('bridged_channel')->nullable();
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
