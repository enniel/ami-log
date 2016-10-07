<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueueMemberAddedTable extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ami_log_queue_member_added';

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
            $table->string('queue')->nullable();
            $table->string('location')->nullable();
            $table->string('member_name')->nullable();
            $table->string('membership')->nullable();
            $table->string('penalty')->nullable();
            $table->string('calls_taken')->nullable();
            $table->string('last_call')->nullable();
            $table->string('status')->nullable();
            $table->string('paused')->nullable();
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