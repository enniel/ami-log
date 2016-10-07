<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowDialPlanCompleteTable extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ami_log_show_dial_plan_complete';

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
            $table->string('list_items')->nullable();
            $table->string('list_extensions')->nullable();
            $table->string('list_priorities')->nullable();
            $table->string('list_contexts')->nullable();
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
