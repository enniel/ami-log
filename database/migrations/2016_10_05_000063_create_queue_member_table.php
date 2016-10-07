<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueueMemberTable extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ami_log_queue_member';

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
            $table->string('queue')->nullable();
            $table->string('location')->nullable();
            $table->string('name')->nullable();
            $table->string('membership')->nullable();
            $table->string('penalty')->nullable();
            $table->string('calls_taken')->nullable();
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
