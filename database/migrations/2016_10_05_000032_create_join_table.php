<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJoinTable extends Migration
{
    /**
     * Table name.
     *
     * @var string
     */
    public $table = 'ami_log_join';

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
            $table->string('channel')->nullable();
            $table->string('count')->nullable();
            $table->string('queue')->nullable();
            $table->string('position')->nullable();
            $table->string('caller_id_num')->nullable();
            $table->string('caller_id_name')->nullable();
            $table->string('connected_line_num')->nullable();
            $table->string('connected_line_name')->nullable();
            $table->string('unique_id')->nullable();
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
