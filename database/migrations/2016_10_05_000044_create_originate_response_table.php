<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOriginateResponseTable extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ami_log_originate_response';

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
            $table->string('extension')->nullable();
            $table->string('channel')->nullable();
            $table->string('context')->nullable();
            $table->string('reason')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('action_id')->nullable();
            $table->string('response')->nullable();
            $table->string('caller_id_num')->nullable();
            $table->string('caller_id_name')->nullable();
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
