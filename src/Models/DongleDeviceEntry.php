<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class DongleDeviceEntry extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_dongle_device_entry';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device',
        'audio_setting',
        'data_setting',
        'imei_setting',
        'imsi_setting',
        'channel_language',
        'context',
        'exten',
        'group',
        'rx_gain',
        'tx_gain',
        'u2diag',
        'use_calling_pres',
        'default_calling_pres',
        'auto_delete_sms',
        'disable_sms',
        'reset_dongle',
        'sms_pdu',
        'call_waiting_setting',
        'dtmf',
        'minimal_dtmf_gap',
        'minimal_dtmf_duration',
        'minimal_dtmf_interval',
        'state',
        'audio_state',
        'data_state',
        'voice',
        'sms',
        'manufacturer',
        'model',
        'firmware',
        'imei_state',
        'imsi_state',
        'gsm_registration_status',
        'rssi',
        'mode',
        'sub_mode',
        'provider_name',
        'location_area_code',
        'cell_id',
        'subscriber_number',
        'sms_service_center',
        'use_ucs2_encoding',
        'ussd_use_7bit_encoding',
        'ussd_use_ucs2_decoding',
        'tasks_in_queue',
        'commands_in_queue',
        'call_waiting_state',
        'carrent_device_state',
        'desired_device_state',
        'calls_channels',
        'active',
        'held',
        'dialing',
        'alerting',
        'incoming',
        'waiting',
        'releasing',
        'initializing',
    ];
}
