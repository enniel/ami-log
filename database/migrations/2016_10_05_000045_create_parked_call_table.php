<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParkedCallTable extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ami_log_parked_call';

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
            $table->string('parking_lot')->nullable();
            $table->string('from')->nullable();
            $table->string('timeout')->nullable();
            $table->string('connected_line_num')->nullable();
            $table->string('connected_line_name')->nullable();
            $table->string('channel')->nullable();
            $table->string('caller_id_num')->nullable();
            $table->string('caller_id_name')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('extension')->nullable();
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
