<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Table name.
     *
     * @var string
     */
    public $table = 'ami_log_agents';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->string('status')->nullable();
            $table->string('agent')->nullable();
            $table->string('name')->nullable();
            $table->string('logged_in_chan')->nullable();
            $table->string('logged_in_time')->nullable();
            $table->string('talking_to')->nullable();
            $table->string('talking_to_channel')->nullable();
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
