<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueueParamsTable extends Migration
{
    /**
     * Table name.
     *
     * @var string
     */
    public $table = 'ami_log_queue_params';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->string('queue')->nullable();
            $table->string('max')->nullable();
            $table->string('strategy')->nullable();
            $table->string('calls')->nullable();
            $table->string('hold_time')->nullable();
            $table->string('completed')->nullable();
            $table->string('abandoned')->nullable();
            $table->string('service_level')->nullable();
            $table->string('service_level_perf')->nullable();
            $table->string('weight')->nullable();
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
