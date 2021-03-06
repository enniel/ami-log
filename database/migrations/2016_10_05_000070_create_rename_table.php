<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRenameTable extends Migration
{
    /**
     * Table name.
     *
     * @var string
     */
    public $table = 'ami_log_rename';

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
            $table->string('channel')->nullable();
            $table->string('old_name')->nullable();
            $table->string('new_name')->nullable();
            $table->string('unique_id')->nullable();
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
