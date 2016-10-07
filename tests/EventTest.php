<?php

namespace Enniel\AmiLog\Tests;

use Illuminate\Support\Facades\Event as Emitter;
use Illuminate\Support\Arr;
use Clue\React\Ami\Protocol\Event;
use React\Stream\Stream;
use Enniel\AmiLog\Models\AgentConnect;
use Enniel\AmiLog\Models\AgentComplete;
use Enniel\AmiLog\Models\Bridge;
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
        Emitter::listen('ami.listen.started', function () use ($messages) {
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
