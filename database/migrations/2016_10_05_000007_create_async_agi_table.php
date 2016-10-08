<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsyncAGITable extends Migration
{
    /**
     * Table name.
     *
     * @var string
     */
    public $table = 'ami_log_async_agi';

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
            $table->string('sub_event')->nullable();
            $table->string('channel')->nullable();
            $table->string('environment')->nullable();
            $table->string('result')->nullable();
            $table->string('command_id')->nullable();
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
