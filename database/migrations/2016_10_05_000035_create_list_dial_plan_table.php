<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListDialPlanTable extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ami_log_list_dial_plan';

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
            $table->string('context')->nullable();
            $table->string('extension')->nullable();
            $table->string('priority')->nullable();
            $table->string('application')->nullable();
            $table->string('app_data')->nullable();
            $table->string('registrar')->nullable();
            $table->string('include_context')->nullable();
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
