<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeerEntryTable extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ami_log_peer_entry';

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
            $table->string('channel_type')->nullable();
            $table->string('object_name')->nullable();
            $table->string('chan_object_type')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('ip_port')->nullable();
            $table->string('dynamic')->nullable();
            $table->string('nat_support')->nullable();
            $table->string('video_support')->nullable();
            $table->string('text_support')->nullable();
            $table->string('acl')->nullable();
            $table->string('status')->nullable();
            $table->string('realtime_device')->nullable();
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
