<?php

namespace Enniel\AmiLog\Tests;

use Enniel\AmiLog\Models\AgentComplete;
use Enniel\AmiLog\Models\AgentConnect;
use Enniel\AmiLog\Models\Bridge;
use Enniel\AmiLog\Models\CDR;
use Enniel\AmiLog\Models\Dial;
use Enniel\AmiLog\Models\FullyBooted;
use Enniel\AmiLog\Models\Join;
use Enniel\AmiLog\Models\Link;

class EventTest extends TestCase
{
    public function testEvents()
    {
        $messages = [
            [
                'Event'          => 'AgentConnect',
                'Privilege'      => 'agent,all',
                'Queue'          => 'taxi-operators',
                'Uniqueid'       => '1321511811.113',
                'Channel'        => 'SIP/100-00000072',
                'Member'         => 'SIP/100',
                'MemberName'     => 'SIP/100',
                'Holdtime'       => '10',
                'BridgedChannel' => '1321511815.114',
                'Ringtime'       => '9',
            ],
            [
                'Event'      => 'AgentComplete',
                'Privilege'  => 'agent,all',
                'Queue'      => 'taxi-operators',
                'Uniqueid'   => '1321511811.113',
                'Channel'    => 'SIP/100-00000072',
                'Member'     => 'SIP/100',
                'MemberName' => 'SIP/100',
                'HoldTime'   => '10',
                'TalkTime'   => '7',
                'Reason'     => 'caller',
            ],
            [
                'Event'              => 'CDR',
                'Privilege'          => 'cdr,all',
                'AccountCode'        => '',
                'Source'             => '',
                'Destination'        => '177',
                'DestinationContext' => 'test',
                'CallerID'           => '',
                'Channel'            => 'Console/dsp',
                'DestinationChannel' => '',
                'LastApplication'    => 'Hangup',
                'LastData'           => '',
                'StartTime'          => '2014-05-23 08:29:21',
                'AnswerTime'         => '2014-05-23 08:29:21',
                'EndTime'            => '2014-08-25 08:29:21',
                'Duration'           => '0',
                'BillableSeconds'    => '0',
                'Disposition'        => 'ANSWERED',
                'AMAFlags'           => 'DOCUMENTATION',
                'UniqueID'           => '1383680051.3',
                'UserField'          => '',
                'Rate'               => '0.03',
                'Carrier'            => 'BВ&С',
            ],
            [
                'Event'       => 'Bridge',
                'Privilege'   => 'call,all',
                'Bridgestate' => 'Link',
                'Bridgetype'  => 'core',
                'Channel1'    => 'SIP/mangotrunk-0000016c',
                'Channel2'    => 'SIP/261-0000016d',
                'Uniqueid1'   => '1324068645.605',
                'Uniqueid2'   => '1324068650.606',
                'Callerid1'   => '74997623634',
                'Callerid2'   => '261',
            ],
            [
                'Event'        => 'Dial',
                'Privilege'    => 'call,all',
                'Subevent'     => 'Begin',
                'Channel'      => 'SIP/mangotrunk-0000016c',
                'Destination'  => 'SIP/261-0000016d',
                'Calleridnum'  => '74997623634',
                'Calleridname' => '74997623634',
                'Uniqueid'     => '1324068645.605',
                'Destuniqueid' => '1324068650.606',
                'Dialstring'   => '261',
                'DialStatus'   => 'CONGESTION',
            ],
            [
                'Event'     => 'FullyBooted',
                'Privilege' => 'system,all',
                'Status'    => 'Fully Booted',
            ],
            [
                'Event'             => 'Join',
                'Privilege'         => 'call,all',
                'Channel'           => 'SIP/multifon-out-00000071',
                'CallerIDNum'       => '79265224173',
                'CallerIDName'      => 'unknown',
                'ConnectedLineNum'  => 'unknown',
                'ConnectedLineName' => 'unknown',
                'Queue'             => 'taxi-operators',
                'Position'          => '1',
                'Count'             => '1',
                'Uniqueid'          => '1321511811.113',
            ],
        ];
        $this->events->listen('ami.listen.started', function () use ($messages) {
            $this->assertTrue(true);
            $this->stream->emit('data', ["Asterisk Call Manager/1.3\r\n"]);
            foreach ($messages as $lines) {
                $message = '';
                foreach ($lines as $key => $value) {
                    $message .= "{$key}: {$value}\r\n";
                }
                $this->stream->emit('data', ["{$message}\r\n"]);
            }
        });
        AgentConnect::created(function ($model) {
            $this->assertEquals($this->getModelAttribues($model), [
                'privilege'       => 'agent,all',
                'queue'           => 'taxi-operators',
                'unique_id'       => '1321511811.113',
                'channel'         => 'SIP/100-00000072',
                'member'          => 'SIP/100',
                'member_name'     => 'SIP/100',
                'hold_time'       => '10',
                'bridged_channel' => '1321511815.114',
                'ring_time'       => '9',
            ]);
        });
        AgentComplete::created(function ($model) {
            $this->assertEquals($this->getModelAttribues($model), [
                'privilege'   => 'agent,all',
                'queue'       => 'taxi-operators',
                'unique_id'   => '1321511811.113',
                'channel'     => 'SIP/100-00000072',
                'member'      => 'SIP/100',
                'member_name' => 'SIP/100',
                'hold_time'   => '10',
                'talk_time'   => '7',
                'reason'      => 'caller',
            ]);
        });
        CDR::created(function ($model) {
            $this->assertEquals($this->getModelAttribues($model), [
                'privilege'           => 'cdr,all',
                'account_code'        => '',
                'source'              => '',
                'destination'         => '177',
                'destination_context' => 'test',
                'caller_id'           => '',
                'channel'             => 'Console/dsp',
                'destination_channel' => '',
                'last_application'    => 'Hangup',
                'last_data'           => '',
                'start_time'          => '2014-05-23 08:29:21',
                'answer_time'         => '2014-05-23 08:29:21',
                'end_time'            => '2014-08-25 08:29:21',
                'duration'            => '0',
                'billable_seconds'    => '0',
                'disposition'         => 'ANSWERED',
                'ama_flags'           => 'DOCUMENTATION',
                'unique_id'           => '1383680051.3',
                'user_field'          => '',
                'rate'                => '0.03',
                'carrier'             => 'BВ&С',
            ]);
        });
        Bridge::created(function ($model) {
            $this->assertEquals($this->getModelAttribues($model), [
                'privilege'        => 'call,all',
                'bridge_state'     => 'Link',
                'bridge_type'      => 'core',
                'channel_first'    => 'SIP/mangotrunk-0000016c',
                'channel_second'   => 'SIP/261-0000016d',
                'unique_id_first'  => '1324068645.605',
                'unique_id_second' => '1324068650.606',
                'caller_id_first'  => '74997623634',
                'caller_id_second' => '261',
            ]);
        });
        Dial::created(function ($model) {
            $this->assertEquals($this->getModelAttribues($model), [
                'privilege'      => 'call,all',
                'sub_event'      => 'Begin',
                'channel'        => 'SIP/mangotrunk-0000016c',
                'destination'    => 'SIP/261-0000016d',
                'caller_id_num'  => '74997623634',
                'caller_id_name' => '74997623634',
                'unique_id'      => '1324068645.605',
                'dest_unique_id' => '1324068650.606',
                'dial_string'    => '261',
                'dial_status'    => 'CONGESTION',
            ]);
        });
        FullyBooted::created(function ($model) {
            $this->assertEquals($this->getModelAttribues($model), [
                'privilege' => 'system,all',
                'status'    => 'Fully Booted',
            ]);
        });
        Join::created(function ($model) {
            $this->assertEquals($this->getModelAttribues($model), [
                'privilege'           => 'call,all',
                'channel'             => 'SIP/multifon-out-00000071',
                'caller_id_num'       => '79265224173',
                'caller_id_name'      => 'unknown',
                'connected_line_num'  => 'unknown',
                'connected_line_name' => 'unknown',
                'queue'               => 'taxi-operators',
                'position'            => '1',
                'count'               => '1',
                'unique_id'           => '1321511811.113',
            ]);
            $this->running = false;
        });
        $this->running = true;
        $this->artisan('ami:listen');
    }
}
