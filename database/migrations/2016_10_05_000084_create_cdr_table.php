<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCDRTable extends Migration
{
    /**
     * Table name.
     *
     * @var string
     */
    public $table = 'ami_log_cdr';

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
            $table->string('account_code')->nullable();
            $table->string('source')->nullable();
            $table->string('destination')->nullable();
            $table->string('destination_context')->nullable();
            $table->string('caller_id')->nullable();
            $table->string('channel')->nullable();
            $table->string('destination_channel')->nullable();
            $table->string('last_application')->nullable();
            $table->string('last_data')->nullable();
            $table->string('start_time')->nullable();
            $table->string('answer_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('duration')->nullable();
            $table->string('billable_seconds')->nullable();
            $table->string('disposition')->nullable();
            $table->string('ama_flags')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('user_field')->nullable();
            $table->string('rate')->nullable();
            $table->string('carrier')->nullable();
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
