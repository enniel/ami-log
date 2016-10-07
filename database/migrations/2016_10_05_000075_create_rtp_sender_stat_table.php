<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRTPSenderStatTable extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ami_log_rtp_sender_stat';

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
            $table->string('ssrc')->nullable();
            $table->string('sent_packets')->nullable();
            $table->string('lost_packets')->nullable();
            $table->string('jitter')->nullable();
            $table->string('rtt')->nullable();
            $table->string('sr_count')->nullable();
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
