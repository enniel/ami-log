<?php

namespace Enniel\AmiLog\Tests;

use Orchestra\Database\MigrationServiceProvider;
use Enniel\AmiLog\AmiLogServiceProvider;
use React\EventLoop\LoopInterface;
use React\Stream\Stream;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @var \React\EventLoop\LoopInterface
     */
    protected $loop;

    /**
     * @var \React\Stream\Stream
     */
    protected $stream;

    /**
     * @var bool
     */
    protected $running;

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;

    protected function getPackageProviders($app)
    {
        return [
            AmiLogServiceProvider::class,
            AmiServiceProvider::class,
            MigrationServiceProvider::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();
        $this->loop = $this->app[LoopInterface::class];
        $this->events = $this->app['events'];
        $this->loop->nextTick(function () {
            if (!$this->running) {
                $this->loop->stop();
            }
        });
        $this->stream = $this->app[Stream::class];
        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--realpath' => __DIR__.'/../database/migrations',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $events = [
            'AGIExec' => [
                'handler' => 'agi_exec',
            ],
            'AgentConnect' => [
                'handler' => 'agent_connect',
            ],
            'AgentComplete' => [
                'handler' => 'agent_complete',
            ],
            'Agentlogin' => [
                'handler' => 'agent_login',
            ],
            'Agentlogoff' => [
                'handler' => 'agent_logoff',
            ],
            'Agents' => [
                'handler' => 'agents',
            ],
            'AsyncAGI' => [
                'handler' => 'async_agi',
            ],
            'Bridge' => [
                'handler' => 'bridge',
            ],
            'CDR' => [
                'handler' => 'cdr',
            ],
            'CEL' => [
                'handler' => 'cel',
            ],
            'ChannelUpdate' => [
                'handler' => 'channel_update',
            ],
            'CoreShowChannel' => [
                'handler' => 'core_show_channel',
            ],
            'CoreShowChannelsComplete' => [
                'handler' => 'core_show_channels_complete',
            ],
            'DAHDIShowChannelsComplete' => [
                'handler' => 'dahdi_show_channels_complete',
            ],
            'DAHDIShowChannels' => [
                'handler' => 'dahdi_show_channels',
            ],
            'DBGetResponse' => [
                'handler' => 'db_get_response',
            ],
            'DTMF' => [
                'handler' => 'dtmf',
            ],
            'Dial' => [
                'handler' => 'dial',
            ],
            'DongleDeviceEntry' => [
                'handler' => 'dongle_device_entry',
            ],
            'DongleNewCUSD' => [
                'handler' => 'dongle_new_cusd',
            ],
            'DongleNewUSSDBase64' => [
                'handler' => 'dongle_new_ussd_base64',
            ],
            'DongleNewUSSD' => [
                'handler' => 'dongle_new_ussd',
            ],
            'DonglePortFail' => [
                'handler' => 'dongle_port_fail',
            ],
            'DongleSMSStatus' => [
                'handler' => 'dongle_sms_status',
            ],
            'DongleShowDevicesComplete' => [
                'handler' => 'dongle_show_devices_complete',
            ],
            'DongleStatus' => [
                'handler' => 'dongle_status',
            ],
            'DongleUSSDStatus' => [
                'handler' => 'dongle_ussd_status',
            ],
            'ExtensionStatus' => [
                'handler' => 'extension_status',
            ],
            'FullyBooted' => [
                'handler' => 'fully_booted',
            ],
            'Hangup' => [
                'handler' => 'hangup',
            ],
            'Hold' => [
                'handler' => 'hold',
            ],
            'JabberEvent' => [
                'handler' => 'jabber',
            ],
            'Join' => [
                'handler' => 'join',
            ],
            'Leave' => [
                'handler' => 'leave',
            ],
            'Link' => [
                'handler' => 'link',
            ],
            'ListDialPlan' => [
                'handler' => 'list_dial_plan',
            ],
            'Masquerade' => [
                'handler' => 'masquerade',
            ],
            'MessageWaiting' => [
                'handler' => 'message_waiting',
            ],
            'MusicOnHold' => [
                'handler' => 'music_on_hold',
            ],
            'NewAccountCode' => [
                'handler' => 'new_account_code',
            ],
            'NewCallerid' => [
                'handler' => 'new_caller_id',
            ],
            'Newchannel' => [
                'handler' => 'new_channel',
            ],
            'Newexten' => [
                'handler' => 'new_extension',
            ],
            'Newstate' => [
                'handler' => 'new_state',
            ],
            'OriginateResponse' => [
                'handler' => 'originate_response',
            ],
            'ParkedCall' => [
                'handler' => 'parked_call',
            ],
            'ParkedCallsComplete' => [
                'handler' => 'parked_calls_complete',
            ],
            'PeerEntry' => [
                'handler' => 'peer_entry',
            ],
            'PeerStatus' => [
                'handler' => 'peer_status',
            ],
            'PeerlistComplete' => [
                'handler' => 'peer_list_complete',
            ],
            'QueueMemberAdded' => [
                'handler' => 'queue_member_added',
            ],
            'QueueMember' => [
                'handler' => 'queue_member',
            ],
            'QueueMemberPaused' => [
                'handler' => 'queue_member_paused',
            ],
            'QueueMemberRemoved' => [
                'handler' => 'queue_member_removed',
            ],
            'QueueMemberStatus' => [
                'handler' => 'queue_member_status',
            ],
            'QueueParams' => [
                'handler' => 'queue_params',
            ],
            'QueueStatusComplete' => [
                'handler' => 'queue_status_complete',
            ],
            'QueueSummaryComplete' => [
                'handler' => 'queue_summary_complete',
            ],
            'QueueSummary' => [
                'handler' => 'queue_summary',
            ],
            'RTCPReceived' => [
                'handler' => 'rtcp_received',
            ],
            'RTCPReceiverStat' => [
                'handler' => 'rtcp_receiver_stat',
            ],
            'RTCPSent' => [
                'handler' => 'rtcp_sent',
            ],
            'RTPReceiverStat' => [
                'handler' => 'rtp_receiver_stat',
            ],
            'RTPSenderStat' => [
                'handler' => 'rtp_sender_stat',
            ],
            'RegistrationsComplete' => [
                'handler' => 'registrations_complete',
            ],
            'Registry' => [
                'handler' => 'registry',
            ],
            'Rename' => [
                'handler' => 'rename',
            ],
            'ShowDialPlanComplete' => [
                'handler' => 'show_dial_plan_complete',
            ],
            'StatusComplete' => [
                'handler' => 'status_complete',
            ],
            'Status' => [
                'handler' => 'status',
            ],
            'Transfer' => [
                'handler' => 'transfer',
            ],
            'UnParkedCall' => [
                'handler' => 'unparked_call',
            ],
            'Unlink' => [
                'handler' => 'unlink',
            ],
            'UserEvent' => [
                'handler' => 'user_event',
            ],
            'VarSet' => [
                'handler' => 'var_set',
            ],
        ];
        foreach ($events as $event => $params) {
            $params = array_merge($params, [
                'options' => [
                    'logging' => true,
                ],
            ]);
            $events[$event] = $params;
        }
        $app['config']->set('ami.events', $events);
    }

    /**
     * Get model attributes.
     */
    protected function getModelAttribues($model)
    {
        $keys = $model->getFillable();

        return array_intersect_key($model->toArray(), array_flip((array) $keys));
    }
}
