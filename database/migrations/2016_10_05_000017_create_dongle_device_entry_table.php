<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDongleDeviceEntryTable extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ami_log_dongle_device_entry';

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
            $table->string('device')->nullable();
            $table->string('audio_setting')->nullable();
            $table->string('data_setting')->nullable();
            $table->string('imei_setting')->nullable();
            $table->string('imsi_setting')->nullable();
            $table->string('channel_language')->nullable();
            $table->string('context')->nullable();
            $table->string('exten')->nullable();
            $table->string('group')->nullable();
            $table->string('rx_gain')->nullable();
            $table->string('tx_gain')->nullable();
            $table->string('u2diag')->nullable();
            $table->string('use_calling_pres')->nullable();
            $table->string('default_calling_pres')->nullable();
            $table->string('auto_delete_sms')->nullable();
            $table->string('disable_sms')->nullable();
            $table->string('reset_dongle')->nullable();
            $table->string('sms_pdu')->nullable();
            $table->string('call_waiting_setting')->nullable();
            $table->string('dtmf')->nullable();
            $table->string('minimal_dtmf_gap')->nullable();
            $table->string('minimal_dtmf_duration')->nullable();
            $table->string('minimal_dtmf_interval')->nullable();
            $table->string('state')->nullable();
            $table->string('audio_state')->nullable();
            $table->string('data_state')->nullable();
            $table->string('voice')->nullable();
            $table->string('sms')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('model')->nullable();
            $table->string('firmware')->nullable();
            $table->string('imei_state')->nullable();
            $table->string('imsi_state')->nullable();
            $table->string('gsm_registration_status')->nullable();
            $table->string('rssi')->nullable();
            $table->string('mode')->nullable();
            $table->string('sub_mode')->nullable();
            $table->string('provider_name')->nullable();
            $table->string('location_area_code')->nullable();
            $table->string('cell_id')->nullable();
            $table->string('subscriber_number')->nullable();
            $table->string('sms_service_center')->nullable();
            $table->string('use_ucs2_encoding')->nullable();
            $table->string('ussd_use_7bit_encoding')->nullable();
            $table->string('ussd_use_ucs2_decoding')->nullable();
            $table->string('tasks_in_queue')->nullable();
            $table->string('commands_in_queue')->nullable();
            $table->string('call_waiting_state')->nullable();
            $table->string('carrent_device_state')->nullable();
            $table->string('desired_device_state')->nullable();
            $table->string('calls_channels')->nullable();
            $table->string('active')->nullable();
            $table->string('held')->nullable();
            $table->string('dialing')->nullable();
            $table->string('alerting')->nullable();
            $table->string('incoming')->nullable();
            $table->string('waiting')->nullable();
            $table->string('releasing')->nullable();
            $table->string('initializing')->nullable();
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
