<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferTable extends Migration
{
    /**
     * Table name.
     *
     * @var string
     */
    public $table = 'ami_log_transfer';

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
            $table->string('channel')->nullable();
            $table->string('transfer_method')->nullable();
            $table->string('transfer_type')->nullable();
            $table->string('target_channel')->nullable();
            $table->string('sip_call_id')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('target_unique_id')->nullable();
            $table->string('transfer_extension')->nullable();
            $table->string('transfer_context')->nullable();
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
