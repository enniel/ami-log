<?php

namespace Enniel\AmiLog;

use Clue\React\Ami\Protocol\Event;
use Enniel\AmiLog\Models\AgentCalled;
use Enniel\AmiLog\Models\AgentComplete;
use Enniel\AmiLog\Models\AgentConnect;
use Enniel\AmiLog\Models\AgentLogin;
use Enniel\AmiLog\Models\AgentLogoff;
use Enniel\AmiLog\Models\Agents;
use Enniel\AmiLog\Models\AGIExec;
use Enniel\AmiLog\Models\AsyncAGI;
use Enniel\AmiLog\Models\Bridge;
use Enniel\AmiLog\Models\CDR;
use Enniel\AmiLog\Models\CEL;
use Enniel\AmiLog\Models\ChannelUpdate;
use Enniel\AmiLog\Models\CoreShowChannel;
use Enniel\AmiLog\Models\CoreShowChannelsComplete;
use Enniel\AmiLog\Models\DAHDIShowChannels;
use Enniel\AmiLog\Models\DAHDIShowChannelsComplete;
use Enniel\AmiLog\Models\DBGetResponse;
use Enniel\AmiLog\Models\Dial;
use Enniel\AmiLog\Models\DongleDeviceEntry;
use Enniel\AmiLog\Models\DongleNewCUSD;
use Enniel\AmiLog\Models\DongleNewUSSD;
use Enniel\AmiLog\Models\DongleNewUSSDBase64;
use Enniel\AmiLog\Models\DongleShowDevicesComplete;
use Enniel\AmiLog\Models\DongleSMSStatus;
use Enniel\AmiLog\Models\DongleStatus;
use Enniel\AmiLog\Models\DongleUSSDStatus;
use Enniel\AmiLog\Models\DTMF;
use Enniel\AmiLog\Models\ExtensionStatus;
use Enniel\AmiLog\Models\FullyBooted;
use Enniel\AmiLog\Models\Hangup;
use Enniel\AmiLog\Models\Hold;
use Enniel\AmiLog\Models\Jabber;
use Enniel\AmiLog\Models\Join;
use Enniel\AmiLog\Models\Leave;
use Enniel\AmiLog\Models\ListDialPlan;
use Enniel\AmiLog\Models\Masquerade;
use Enniel\AmiLog\Models\MessageWaiting;
use Enniel\AmiLog\Models\MusicOnHold;
use Enniel\AmiLog\Models\NewAccountCode;
use Enniel\AmiLog\Models\NewCallerID;
use Enniel\AmiLog\Models\NewChannel;
use Enniel\AmiLog\Models\NewExtension;
use Enniel\AmiLog\Models\NewState;
use Enniel\AmiLog\Models\OriginateResponse;
use Enniel\AmiLog\Models\ParkedCall;
use Enniel\AmiLog\Models\ParkedCallsComplete;
use Enniel\AmiLog\Models\PeerEntry;
use Enniel\AmiLog\Models\PeerListComplete;
use Enniel\AmiLog\Models\PeerStatus;
use Enniel\AmiLog\Models\QueueMember;
use Enniel\AmiLog\Models\QueueMemberAdded;
use Enniel\AmiLog\Models\QueueMemberPaused;
use Enniel\AmiLog\Models\QueueMemberRemoved;
use Enniel\AmiLog\Models\QueueMemberStatus;
use Enniel\AmiLog\Models\QueueStatusComplete;
use Enniel\AmiLog\Models\QueueSummary;
use Enniel\AmiLog\Models\QueueSummaryComplete;
use Enniel\AmiLog\Models\RegistrationsComplete;
use Enniel\AmiLog\Models\Registry;
use Enniel\AmiLog\Models\Rename;
use Enniel\AmiLog\Models\RTCPReceived;
use Enniel\AmiLog\Models\RTCPReceiverStat;
use Enniel\AmiLog\Models\RTCPSent;
use Enniel\AmiLog\Models\RTPReceiverStat;
use Enniel\AmiLog\Models\RTPSenderStat;
use Enniel\AmiLog\Models\ShowDialPlanComplete;
use Enniel\AmiLog\Models\Status;
use Enniel\AmiLog\Models\StatusComplete;
use Enniel\AmiLog\Models\Transfer;
use Enniel\AmiLog\Models\UnLink;
use Enniel\AmiLog\Models\UnParkedCall;
use Enniel\AmiLog\Models\UserEvent;
use Enniel\AmiLog\Models\VarSet;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Str;

class AmiSubscriber
{
    /**
     * The event list.
     *
     * @var array
     */
    protected static $events = [
        'agi_exec',
        'agent_called',
        'agent_connect',
        'agent_complete',
        'agent_login',
        'agent_logoff',
        'agents',
        'async_agi',
        'bridge',
        'cdr',
        'cel',
        'channel_update',
        'core_show_channel',
        'core_show_channels_complete',
        'dahdi_show_channels_complete',
        'dahdi_show_channels',
        'db_get_response',
        'dtmf',
        'dial',
        'dongle_device_entry',
        'dongle_new_cusd',
        'dongle_new_ussd_base64',
        'dongle_new_ussd',
        'dongle_sms_status',
        'dongle_show_devices_complete',
        'dongle_status',
        'dongle_ussd_status',
        'extension_status',
        'fully_booted',
        'hangup',
        'hold',
        'jabber',
        'join',
        'leave',
        'list_dial_plan',
        'masquerade',
        'message_waiting',
        'music_on_hold',
        'new_account_code',
        'new_caller_id',
        'new_channel',
        'new_extension',
        'new_state',
        'originate_response',
        'parked_call',
        'parked_calls_complete',
        'peer_entry',
        'peer_status',
        'peer_list_complete',
        'queue_member_added',
        'queue_member',
        'queue_member_paused',
        'queue_member_removed',
        'queue_member_status',
        'queue_params',
        'queue_status_complete',
        'queue_summary_complete',
        'queue_summary',
        'rtcp_received',
        'rtcp_receiver_stat',
        'rtcp_sent',
        'rtp_receiver_stat',
        'rtp_sender_stat',
        'registrations_complete',
        'registry',
        'rename',
        'show_dial_plan_complete',
        'status_complete',
        'status',
        'transfer',
        'unparked_call',
        'unlink',
        'user_event',
        'var_set',
    ];

    /**
     * Get params from event.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     * @param array                         $map
     *
     * @return array
     */
    protected function params(Event $event, array $map = [])
    {
        $fields = [];
        foreach ($event->getFields() as $key => $value) {
            $key = mb_strtolower($key);
            $fields[$key] = $value;
        }
        $params = [];
        foreach ($map as $first => $second) {
            $first = mb_strtolower($first);
            $value = array_key_exists($first, $fields) ? $fields[$first] : null;
            $params[$second] = $value;
        }

        return $params;
    }

    /**
     * AGIExec handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function agiExec(Event $event)
    {
        $map = [
            'Privilege'  => 'privilege',
            'SubEvent'   => 'sub_event',
            'Channel'    => 'channel',
            'Command'    => 'command',
            'CommandId'  => 'command_id',
            'Result'     => 'result',
            'ResultCode' => 'result_code',
        ];
        $params = self::params($event, $map);
        AGIExec::create($params);
    }

    /**
     * AgentCalled handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function agentCalled(Event $event)
    {
        $map = [
            'Privilege'          => 'privilege',
            'Queue'              => 'queue',
            'AgentCalled'        => 'agent_called',
            'AgentName'          => 'agent_name',
            'ChannelCalling'     => 'channel_calling',
            'DestinationChannel' => 'destination_channel',
            'CallerIDNum'        => 'caller_id_num',
            'CallerIDName'       => 'caller_id_name',
            'ConnectedLineNum'   => 'connected_line_num',
            'ConnectedLineName'  => 'connected_line_name',
            'Context'            => 'context',
            'Extension'          => 'extension',
            'Priority'           => 'priority',
            'Uniqueid'           => 'unique_id',
        ];
        $params = self::params($event, $map);
        AgentCalled::create($params);
    }

    /**
     * AgentConnect handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function agentConnect(Event $event)
    {
        $map = [
            'Privilege'      => 'privilege',
            'HoldTime'       => 'hold_time',
            'BridgedChannel' => 'bridged_channel',
            'RingTime'       => 'ring_time',
            'Member'         => 'member',
            'MemberName'     => 'member_name',
            'Queue'          => 'queue',
            'UniqueID'       => 'unique_id',
            'Channel'        => 'channel',
        ];
        $params = self::params($event, $map);
        AgentConnect::create($params);
    }

    /**
     * AgentComplete handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function agentComplete(Event $event)
    {
        $map = [
            'Privilege'  => 'privilege',
            'Queue'      => 'queue',
            'Uniqueid'   => 'unique_id',
            'Channel'    => 'channel',
            'Member'     => 'member',
            'MemberName' => 'member_name',
            'HoldTime'   => 'hold_time',
            'TalkTime'   => 'talk_time',
            'Reason'     => 'reason',
        ];
        $params = self::params($event, $map);
        AgentComplete::create($params);
    }

    /**
     * Agentlogin handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function agentLogin(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Agent'     => 'agent',
            'UniqueID'  => 'unique_id',
            'Channel'   => 'channel',
        ];
        $params = self::params($event, $map);
        AgentLogin::create($params);
    }

    /**
     * Agentlogoff handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function agentLogoff(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Agent'     => 'agent',
            'UniqueID'  => 'unique_id',
            'Logintime' => 'login_time',
        ];
        $params = self::params($event, $map);
        AgentLogoff::create($params);
    }

    /**
     * Agents handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function agents(Event $event)
    {
        $map = [
            'Status'           => 'status',
            'Agent'            => 'agent',
            'Name'             => 'name',
            'LoggedInChan'     => 'logged_in_chan',
            'LoggedInTime'     => 'logged_in_time',
            'TalkingTo'        => 'talking_to',
            'TalkingToChannel' => 'talking_to_channel',
        ];
        $params = self::params($event, $map);
        Agents::create($params);
    }

    /**
     * AsyncAGI handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function asyncAgi(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'SubEvent'  => 'sub_event',
            'Channel'   => 'channel',
            'Env'       => 'environment',
            'Result'    => 'result',
            'CommandId' => 'command_id',
        ];
        $params = self::params($event, $map);
        AsyncAGI::create($params);
    }

    /**
     * Bridge handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function bridge(Event $event)
    {
        $map = [
            'Privilege'   => 'privilege',
            'Bridgestate' => 'bridge_state',
            'Bridgetype'  => 'bridge_type',
            'Channel1'    => 'channel_first',
            'Channel2'    => 'channel_second',
            'CallerID1'   => 'caller_id_first',
            'CallerID2'   => 'caller_id_second',
            'UniqueID1'   => 'unique_id_first',
            'UniqueID2'   => 'unique_id_second',
        ];
        $params = self::params($event, $map);
        Bridge::create($params);
    }

    /**
     * CDR handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function cdr(Event $event)
    {
        $map = [
            'Privilege'          => 'privilege',
            'AccountCode'        => 'account_code',
            'Source'             => 'source',
            'Destination'        => 'destination',
            'DestinationContext' => 'destination_context',
            'CallerID'           => 'caller_id',
            'Channel'            => 'channel',
            'DestinationChannel' => 'destination_channel',
            'LastApplication'    => 'last_application',
            'LastData'           => 'last_data',
            'StartTime'          => 'start_time',
            'AnswerTime'         => 'answer_time',
            'EndTime'            => 'end_time',
            'Duration'           => 'duration',
            'BillableSeconds'    => 'billable_seconds',
            'Disposition'        => 'disposition',
            'AMAFlags'           => 'ama_flags',
            'UniqueID'           => 'unique_id',
            'UserField'          => 'user_field',
            'Rate'               => 'rate',
            'Carrier'            => 'carrier',
        ];
        $params = self::params($event, $map);
        CDR::create($params);
    }

    /**
     * CEL handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function cel(Event $event)
    {
        $map = [
            'AMAFlags'      => 'ama_flags',
            'AccountCode'   => 'account_code',
            'AppData'       => 'app_data',
            'Application'   => 'application',
            'CallerIDani'   => 'caller_id_ani',
            'CallerIDdnid'  => 'caller_id_dnid',
            'CallerIDname'  => 'caller_id_name',
            'CallerIDnum'   => 'caller_id_num',
            'CallerIDrdnis' => 'caller_id_rdnis',
            'Channel'       => 'channel',
            'Context'       => 'context',
            'Event'         => 'event',
            'EventName'     => 'event_name',
            'EventTime'     => 'event_time',
            'Exten'         => 'exten',
            'Extra'         => 'extra',
            'LinkedID'      => 'linked_id',
            'Peer'          => 'peer',
            'PeerAccount'   => 'peer_account',
            'Privilege'     => 'privilege',
            'Timestamp'     => 'timestamp',
            'UniqueID'      => 'unique_id',
            'Userfield'     => 'user_field',
        ];
        $params = self::params($event, $map);
        CEL::create($params);
    }

    /**
     * ChannelUpdate handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function channelUpdate(Event $event)
    {
        $map = [
            'Privilege'      => 'privilege',
            'Channel'        => 'channel',
            'ChannelType'    => 'channel_type',
            'SIPcallid'      => 'sip_call_id',
            'SIPfullcontact' => 'sip_full_contact',
            'UniqueID'       => 'unique_id',
        ];
        $params = self::params($event, $map);
        ChannelUpdate::create($params);
    }

    /**
     * CoreShowChannel handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function coreShowChannel(Event $event)
    {
        $map = [
            'Privilege'        => 'privilege',
            'Channel'          => 'channel',
            'UniqueID'         => 'unique_id',
            'Context'          => 'context',
            'Extension'        => 'extension',
            'Priority'         => 'priority',
            'ChannelState'     => 'channel_state',
            'ChannelStateDesc' => 'channel_state_desc',
            'Application'      => 'application',
            'ApplicationData'  => 'application_data',
            'CallerIDNum'      => 'caller_id_num',
            'Duration'         => 'duration',
            'AccountCode'      => 'account_code',
            'BridgedChannel'   => 'bridged_channel',
            'BridgedUniqueID'  => 'bridged_unique_id',
        ];
        $params = self::params($event, $map);
        CoreShowChannel::create($params);
    }

    /**
     * CoreShowChannelsComplete handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function coreShowChannelsComplete(Event $event)
    {
        $map = [
            'ListItems' => 'list_items',
        ];
        $params = self::params($event, $map);
        CoreShowChannelsComplete::create($params);
    }

    /**
     * DAHDIShowChannelsComplete handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function dahdiShowChannelsComplete(Event $event)
    {
        $map = [
            'items' => 'items',
        ];
        $params = self::params($event, $map);
        DAHDIShowChannelsComplete::create($params);
    }

    /**
     * DAHDIShowChannels handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function dahdiShowChannels(Event $event)
    {
        $map = [
            'Channel'        => 'channel',
            'Signalling'     => 'signalling',
            'SignallingCode' => 'signalling_code',
            'Context'        => 'context',
            'DND'            => 'dnd',
            'Alarm'          => 'alarm',
        ];
        $params = self::params($event, $map);
        DAHDIShowChannels::create($params);
    }

    /**
     * DBGetResponse handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function dbGetResponse(Event $event)
    {
        $map = [
            'Family' => 'family',
            'Key'    => 'key',
            'Val'    => 'val',
        ];
        $params = self::params($event, $map);
        DBGetResponse::create($params);
    }

    /**
     * DTMF handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function dtmf(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Channel'   => 'channel',
            'Digit'     => 'digit',
            'Direction' => 'direction',
            'End'       => 'end',
            'Begin'     => 'begin',
            'UniqueID'  => 'unique_id',
        ];
        $params = self::params($event, $map);
        DTMF::create($params);
    }

    /**
     * Dial handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function dial(Event $event)
    {
        $map = [
            'Privilege'    => 'privilege',
            'SubEvent'     => 'sub_event',
            'Channel'      => 'channel',
            'Destination'  => 'destination',
            'CallerIDNum'  => 'caller_id_num',
            'CallerIDName' => 'caller_id_name',
            'UniqueID'     => 'unique_id',
            'DestUniqueID' => 'dest_unique_id',
            'DialString'   => 'dial_string',
            'DialStatus'   => 'dial_status',
        ];
        $params = self::params($event, $map);
        Dial::create($params);
    }

    /**
     * DongleDeviceEntry handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function dongleDeviceEntry(Event $event)
    {
        $map = [
            'Device'                => 'device',
            'AudioSetting'          => 'audio_setting',
            'DataSetting'           => 'data_setting',
            'IMEISetting'           => 'imei_setting',
            'IMSISetting'           => 'imsi_setting',
            'ChannelLanguage'       => 'channel_language',
            'Context'               => 'context',
            'Exten'                 => 'exten',
            'Group'                 => 'group',
            'RXGain'                => 'rx_gain',
            'TXGain'                => 'tx_gain',
            'U2DIAG'                => 'u2diag',
            'UseCallingPres'        => 'use_calling_pres',
            'DefaultCallingPres'    => 'default_calling_pres',
            'AutoDeleteSMS'         => 'auto_delete_sms',
            'DisableSMS'            => 'disable_sms',
            'ResetDongle'           => 'reset_dongle',
            'SMSPDU'                => 'sms_pdu',
            'CallWaitingSetting'    => 'call_waiting_setting',
            'DTMF'                  => 'dtmf',
            'MinimalDTMFGap'        => 'minimal_dtmf_gap',
            'MinimalDTMFDuration'   => 'minimal_dtmf_duration',
            'MinimalDTMFInterval'   => 'minimal_dtmf_interval',
            'State'                 => 'state',
            'AudioState'            => 'audio_state',
            'DataState'             => 'data_state',
            'Voice'                 => 'voice',
            'SMS'                   => 'sms',
            'Manufacturer'          => 'manufacturer',
            'Model'                 => 'model',
            'Firmware'              => 'firmware',
            'IMEIState'             => 'imei_state',
            'IMSIState'             => 'imsi_state',
            'GSMRegistrationStatus' => 'gsm_registration_status',
            'RSSI'                  => 'rssi',
            'Mode'                  => 'mode',
            'Submode'               => 'sub_mode',
            'ProviderName'          => 'provider_name',
            'LocationAreaCode'      => 'location_area_code',
            'CellID'                => 'cell_id',
            'SubscriberNumber'      => 'subscriber_number',
            'SMSServiceCenter'      => 'sms_service_center',
            'UseUCS2Encoding'       => 'use_ucs2_encoding',
            'USSDUse7BitEncoding'   => 'ussd_use_7bit_encoding',
            'USSDUseUCS2Decoding'   => 'ussd_use_ucs2_decoding',
            'TasksInQueue'          => 'tasks_in_queue',
            'CommandsInQueue'       => 'commands_in_queue',
            'CallWaitingState'      => 'call_waiting_state',
            'CurrentDeviceState'    => 'carrent_device_state',
            'DesiredDeviceState'    => 'desired_device_state',
            'CallsChannels'         => 'calls_channels',
            'Active'                => 'active',
            'Held'                  => 'held',
            'Dialing'               => 'dialing',
            'Alerting'              => 'alerting',
            'Incoming'              => 'incoming',
            'Waiting'               => 'waiting',
            'Releasing'             => 'releasing',
            'Initializing'          => 'initializing',
        ];
        $params = self::params($event, $map);
        DongleDeviceEntry::create($params);
    }

    /**
     * DongleNewCUSD handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function dongleNewCusd(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Device'    => 'device',
            'Message'   => 'message',
        ];
        $params = self::params($event, $map);
        DongleNewCUSD::create($params);
    }

    /**
     * DongleNewUSSDBase64 handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function dongleNewUssdBase64(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Device'    => 'device',
            'Message'   => 'message',
        ];
        $params = self::params($event, $map);
        DongleNewUSSDBase64::create($params);
    }

    /**
     * DongleNewUSSD handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function dongleNewUssd(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Device'    => 'device',
            'LineCount' => 'line_count',
        ];
        $params = self::params($event, $map);
        DongleNewUSSD::create($params);
    }

    /**
     * DongleSMSStatus handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function dongleSmsStatus(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Device'    => 'device',
            'Id'        => 'sms_id',
            'Status'    => 'status',
        ];
        $params = self::params($event, $map);
        DongleSMSStatus::create($params);
    }

    /**
     * DongleShowDevicesComplete handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function dongleShowDevicesComplete(Event $event)
    {
        $map = [
            'listitems' => 'list_items',
        ];
        $params = self::params($event, $map);
        DongleShowDevicesComplete::create($params);
    }

    /**
     * DongleStatus handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function dongleStatus(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Device'    => 'device',
            'Status'    => 'status',
        ];
        $params = self::params($event, $map);
        DongleStatus::create($params);
    }

    /**
     * DongleUSSDStatus handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function dongleUssdStatus(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Device'    => 'device',
            'Id'        => 'ussd_id',
            'Status'    => 'status',
        ];
        $params = self::params($event, $map);
        DongleUSSDStatus::create($params);
    }

    /**
     * ExtensionStatus handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function extensionStatus(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Status'    => 'status',
            'Exten'     => 'extension',
            'Context'   => 'context',
            'Hint'      => 'hint',
        ];
        $params = self::params($event, $map);
        ExtensionStatus::create($params);
    }

    /**
     * FullyBooted handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function fullyBooted(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Status'    => 'status',
        ];
        $params = self::params($event, $map);
        FullyBooted::create($params);
    }

    /**
     * Hangup handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function hangup(Event $event)
    {
        $map = [
            'Privilege'    => 'privilege',
            'Channel'      => 'channel',
            'CallerIDNum'  => 'caller_id_num',
            'CallerIDName' => 'caller_id_name',
            'UniqueID'     => 'unique_id',
            'Cause'        => 'cause',
            'Cause-txt'    => 'cause_text',
        ];
        $params = self::params($event, $map);
        Hangup::create($params);
    }

    /**
     * Hold handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function hold(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Channel'   => 'channel',
            'Status'    => 'status',
            'UniqueID'  => 'unique_id',
        ];
        $params = self::params($event, $map);
        Hold::create($params);
    }

    /**
     * JabberEvent handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function jabberEvent(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Account'   => 'account',
            'Packet'    => 'packet',
        ];
        $params = self::params($event, $map);
        JabberEvent::create($params);
    }

    /**
     * Join handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function join(Event $event)
    {
        $map = [
            'Privilege'         => 'privilege',
            'Channel'           => 'channel',
            'Count'             => 'count',
            'Queue'             => 'queue',
            'Position'          => 'position',
            'CallerIDNum'       => 'caller_id_num',
            'CallerIDName'      => 'caller_id_name',
            'ConnectedLineNum'  => 'connected_line_num',
            'ConnectedLineName' => 'connected_line_name',
            'UniqueID'          => 'unique_id',
        ];
        $params = self::params($event, $map);
        Join::create($params);
    }

    /**
     * Leave handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function leave(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Channel'   => 'channel',
            'Count'     => 'count',
            'Queue'     => 'queue',
            'UniqueID'  => 'unique_id',
        ];
        $params = self::params($event, $map);
        Leave::create($params);
    }

    /**
     * ListDialPlan handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function listDialPlan(Event $event)
    {
        $map = [
            'Context'        => 'context',
            'Extension'      => 'extension',
            'Priority'       => 'priority',
            'Application'    => 'application',
            'AppData'        => 'app_data',
            'Registrar'      => 'registrar',
            'IncludeContext' => 'include_context',
        ];
        $params = self::params($event, $map);
        ListDialPlan::create($params);
    }

    /**
     * Masquerade handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function masquerade(Event $event)
    {
        $map = [
            'Privilege'     => 'privilege',
            'Clone'         => 'clone',
            'CloneState'    => 'clone_state',
            'Original'      => 'original',
            'OriginalState' => 'original_state',
        ];
        $params = self::params($event, $map);
        Masquerade::create($params);
    }

    /**
     * MessageWaiting handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function messageWaiting(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Mailbox'   => 'mailbox',
            'Waiting'   => 'waiting',
        ];
        $params = self::params($event, $map);
        MessageWaiting::create($params);
    }

    /**
     * MusicOnHold handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function musicOnHold(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Channel'   => 'channel',
            'State'     => 'state',
            'UniqueID'  => 'unique_id',
        ];
        $params = self::params($event, $map);
        MusicOnHold::create($params);
    }

    /**
     * NewAccountCode handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function newAccountCode(Event $event)
    {
        $map = [
            'Privilege'      => 'privilege',
            'Channel'        => 'channel',
            'UniqueID'       => 'unique_id',
            'AccountCode'    => 'account_code',
            'OldAccountCode' => 'old_account_code',
        ];
        $params = self::params($event, $map);
        NewAccountCode::create($params);
    }

    /**
     * NewCallerid handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function newCallerId(Event $event)
    {
        $map = [
            'Privilege'       => 'privilege',
            'Channel'         => 'channel',
            'CallerIDNum'     => 'caller_id_num',
            'CallerIDName'    => 'caller_id_name',
            'UniqueID'        => 'unique_id',
            'CID-CallingPres' => 'cid_calling_pres',
        ];
        $params = self::params($event, $map);
        NewCallerID::create($params);
    }

    /**
     * Newchannel handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function newChannel(Event $event)
    {
        $map = [
            'Privilege'        => 'privilege',
            'Channel'          => 'channel',
            'ChannelState'     => 'channel_state',
            'ChannelStateDesc' => 'channel_state_desc',
            'CallerIDNum'      => 'caller_id_num',
            'CallerIDName'     => 'caller_id_name',
            'UniqueID'         => 'unique_id',
            'AccountCode'      => 'account_code',
            'Context'          => 'context',
            'Exten'            => 'extension',
        ];
        $params = self::params($event, $map);
        NewChannel::create($params);
    }

    /**
     * Newexten handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function newExtension(Event $event)
    {
        $map = [
            'Privilege'   => 'privilege',
            'Channel'     => 'channel',
            'Extension'   => 'extension',
            'Context'     => 'context',
            'UniqueID'    => 'unique_id',
            'Priority'    => 'priority',
            'Application' => 'application',
            'AppData'     => 'app_data',
        ];
        $params = self::params($event, $map);
        NewExtension::create($params);
    }

    /**
     * Newstate handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function newState(Event $event)
    {
        $map = [
            'Privilege'         => 'privilege',
            'Channel'           => 'channel',
            'ChannelState'      => 'channel_state',
            'ChannelStateDesc'  => 'channel_state_desc',
            'CallerIDNum'       => 'caller_id_num',
            'CallerIDName'      => 'caller_id_name',
            'UniqueID'          => 'unique_id',
            'ConnectedLineNum'  => 'connected_line_num',
            'ConnectedLineName' => 'connected_line_name',
        ];
        $params = self::params($event, $map);
        NewState::create($params);
    }

    /**
     * OriginateResponse handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function originateResponse(Event $event)
    {
        $map = [
            'Privilege'    => 'privilege',
            'Exten'        => 'extension',
            'Channel'      => 'channel',
            'Context'      => 'context',
            'Reason'       => 'reason',
            'UniqueID'     => 'unique_id',
            'ActionID'     => 'action_id',
            'Response'     => 'response',
            'CallerIdNum'  => 'caller_id_num',
            'CallerIdName' => 'caller_id_name',
        ];
        $params = self::params($event, $map);
        OriginateResponse::create($params);
    }

    /**
     * parkedCall handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function parkedCall(Event $event)
    {
        $map = [
            'Privilege'         => 'privilege',
            'Parkinglot'        => 'parking_lot',
            'From'              => 'from',
            'Timeout'           => 'timeout',
            'ConnectedLineNum'  => 'connected_line_num',
            'ConnectedLineName' => 'connected_line_name',
            'Channel'           => 'channel',
            'CallerIDNum'       => 'caller_id_num',
            'CallerIDName'      => 'caller_id_name',
            'UniqueID'          => 'unique_id',
            'Exten'             => 'extension',
        ];
        $params = self::params($event, $map);
        ParkedCall::create($params);
    }

    /**
     * ParkedCallsComplete handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function parkedCallsComplete(Event $event)
    {
        $map = [

        ];
        $params = self::params($event, $map);
        ParkedCallsComplete::create($params);
    }

    /**
     * peerEntry handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function peerEntry(Event $event)
    {
        $map = [
            'ChannelType'    => 'channel_type',
            'ObjectName'     => 'object_name',
            'ChanObjectType' => 'chan_object_type',
            'IPAddress'      => 'ip_address',
            'IPPort'         => 'ip_port',
            'Dynamic'        => 'dynamic',
            'NatSupport'     => 'nat_support',
            'VideoSupport'   => 'video_support',
            'TextSupport'    => 'text_support',
            'ACL'            => 'acl',
            'Status'         => 'status',
            'RealtimeDevice' => 'realtime_device',
        ];
        $params = self::params($event, $map);
        PeerEntry::create($params);
    }

    /**
     * PeerStatus handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function peerStatus(Event $event)
    {
        $map = [
            'ChannelType' => 'channel_type',
            'Privilege'   => 'privilege',
            'Peer'        => 'peer',
            'PeerStatus'  => 'peer_status',
            'Address'     => 'address',
        ];
        $params = self::params($event, $map);
        PeerStatus::create($params);
    }

    /**
     * PeerlistComplete handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function peerListComplete(Event $event)
    {
        $map = [
            'ListItems' => 'list_items',
        ];
        $params = self::params($event, $map);
        PeerListComplete::create($params);
    }

    /**
     * QueueMemberAdded handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function queueMemberAdded(Event $event)
    {
        $map = [
            'Privilege'  => 'privilege',
            'Queue'      => 'queue',
            'Location'   => 'location',
            'MemberName' => 'member_name',
            'Membership' => 'membership',
            'Penalty'    => 'penalty',
            'CallsTaken' => 'calls_taken',
            'LastCall'   => 'last_call',
            'Status'     => 'status',
            'Paused'     => 'paused',
        ];
        $params = self::params($event, $map);
        QueueMemberAdded::create($params);
    }

    /**
     * QueueMember handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function queueMember(Event $event)
    {
        $map = [
            'Queue'      => 'queue',
            'Location'   => 'location',
            'Name'       => 'name',
            'Membership' => 'membership',
            'Penalty'    => 'penalty',
            'CallsTaken' => 'calls_taken',
            'Status'     => 'status',
            'Paused'     => 'paused',
        ];
        $params = self::params($event, $map);
        QueueMember::create($params);
    }

    /**
     * QueueMemberPaused handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function queueMemberPaused(Event $event)
    {
        $map = [
            'Privilege'  => 'privilege',
            'Queue'      => 'queue',
            'Location'   => 'location',
            'MemberName' => 'member_name',
            'Paused'     => 'paused',
        ];
        $params = self::params($event, $map);
        QueueMemberPaused::create($params);
    }

    /**
     * QueueMemberRemoved handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function queueMemberRemoved(Event $event)
    {
        $map = [
            'Privilege'  => 'privilege',
            'Queue'      => 'queue',
            'Location'   => 'location',
            'MemberName' => 'member_name',
        ];
        $params = self::params($event, $map);
        QueueMemberRemoved::create($params);
    }

    /**
     * QueueMemberStatus handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function queueMemberStatus(Event $event)
    {
        $map = [
            'Privilege'  => 'privilege',
            'Queue'      => 'queue',
            'Location'   => 'location',
            'MemberName' => 'member_name',
            'Membership' => 'membership',
            'Penalty'    => 'penalty',
            'CallsTaken' => 'calls_taken',
            'Status'     => 'status',
            'Paused'     => 'paused',
        ];
        $params = self::params($event, $map);
        QueueMemberStatus::create($params);
    }

    /**
     * QueueStatusComplete handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function queueStatusComplete(Event $event)
    {
        $map = [

        ];
        $params = self::params($event, $map);
        QueueStatusComplete::create($params);
    }

    /**
     * QueueSummaryComplete handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function queueSummaryComplete(Event $event)
    {
        $map = [

        ];
        $params = self::params($event, $map);
        QueueSummaryComplete::create($params);
    }

    /**
     * QueueSummary handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function queueSummary(Event $event)
    {
        $map = [
            'Queue'           => 'queue',
            'LoggedIn'        => 'logged_in',
            'Available'       => 'available',
            'Callers'         => 'callers',
            'HoldTime'        => 'hold_time',
            'LongestHoldTime' => 'longest_hold_time',
        ];
        $params = self::params($event, $map);
        QueueSummary::create($params);
    }

    /**
     * RTCPReceived handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function rtcpReceived(Event $event)
    {
        $map = [
            'Privilege'            => 'privilege',
            'From'                 => 'from',
            'PT'                   => 'pt',
            'ReceptionReports'     => 'reception_reports',
            'SenderSSRC'           => 'sender_ssrc',
            'FractionLost'         => 'fraction_lost',
            'PacketsLost'          => 'packets_lost',
            'HighestSequence'      => 'highest_sequence',
            'SequenceNumberCycles' => 'sequence_number_cycles',
            'IAJitter'             => 'ia_jitter',
            'LastSR'               => 'last_sr',
            'DLSR'                 => 'dlsr',
            'RTT'                  => 'rtt',
        ];
        $params = self::params($event, $map);
        RTCPReceived::create($params);
    }

    /**
     * RTCPReceiverStat handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function rtcpReceiverStat(Event $event)
    {
        $map = [
            'Privilege'       => 'privilege',
            'SSRC'            => 'ssrc',
            'ReceivedPackets' => 'received_packets',
            'LostPackets'     => 'lost_packets',
            'Jitter'          => 'jitter',
            'Transit'         => 'transit',
            'RRCount'         => 'rr_count',
        ];
        $params = self::params($event, $map);
        RTCPReceiverStat::create($params);
    }

    /**
     * RTCPSent handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function rtcpSent(Event $event)
    {
        $map = [
            'Privilege'      => 'privilege',
            'To'             => 'to',
            'OurSSRC'        => 'our_ssrc',
            'SentNTP'        => 'sent_ntp',
            'SentRTP'        => 'sent_rtp',
            'SentPackets'    => 'sent_packets',
            'SentOctets'     => 'sent_octets',
            'ReportBlock'    => 'report_block',
            'FractionLost'   => 'fraction_lost',
            'CumulativeLoss' => 'cumulative_loss',
            'IAJitter'       => 'ia_jitter',
            'TheirLastSR'    => 'their_last_sr',
            'DLSR'           => 'dlsr',
        ];
        $params = self::params($event, $map);
        RTCPSent::create($params);
    }

    /**
     * RTPReceiverStat handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function rtpReceiverStat(Event $event)
    {
        $map = [
            'Privilege'       => 'privilege',
            'SSRC'            => 'ssrc',
            'ReceivedPackets' => 'received_packets',
            'LostPackets'     => 'lost_packets',
            'Jitter'          => 'jitter',
            'Transit'         => 'transit',
            'RRCount'         => 'rr_count',
        ];
        $params = self::params($event, $map);
        RTPReceiverStat::create($params);
    }

    /**
     * RTPSenderStat handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function rtpSenderStat(Event $event)
    {
        $map = [
            'Privilege'   => 'privilege',
            'SSRC'        => 'ssrc',
            'SentPackets' => 'sent_packets',
            'LostPackets' => 'lost_packets',
            'Jitter'      => 'jitter',
            'RTT'         => 'rtt',
            'SRCount'     => 'sr_count',
        ];
        $params = self::params($event, $map);
        RTPSenderStat::create($params);
    }

    /**
     * RegistrationsComplete handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function registrationsComplete(Event $event)
    {
        $map = [
            'ListItems' => 'list_items',
        ];
        $params = self::params($event, $map);
        RegistrationsComplete::create($params);
    }

    /**
     * Registry handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function registry(Event $event)
    {
        $map = [
            'Privilege'   => 'privilege',
            'ChannelType' => 'channel_type',
            'Username'    => 'username',
            'Domain'      => 'domain',
            'Status'      => 'status',
        ];
        $params = self::params($event, $map);
        Registry::create($params);
    }

    /**
     * Rename handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function rename(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Channel'   => 'channel',
            'Oldname'   => 'old_name',
            'Newname'   => 'new_name',
            'UniqueID'  => 'unique_id',
        ];
        $params = self::params($event, $map);
        Rename::create($params);
    }

    /**
     * ShowDialPlanComplete handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function showDialPlanComplete(Event $event)
    {
        $map = [
            'Privilege'      => 'privilege',
            'listitems'      => 'list_items',
            'listextensions' => 'list_extensions',
            'listpriorities' => 'list_priorities',
            'listcontexts'   => 'list_contexts',
        ];
        $params = self::params($event, $map);
        ShowDialPlanComplete::create($params);
    }

    /**
     * StatusComplete handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function statusComplete(Event $event)
    {
        $map = [
            'Items' => 'items',
        ];
        $params = self::params($event, $map);
        StatusComplete::create($params);
    }

    /**
     * Status handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function status(Event $event)
    {
        $map = [
            'BridgedUniqueID'  => 'bridged_unique_id',
            'Privilege'        => 'privilege',
            'Channel'          => 'channel',
            'Context'          => 'context',
            'Extension'        => 'extension',
            'UniqueID'         => 'unique_id',
            'Priority'         => 'priority',
            'ChannelState'     => 'channel_state',
            'ChannelStateDesc' => 'channel_state_desc',
            'Application'      => 'application',
            'ApplicationData'  => 'application_data',
            'CallerIDNum'      => 'caller_id_num',
            'Duration'         => 'duration',
            'AccountCode'      => 'account_code',
            'Seconds'          => 'seconds',
            'BridgedChannel'   => 'bridged_channel',
        ];
        $params = self::params($event, $map);
        Status::create($params);
    }

    /**
     * Transfer handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function transfer(Event $event)
    {
        $map = [
            'Privilege'       => 'privilege',
            'Channel'         => 'channel',
            'TransferMethod'  => 'transfer_method',
            'TransferType'    => 'transfer_type',
            'TargetChannel'   => 'target_channel',
            'SIP-Callid'      => 'sip_call_id',
            'UniqueID'        => 'unique_id',
            'TargetUniqueid'  => 'target_unique_id',
            'TransferExten'   => 'transfer_extension',
            'TransferContext' => 'transfer_context',
        ];
        $params = self::params($event, $map);
        Transfer::create($params);
    }

    /**
     * UnParkedCall handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function unParkedCall(Event $event)
    {
        $map = [
            'Privilege'         => 'privilege',
            'Parkinglot'        => 'parking_lot',
            'From'              => 'from',
            'ConnectedLineNum'  => 'connected_line_num',
            'ConnectedLineName' => 'connected_line_name',
            'Channel'           => 'channel',
            'CallerIDNum'       => 'caller_id_num',
            'CallerIDName'      => 'caller_id_name',
            'UniqueID'          => 'unique_id',
            'Exten'             => 'extension',
        ];
        $params = self::params($event, $map);
        UnParkedCall::create($params);
    }

    /**
     * UnLink handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function unLink(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'Channel1'  => 'channel_first',
            'Channel2'  => 'channel_second',
            'CallerID1' => 'caller_id_first',
            'CallerID2' => 'caller_id_second',
            'UniqueID1' => 'unique_id_first',
            'UniqueID2' => 'unique_id_second',
        ];
        $params = self::params($event, $map);
        UnLink::create($params);
    }

    /**
     * UserEvent handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function userEvent(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'UniqueID'  => 'unique_id',
            'UserEvent' => 'user_event',
        ];
        $params = self::params($event, $map);
        UserEvent::create($params);
    }

    /**
     * VarSet handler.
     *
     * @param Clue\React\Ami\Protocol\Event $event
     */
    public function varSet(Event $event)
    {
        $map = [
            'Privilege' => 'privilege',
            'UniqueID'  => 'unique_id',
            'Channel'   => 'channel',
            'Variable'  => 'variable',
            'Value'     => 'value',
        ];
        $params = self::params($event, $map);
        VarSet::create($params);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param Illuminate\Events\Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        foreach (self::$events as $event) {
            $method = Str::camel($event);
            $events->listen('ami.events.'.$event, function (Event $event, array $options = []) use ($method) {
                $logging = array_key_exists('logging', $options) ? $options['logging'] : false;
                if ($logging) {
                    self::$method($event);
                }
            });
        }
    }
}
