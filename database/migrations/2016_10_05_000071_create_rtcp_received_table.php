<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRTCPReceivedTable extends Migration
{
    /**
     * Table name.
     *
     * @var string
     */
    public $table = 'ami_log_rtcp_received';

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
            $table->string('from')->nullable();
            $table->string('pt')->nullable();
            $table->string('reception_reports')->nullable();
            $table->string('sender_ssrc')->nullable();
            $table->string('fraction_lost')->nullable();
            $table->string('packets_lost')->nullable();
            $table->string('highest_sequence')->nullable();
            $table->string('sequence_number_cycles')->nullable();
            $table->string('ia_jitter')->nullable();
            $table->string('last_sr')->nullable();
            $table->string('dlsr')->nullable();
            $table->string('rtt')->nullable();
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
