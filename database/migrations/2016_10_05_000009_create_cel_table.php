<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCELTable extends Migration
{
    /**
     * Table name.
     *
     * @var string
     */
    public $table = 'ami_log_cel';

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
            $table->string('ama_flags')->nullable();
            $table->string('account_code')->nullable();
            $table->string('app_data')->nullable();
            $table->string('application')->nullable();
            $table->string('caller_id_ani')->nullable();
            $table->string('caller_id_dnid')->nullable();
            $table->string('caller_id_name')->nullable();
            $table->string('caller_id_num')->nullable();
            $table->string('caller_id_rdnis')->nullable();
            $table->string('channel')->nullable();
            $table->string('context')->nullable();
            $table->string('event')->nullable();
            $table->string('event_name')->nullable();
            $table->string('event_time')->nullable();
            $table->string('exten')->nullable();
            $table->string('extra')->nullable();
            $table->string('linked_id')->nullable();
            $table->string('peer')->nullable();
            $table->string('peer_account')->nullable();
            $table->string('privilege')->nullable();
            $table->string('timestamp')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('user_field')->nullable();
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
