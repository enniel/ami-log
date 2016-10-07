<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueueSummaryTable extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ami_log_queue_summary';

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
            $table->string('logged_in')->nullable();
            $table->string('available')->nullable();
            $table->string('callers')->nullable();
            $table->string('hold_time')->nullable();
            $table->string('longest_hold_time')->nullable();
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
