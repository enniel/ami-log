<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDialTable extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ami_log_dial';

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
            $table->string('destination')->nullable();
            $table->string('caller_id_num')->nullable();
            $table->string('caller_id_name')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('dest_unique_id')->nullable();
            $table->string('dial_string')->nullable();
            $table->string('dial_status')->nullable();
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