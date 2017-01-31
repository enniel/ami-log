<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRTCPSentTable extends Migration
{
    /**
     * Table name.
     *
     * @var string
     */
    public $table = 'ami_log_rtcp_sent';

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
            $table->string('to')->nullable();
            $table->string('our_ssrc')->nullable();
            $table->string('sent_ntp')->nullable();
            $table->string('sent_rtp')->nullable();
            $table->string('sent_packets')->nullable();
            $table->string('sent_octets')->nullable();
            $table->string('report_block')->nullable();
            $table->string('fraction_lost')->nullable();
            $table->string('cumulative_loss')->nullable();
            $table->string('ia_jitter')->nullable();
            $table->string('their_last_sr')->nullable();
            $table->string('dlsr')->nullable();
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
