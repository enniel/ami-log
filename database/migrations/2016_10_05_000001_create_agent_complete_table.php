<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentCompleteTable extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ami_log_agent_complete';

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
            $table->string('queue')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('channel')->nullable();
            $table->string('member')->nullable();
            $table->string('member_name')->nullable();
            $table->string('hold_time')->nullable();
            $table->string('talk_time')->nullable();
            $table->string('reason')->nullable();
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
