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
use Enniel\AmiLog\Models\DonglePortFail;
use Enniel\AmiLog\Models\DongleShowDevicesComplete;
use Enniel\AmiLog\Models\DongleSMSStatus;
use Enniel\AmiLog\Models\DongleStatus;
use Enniel\AmiLog\Models\DongleUSSDStatus;
use Enniel\AmiLog\Models\DTMF;
use Enniel\AmiLog\Models\ExtensionStatus;
use Enniel\AmiLog\Models\FullyBooted;
use Enniel\AmiLog\Models\Hangup;
use Enniel\AmiLog\Models\Hold;
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
use Illuminate\Database\Eloquent\Model;

class AmiSubscriber
{
    /**
     * The event list.
     *
     * @var array
     */
    protected static $events = [
        'AGIExec' => [
            'model' => AGIExec::class,
            'map' => [
                'Privilege' => 'privilege',
                'SubEvent' => 'sub_event',
                'Channel' => 'channel',
                'Command' => 'command',
                'CommandId' => 'command_id',
                'Result' => 'result',
                'ResultCode' => 'result_code',
            ],
        ],
        'AgentCalled' => [
            'model' => AgentCalled::class,
            'map' => [
                'Privilege' => 'privilege',
                'Queue' => 'queue',
                'AgentCalled' => 'agent_called',
                'AgentName' => 'agent_name',
                'ChannelCalling' => 'channel_calling',
                'DestinationChannel' => 'destination_channel',
                'CallerIDNum' => 'caller_id_num',
                'CallerIDName' => 'caller_id_name',
                'ConnectedLineNum' => 'connected_line_num',
                'ConnectedLineName' => 'connected_line_name',
                'Context' => 'context',
                'Extension' => 'extension',
                'Priority' => 'priority',
                'Uniqueid' => 'unique_id',
            ],
        ],
        'AgentConnect' => [
            'model' => AgentConnect::class,
            'map' => [
                'Privilege' => 'privilege',
                'HoldTime' => 'hold_time',
                'BridgedChannel' => 'bridged_channel',
                'RingTime' => 'ring_time',
                'Member' => 'member',
                'MemberName' => 'member_name',
                'Queue' => 'queue',
                'UniqueID' => 'unique_id',
                'Channel' => 'channel',
            ],
        ],
        'AgentComplete' => [
            'model' => AgentComplete::class,
            'map' => [
                'Privilege' => 'privilege',
                'Queue' => 'queue',
                'Uniqueid' => 'unique_id',
                'Channel' => 'channel',
                'Member' => 'member',
                'MemberName' => 'member_name',
                'HoldTime' => 'hold_time',
                'TalkTime' => 'talk_time',
                'Reason' => 'reason',
            ],
        ],
        'Agentlogin' => [
            'model' => AgentLogin::class,
            'map' => [
                'Privilege' => 'privilege',
                'Agent' => 'agent',
                'UniqueID' => 'unique_id',
                'Channel' => 'channel',
            ],
        ],
        'Agentlogoff' => [
            'model' => AgentLogoff::class,
            'map' => [
                'Privilege' => 'privilege',
                'Agent' => 'agent',
                'UniqueID' => 'unique_id',
                'Logintime' => 'login_time',
            ],
        ],
        'Agents' => [
            'model' => Agents::class,
            'map' => [
                'Status' => 'status',
                'Agent' => 'agent',
                'Name' => 'name',
                'LoggedInChan' => 'logged_in_chan',
                'LoggedInTime' => 'logged_in_time',
                'TalkingTo' => 'talking_to',
                'TalkingToChannel' => 'talking_to_channel',
            ],
        ],
        'AsyncAGI' => [
            'model' => AsyncAGI::class,
            'map' => [
                'Privilege' => 'privilege',
                'SubEvent' => 'sub_event',
                'Channel' => 'channel',
                'Env' => 'environment',
                'Result' => 'result',
                'CommandId' => 'command_id',
            ],
        ],
        'Bridge' => [
            'model' => Bridge::class,
            'map' => [
                'Privilege' => 'privilege',
                'Bridgestate' => 'bridge_state',
                'Bridgetype' => 'bridge_type',
                'Channel1' => 'channel_first',
                'Channel2' => 'channel_second',
                'CallerID1' => 'caller_id_first',
                'CallerID2' => 'caller_id_second',
                'UniqueID1' => 'unique_id_first',
                'UniqueID2' => 'unique_id_second',
            ],
        ],
        'CDR' => [
            'model' => CDR::class,
            'map' => [
                'Privilege' => 'privilege',
                'AccountCode' => 'account_code',
                'Source' => 'source',
                'Destination' => 'destination',
                'DestinationContext' => 'destination_context',
                'CallerID' => 'caller_id',
                'Channel' => 'channel',
                'DestinationChannel' => 'destination_channel',
                'LastApplication' => 'last_application',
                'LastData' => 'last_data',
                'StartTime' => 'start_time',
                'AnswerTime' => 'answer_time',
                'EndTime' => 'end_time',
                'Duration' => 'duration',
                'BillableSeconds' => 'billable_seconds',
                'Disposition' => 'disposition',
                'AMAFlags' => 'ama_flags',
                'UniqueID' => 'unique_id',
                'UserField' => 'user_field',
                'Rate' => 'rate',
                'Carrier' => 'carrier',
            ],
        ],
        'CEL' => [
            'model' => CEL::class,
            'map' => [
                'AMAFlags' => 'ama_flags',
                'AccountCode' => 'account_code',
                'AppData' => 'app_data',
                'Application' => 'application',
                'CallerIDani' => 'caller_id_ani',
                'CallerIDdnid' => 'caller_id_dnid',
                'CallerIDname' => 'caller_id_name',
                'CallerIDnum' => 'caller_id_num',
                'CallerIDrdnis' => 'caller_id_rdnis',
                'Channel' => 'channel',
                'Context' => 'context',
                'Event' => 'event',
                'EventName' => 'event_name',
                'EventTime' => 'event_time',
                'Exten' => 'exten',
                'Extra' => 'extra',
                'LinkedID' => 'linked_id',
                'Peer' => 'peer',
                'PeerAccount' => 'peer_account',
                'Privilege' => 'privilege',
                'Timestamp' => 'timestamp',
                'UniqueID' => 'unique_id',
                'Userfield' => 'user_field',
            ],
        ],
        'ChannelUpdate' => [
            'model' => ChannelUpdate::class,
            'map' => [
                'Privilege' => 'privilege',
                'Channel' => 'channel',
                'ChannelType' => 'channel_type',
                'SIPcallid' => 'sip_call_id',
                'SIPfullcontact' => 'sip_full_contact',
                'UniqueID' => 'unique_id',
            ],
        ],
        'CoreShowChannel' => [
            'model' => CoreShowChannel::class,
            'map' => [
                'Privilege' => 'privilege',
                'Channel' => 'channel',
                'UniqueID' => 'unique_id',
                'Context' => 'context',
                'Extension' => 'extension',
                'Priority' => 'priority',
                'ChannelState' => 'channel_state',
                'ChannelStateDesc' => 'channel_state_desc',
                'Application' => 'application',
                'ApplicationData' => 'application_data',
                'CallerIDNum' => 'caller_id_num',
                'Duration' => 'duration',
                'AccountCode' => 'account_code',
                'BridgedChannel' => 'bridged_channel',
                'BridgedUniqueID' => 'bridged_unique_id',
            ],
        ],
        'CoreShowChannelsComplete' => [
            'model' => CoreShowChannelsComplete::class,
            'map' => [
                'ListItems' => 'list_items',
            ],
        ],
        'DAHDIShowChannelsComplete' => [
            'model' => DAHDIShowChannelsComplete::class,
            'map' => [
                'items' => 'items',
            ],
        ],
        'DAHDIShowChannels' => [
            'model' => DAHDIShowChannels::class,
            'map' => [
                'Channel' => 'channel',
                'Signalling' => 'signalling',
                'SignallingCode' => 'signalling_code',
                'Context' => 'context',
                'DND' => 'dnd',
                'Alarm' => 'alarm',
            ],
        ],
        'DBGetResponse' => [
            'model' => DBGetResponse::class,
            'map' => [
                'Family' => 'family',
                'Key' => 'key',
                'Val' => 'val',
            ],
        ],
        'DTMF' => [
            'model' => DTMF::class,
            'map' => [
                'Privilege' => 'privilege',
                'Channel' => 'channel',
                'Digit' => 'digit',
                'Direction' => 'direction',
                'End' => 'end',
                'Begin' => 'begin',
                'UniqueID' => 'unique_id',
            ],
        ],
        'Dial' => [
            'model' => Dial::class,
            'map' => [
                'Privilege' => 'privilege',
                'SubEvent' => 'sub_event',
                'Channel' => 'channel',
                'Destination' => 'destination',
                'CallerIDNum' => 'caller_id_num',
                'CallerIDName' => 'caller_id_name',
                'UniqueID' => 'unique_id',
                'DestUniqueID' => 'dest_unique_id',
                'DialString' => 'dial_string',
                'DialStatus' => 'dial_status',
            ],
        ],
        'DongleDeviceEntry' => [
            'model' => DongleDeviceEntry::class,
            'map' => [
                'Device' => 'device',
                'AudioSetting' => 'audio_setting',
                'DataSetting' => 'data_setting',
                'IMEISetting' => 'imei_setting',
                'IMSISetting' => 'imsi_setting',
                'ChannelLanguage' => 'channel_language',
                'Context' => 'context',
                'Exten' => 'exten',
                'Group' => 'group',
                'RXGain' => 'rx_gain',
                'TXGain' => 'tx_gain',
                'U2DIAG' => 'u2diag',
                'UseCallingPres' => 'use_calling_pres',
                'DefaultCallingPres' => 'default_calling_pres',
                'AutoDeleteSMS' => 'auto_delete_sms',
                'DisableSMS' => 'disable_sms',
                'ResetDongle' => 'reset_dongle',
                'SMSPDU' => 'sms_pdu',
                'CallWaitingSetting' => 'call_waiting_setting',
                'DTMF' => 'dtmf',
                'MinimalDTMFGap' => 'minimal_dtmf_gap',
                'MinimalDTMFDuration' => 'minimal_dtmf_duration',
                'MinimalDTMFInterval' => 'minimal_dtmf_interval',
                'State' => 'state',
                'AudioState' => 'audio_state',
                'DataState' => 'data_state',
                'Voice' => 'voice',
                'SMS' => 'sms',
                'Manufacturer' => 'manufacturer',
                'Model' => 'model',
                'Firmware' => 'firmware',
                'IMEIState' => 'imei_state',
                'IMSIState' => 'imsi_state',
                'GSMRegistrationStatus' => 'gsm_registration_status',
                'RSSI' => 'rssi',
                'Mode' => 'mode',
                'Submode' => 'sub_mode',
                'ProviderName' => 'provider_name',
                'LocationAreaCode' => 'location_area_code',
                'CellID' => 'cell_id',
                'SubscriberNumber' => 'subscriber_number',
                'SMSServiceCenter' => 'sms_service_center',
                'UseUCS2Encoding' => 'use_ucs2_encoding',
                'USSDUse7BitEncoding' => 'ussd_use_7bit_encoding',
                'USSDUseUCS2Decoding' => 'ussd_use_ucs2_decoding',
                'TasksInQueue' => 'tasks_in_queue',
                'CommandsInQueue' => 'commands_in_queue',
                'CallWaitingState' => 'call_waiting_state',
                'CurrentDeviceState' => 'carrent_device_state',
                'DesiredDeviceState' => 'desired_device_state',
                'CallsChannels' => 'calls_channels',
                'Active' => 'active',
                'Held' => 'held',
                'Dialing' => 'dialing',
                'Alerting' => 'alerting',
                'Incoming' => 'incoming',
                'Waiting' => 'waiting',
                'Releasing' => 'releasing',
                'Initializing' => 'initializing',
            ],
        ],
        'DongleNewCUSD' => [
            'model' => DongleNewCUSD::class,
            'map' => [
                'Privilege' => 'privilege',
                'Device' => 'device',
                'Message' => 'message',
            ],
        ],
        'DongleNewUSSDBase64' => [
            'model' => DongleNewUSSDBase64::class,
            'map' => [
                'Privilege' => 'privilege',
                'Device' => 'device',
                'Message' => 'message',
            ],
        ],
        'DongleNewUSSD' => [
            'model' => DongleNewUSSD::class,
            'map' => [
                'Privilege' => 'privilege',
                'Device' => 'device',
                'LineCount' => 'line_count',
            ],
        ],
        'DongleSMSStatus' => [
            'model' => DongleSMSStatus::class,
            'map' => [
                'Privilege' => 'privilege',
                'Device' => 'device',
                'Id' => 'sms_id',
                'Status' => 'status',
            ],
        ],
        'DongleShowDevicesComplete' => [
            'model' => DongleShowDevicesComplete::class,
            'map' => [
                'listitems' => 'list_items',
            ],
        ],
        'DongleStatus' => [
            'model' => DongleStatus::class,
            'map' => [
                'Privilege' => 'privilege',
                'Device' => 'device',
                'Status' => 'status',
            ],
        ],
        'DongleUSSDStatus' => [
            'model' => DongleUSSDStatus::class,
            'map' => [
                'Privilege' => 'privilege',
                'Device' => 'device',
                'Id' => 'ussd_id',
                'Status' => 'status',
            ],
        ],
        'DonglePortFail' => [
            'model' => DonglePortFail::class,
            'map' => [
                'Privilege' => 'privilege',
                'Device' => 'device',
                'message' => 'message',
            ],
        ],
        'ExtensionStatus' => [
            'model' => ExtensionStatus::class,
            'map' => [
                'Privilege' => 'privilege',
                'Status' => 'status',
                'Exten' => 'extension',
                'Context' => 'context',
                'Hint' => 'hint',
            ],
        ],
        'FullyBooted' => [
            'model' => FullyBooted::class,
            'map' => [
                'Privilege' => 'privilege',
                'Status' => 'status',
            ],
        ],
        'Hangup' => [
            'model' => Hangup::class,
            'map' => [
                'Privilege' => 'privilege',
                'Channel' => 'channel',
                'CallerIDNum' => 'caller_id_num',
                'CallerIDName' => 'caller_id_name',
                'UniqueID' => 'unique_id',
                'Cause' => 'cause',
                'Cause-txt' => 'cause_text',
            ],
        ],
        'Hold' => [
            'model' => Hold::class,
            'map' => [
                'Privilege' => 'privilege',
                'Channel' => 'channel',
                'Status' => 'status',
                'UniqueID' => 'unique_id',
            ],
        ],
        'JabberEvent' => [
            'model' => JabberEvent::class,
            'map' => [
                'Privilege' => 'privilege',
                'Account' => 'account',
                'Packet' => 'packet',
            ],
        ],
        'Join' => [
            'model' => Join::class,
            'map' => [
                'Privilege' => 'privilege',
                'Channel' => 'channel',
                'Count' => 'count',
                'Queue' => 'queue',
                'Position' => 'position',
                'CallerIDNum' => 'caller_id_num',
                'CallerIDName' => 'caller_id_name',
                'ConnectedLineNum' => 'connected_line_num',
                'ConnectedLineName' => 'connected_line_name',
                'UniqueID' => 'unique_id',
            ],
        ],
        'Leave' => [
            'model' => Leave::class,
            'map' => [
                'Privilege' => 'privilege',
                'Channel' => 'channel',
                'Count' => 'count',
                'Queue' => 'queue',
                'UniqueID' => 'unique_id',
            ],
        ],
        'ListDialPlan' => [
            'model' => ListDialPlan::class,
            'map' => [
                'Context' => 'context',
                'Extension' => 'extension',
                'Priority' => 'priority',
                'Application' => 'application',
                'AppData' => 'app_data',
                'Registrar' => 'registrar',
                'IncludeContext' => 'include_context',
            ],
        ],
        'Masquerade' => [
            'model' => Masquerade::class,
            'map' => [
                'Privilege' => 'privilege',
                'Clone' => 'clone',
                'CloneState' => 'clone_state',
                'Original' => 'original',
                'OriginalState' => 'original_state',
            ],
        ],
        'MessageWaiting' => [
            'model' => MessageWaiting::class,
            'map' => [
                'Privilege' => 'privilege',
                'Mailbox' => 'mailbox',
                'Waiting' => 'waiting',
            ],
        ],
        'MusicOnHold' => [
            'model' => MusicOnHold::class,
            'map' => [
                'Privilege' => 'privilege',
                'Channel' => 'channel',
                'State' => 'state',
                'UniqueID' => 'unique_id',
            ],
        ],
        'NewAccountCode' => [
            'model' => NewAccountCode::class,
            'map' => [
                'Privilege' => 'privilege',
                'Channel' => 'channel',
                'UniqueID' => 'unique_id',
                'AccountCode' => 'account_code',
                'OldAccountCode' => 'old_account_code',
            ],
        ],
        'NewCallerid' => [
            'model' => NewCallerID::class,
            'map' => [
                'Privilege' => 'privilege',
                'Channel' => 'channel',
                'CallerIDNum' => 'caller_id_num',
                'CallerIDName' => 'caller_id_name',
                'UniqueID' => 'unique_id',
                'CID-CallingPres' => 'cid_calling_pres',
            ],
        ],
        'Newchannel' => [
            'model' => NewChannel::class,
            'map' => [
                'Privilege' => 'privilege',
                'Channel' => 'channel',
                'ChannelState' => 'channel_state',
                'ChannelStateDesc' => 'channel_state_desc',
                'CallerIDNum' => 'caller_id_num',
                'CallerIDName' => 'caller_id_name',
                'UniqueID' => 'unique_id',
                'AccountCode' => 'account_code',
                'Context' => 'context',
                'Exten' => 'extension',
            ],
        ],
        'Newexten' => [
            'model' => NewExtension::class,
            'map' => [
                'Privilege' => 'privilege',
                'Channel' => 'channel',
                'Extension' => 'extension',
                'Context' => 'context',
                'UniqueID' => 'unique_id',
                'Priority' => 'priority',
                'Application' => 'application',
                'AppData' => 'app_data',
            ],
        ],
        'Newstate' => [
            'model' => NewState::class,
            'map' => [
                'Privilege' => 'privilege',
                'Channel' => 'channel',
                'ChannelState' => 'channel_state',
                'ChannelStateDesc' => 'channel_state_desc',
                'CallerIDNum' => 'caller_id_num',
                'CallerIDName' => 'caller_id_name',
                'UniqueID' => 'unique_id',
                'ConnectedLineNum' => 'connected_line_num',
                'ConnectedLineName' => 'connected_line_name',
            ],
        ],
        'OriginateResponse' => [
            'model' => OriginateResponse::class,
            'map' => [
                'Privilege' => 'privilege',
                'Exten' => 'extension',
                'Channel' => 'channel',
                'Context' => 'context',
                'Reason' => 'reason',
                'UniqueID' => 'unique_id',
                'ActionID' => 'action_id',
                'Response' => 'response',
                'CallerIdNum' => 'caller_id_num',
                'CallerIdName' => 'caller_id_name',
            ],
        ],
        'ParkedCall' => [
            'model' => ParkedCall::class,
            'map' => [
                'Privilege' => 'privilege',
                'Parkinglot' => 'parking_lot',
                'From' => 'from',
                'Timeout' => 'timeout',
                'ConnectedLineNum' => 'connected_line_num',
                'ConnectedLineName' => 'connected_line_name',
                'Channel' => 'channel',
                'CallerIDNum' => 'caller_id_num',
                'CallerIDName' => 'caller_id_name',
                'UniqueID' => 'unique_id',
                'Exten' => 'extension',
            ],
        ],
        'ParkedCallsComplete' => [
            'model' => ParkedCallsComplete::class,
            'map' => [],
        ],
        'PeerEntry' => [
            'model' => PeerEntry::class,
            'map' => [
                'ChannelType' => 'channel_type',
                'ObjectName' => 'object_name',
                'ChanObjectType' => 'chan_object_type',
                'IPAddress' => 'ip_address',
                'IPPort' => 'ip_port',
                'Dynamic' => 'dynamic',
                'NatSupport' => 'nat_support',
                'VideoSupport' => 'video_support',
                'TextSupport' => 'text_support',
                'ACL' => 'acl',
                'Status' => 'status',
                'RealtimeDevice' => 'realtime_device',
            ],
        ],
        'PeerStatus' => [
            'model' => PeerStatus::class,
            'map' => [
                'ChannelType' => 'channel_type',
                'Privilege' => 'privilege',
                'Peer' => 'peer',
                'PeerStatus' => 'peer_status',
                'Address' => 'address',
            ],
        ],
        'PeerlistComplete' => [
            'model' => PeerListComplete::class,
            'map' => [
                'ListItems' => 'list_items',
            ],
        ],
        'QueueMemberAdded' => [
            'model' => QueueMemberAdded::class,
            'map' => [
                'Privilege' => 'privilege',
                'Queue' => 'queue',
                'Location' => 'location',
                'MemberName' => 'member_name',
                'Membership' => 'membership',
                'Penalty' => 'penalty',
                'CallsTaken' => 'calls_taken',
                'LastCall' => 'last_call',
                'Status' => 'status',
                'Paused' => 'paused',
            ],
        ],
        'QueueMember' => [
            'model' => QueueMember::class,
            'map' => [
                'Queue' => 'queue',
                'Location' => 'location',
                'Name' => 'name',
                'Membership' => 'membership',
                'Penalty' => 'penalty',
                'CallsTaken' => 'calls_taken',
                'Status' => 'status',
                'Paused' => 'paused',
            ],
        ],
        'QueueMemberPaused' => [
            'model' => QueueMemberPaused::class,
            'map' => [
                'Privilege' => 'privilege',
                'Queue' => 'queue',
                'Location' => 'location',
                'MemberName' => 'member_name',
                'Paused' => 'paused',
            ],
        ],
        'QueueMemberRemoved' => [
            'model' => QueueMemberRemoved::class,
            'map' => [
                'Privilege' => 'privilege',
                'Queue' => 'queue',
                'Location' => 'location',
                'MemberName' => 'member_name',
            ],
        ],
        'QueueMemberStatus' => [
            'model' => QueueMemberStatus::class,
            'map' => [
                'Privilege' => 'privilege',
                'Queue' => 'queue',
                'Location' => 'location',
                'MemberName' => 'member_name',
                'Membership' => 'membership',
                'Penalty' => 'penalty',
                'CallsTaken' => 'calls_taken',
                'Status' => 'status',
                'Paused' => 'paused',
            ],
        ],
        'QueueStatusComplete' => [
            'model' => QueueStatusComplete::class,
            'map' => [],
        ],
        'QueueSummaryComplete' => [
            'model' => QueueSummaryComplete::class,
            'map' => [],
        ],
        'QueueSummary' => [
            'model' => QueueSummary::class,
            'map' => [
                'Queue' => 'queue',
                'LoggedIn' => 'logged_in',
                'Available' => 'available',
                'Callers' => 'callers',
                'HoldTime' => 'hold_time',
                'LongestHoldTime' => 'longest_hold_time',
            ],
        ],
        'RTCPReceived' => [
            'model' => RTCPReceived::class,
            'map' => [
                'Privilege' => 'privilege',
                'From' => 'from',
                'PT' => 'pt',
                'ReceptionReports' => 'reception_reports',
                'SenderSSRC' => 'sender_ssrc',
                'FractionLost' => 'fraction_lost',
                'PacketsLost' => 'packets_lost',
                'HighestSequence' => 'highest_sequence',
                'SequenceNumberCycles' => 'sequence_number_cycles',
                'IAJitter' => 'ia_jitter',
                'LastSR' => 'last_sr',
                'DLSR' => 'dlsr',
                'RTT' => 'rtt',
            ],
        ],
        'RTCPReceiverStat' => [
            'model' => RTCPReceiverStat::class,
            'map' => [
                'Privilege' => 'privilege',
                'SSRC' => 'ssrc',
                'ReceivedPackets' => 'received_packets',
                'LostPackets' => 'lost_packets',
                'Jitter' => 'jitter',
                'Transit' => 'transit',
                'RRCount' => 'rr_count',
            ],
        ],
        'RTCPSent' => [
            'model' => RTCPSent::class,
            'map' => [
                'Privilege' => 'privilege',
                'To' => 'to',
                'OurSSRC' => 'our_ssrc',
                'SentNTP' => 'sent_ntp',
                'SentRTP' => 'sent_rtp',
                'SentPackets' => 'sent_packets',
                'SentOctets' => 'sent_octets',
                'ReportBlock' => 'report_block',
                'FractionLost' => 'fraction_lost',
                'CumulativeLoss' => 'cumulative_loss',
                'IAJitter' => 'ia_jitter',
                'TheirLastSR' => 'their_last_sr',
                'DLSR' => 'dlsr',
            ],
        ],
        'RTPReceiverStat' => [
            'model' => RTPReceiverStat::class,
            'map' => [
                'Privilege' => 'privilege',
                'SSRC' => 'ssrc',
                'ReceivedPackets' => 'received_packets',
                'LostPackets' => 'lost_packets',
                'Jitter' => 'jitter',
                'Transit' => 'transit',
                'RRCount' => 'rr_count',
            ],
        ],
        'RTPSenderStat' => [
            'model' => RTPSenderStat::class,
            'map' => [
                'Privilege' => 'privilege',
                'SSRC' => 'ssrc',
                'SentPackets' => 'sent_packets',
                'LostPackets' => 'lost_packets',
                'Jitter' => 'jitter',
                'RTT' => 'rtt',
                'SRCount' => 'sr_count',
            ],
        ],
        'RegistrationsComplete' => [
            'model' => RegistrationsComplete::class,
            'map' => [
                'ListItems' => 'list_items',
            ],
        ],
        'Registry' => [
            'model' => Registry::class,
            'map' => [
                'Privilege' => 'privilege',
                'ChannelType' => 'channel_type',
                'Username' => 'username',
                'Domain' => 'domain',
                'Status' => 'status',
            ],
        ],
        'Rename' => [
            'model' => Rename::class,
            'map' => [
                'Privilege' => 'privilege',
                'Channel' => 'channel',
                'Oldname' => 'old_name',
                'Newname' => 'new_name',
                'UniqueID' => 'unique_id',
            ],
        ],
        'ShowDialPlanComplete' => [
            'model' => ShowDialPlanComplete::class,
            'map' => [
                'Privilege' => 'privilege',
                'listitems' => 'list_items',
                'listextensions' => 'list_extensions',
                'listpriorities' => 'list_priorities',
                'listcontexts' => 'list_contexts',
            ],
        ],
        'StatusComplete' => [
            'model' => StatusComplete::class,
            'map' => [
                'Items' => 'items',
            ],
        ],
        'Status' => [
            'model' => Status::class,
            'map' => [
                'BridgedUniqueID' => 'bridged_unique_id',
                'Privilege' => 'privilege',
                'Channel' => 'channel',
                'Context' => 'context',
                'Extension' => 'extension',
                'UniqueID' => 'unique_id',
                'Priority' => 'priority',
                'ChannelState' => 'channel_state',
                'ChannelStateDesc' => 'channel_state_desc',
                'Application' => 'application',
                'ApplicationData' => 'application_data',
                'CallerIDNum' => 'caller_id_num',
                'Duration' => 'duration',
                'AccountCode' => 'account_code',
                'Seconds' => 'seconds',
                'BridgedChannel' => 'bridged_channel',
            ],
        ],
        'Transfer' => [
            'model' => Transfer::class,
            'map' => [
                'Privilege' => 'privilege',
                'Channel' => 'channel',
                'TransferMethod' => 'transfer_method',
                'TransferType' => 'transfer_type',
                'TargetChannel' => 'target_channel',
                'SIP-Callid' => 'sip_call_id',
                'UniqueID' => 'unique_id',
                'TargetUniqueid' => 'target_unique_id',
                'TransferExten' => 'transfer_extension',
                'TransferContext' => 'transfer_context',
            ],
        ],
        'UnParkedCall' => [
            'model' => UnParkedCall::class,
            'map' => [
                'Privilege' => 'privilege',
                'Parkinglot' => 'parking_lot',
                'From' => 'from',
                'ConnectedLineNum' => 'connected_line_num',
                'ConnectedLineName' => 'connected_line_name',
                'Channel' => 'channel',
                'CallerIDNum' => 'caller_id_num',
                'CallerIDName' => 'caller_id_name',
                'UniqueID' => 'unique_id',
                'Exten' => 'extension',
            ],
        ],
        'Unlink' => [
            'model' => UnLink::class,
            'map' => [
                'Privilege' => 'privilege',
                'Channel1' => 'channel_first',
                'Channel2' => 'channel_second',
                'CallerID1' => 'caller_id_first',
                'CallerID2' => 'caller_id_second',
                'UniqueID1' => 'unique_id_first',
                'UniqueID2' => 'unique_id_second',
            ],
        ],
        'UserEvent' => [
            'model' => UserEvent::class,
            'map' => [
                'Privilege' => 'privilege',
                'UniqueID' => 'unique_id',
                'UserEvent' => 'user_event',
            ],
        ],
        'VarSet' => [
            'model' => VarSet::class,
            'map' => [
                'Privilege' => 'privilege',
                'UniqueID' => 'unique_id',
                'Channel' => 'channel',
                'Variable' => 'variable',
                'Value' => 'value',
            ],
        ],
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
     * Save event data.
     *
     * @param Event  $event
     * @param string $modelClass
     * @param array  $map
     */
    protected function save(Event $event, $modelClass, array $map = [])
    {
        $model = new $modelClass(self::params($event, $map));
        if (!($model instanceof Model)) {
            throw new \Exception('Model for event '.$event->getName().' must be instance of '.Model::class.'.');
        }
        $model->save();
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param Illuminate\Events\Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        foreach (self::$events as $event => $options) {
            $events->listen('ami.events.'.$event, function (Event $event, array $customOptions = []) use ($options) {
                $options = array_merge($options, $customOptions);
                $logging = array_key_exists('logging', $options) ? $options['logging'] : false;
                if ($logging) {
                    self::save($event, $options['model'], $options['map']);
                }
            });
        }
    }
}
