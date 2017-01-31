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
            ],
            'AgentConnect' => [
            ],
            'AgentComplete' => [
            ],
            'Agentlogin' => [
            ],
            'Agentlogoff' => [
            ],
            'Agents' => [
            ],
            'AsyncAGI' => [
            ],
            'Bridge' => [
            ],
            'CDR' => [
            ],
            'CEL' => [
            ],
            'ChannelUpdate' => [
            ],
            'CoreShowChannel' => [
            ],
            'CoreShowChannelsComplete' => [
            ],
            'DAHDIShowChannelsComplete' => [
            ],
            'DAHDIShowChannels' => [
            ],
            'DBGetResponse' => [
            ],
            'DTMF' => [
            ],
            'Dial' => [
            ],
            'DongleDeviceEntry' => [
            ],
            'DongleNewCUSD' => [
            ],
            'DongleNewUSSDBase64' => [
            ],
            'DongleNewUSSD' => [
            ],
            'DongleSMSStatus' => [
            ],
            'DongleShowDevicesComplete' => [
            ],
            'DongleStatus' => [
            ],
            'DongleUSSDStatus' => [
            ],
            'DonglePortFail' => [
            ],
            'ExtensionStatus' => [
            ],
            'FullyBooted' => [
            ],
            'Hangup' => [
            ],
            'Hold' => [
            ],
            'JabberEvent' => [
            ],
            'Join' => [
            ],
            'Leave' => [
            ],
            'Link' => [
            ],
            'ListDialPlan' => [
            ],
            'Masquerade' => [
            ],
            'MessageWaiting' => [
            ],
            'MusicOnHold' => [
            ],
            'NewAccountCode' => [
            ],
            'NewCallerid' => [
            ],
            'Newchannel' => [
            ],
            'Newexten' => [
            ],
            'Newstate' => [
            ],
            'OriginateResponse' => [
            ],
            'ParkedCall' => [
            ],
            'ParkedCallsComplete' => [
            ],
            'PeerEntry' => [
            ],
            'PeerStatus' => [
            ],
            'PeerlistComplete' => [
            ],
            'QueueMemberAdded' => [
            ],
            'QueueMember' => [
            ],
            'QueueMemberPaused' => [
            ],
            'QueueMemberRemoved' => [
            ],
            'QueueMemberStatus' => [
            ],
            'QueueParams' => [
            ],
            'QueueStatusComplete' => [
            ],
            'QueueSummaryComplete' => [
            ],
            'QueueSummary' => [
            ],
            'RTCPReceived' => [
            ],
            'RTCPReceiverStat' => [
            ],
            'RTCPSent' => [
            ],
            'RTPReceiverStat' => [
            ],
            'RTPSenderStat' => [
            ],
            'RegistrationsComplete' => [
            ],
            'Registry' => [
            ],
            'Rename' => [
            ],
            'ShowDialPlanComplete' => [
            ],
            'StatusComplete' => [
            ],
            'Status' => [
            ],
            'Transfer' => [
            ],
            'UnParkedCall' => [
            ],
            'Unlink' => [
            ],
            'UserEvent' => [
            ],
            'VarSet' => [
            ],
        ];
        foreach ($events as $event => $params) {
            $params = array_merge($params, [
                'logging' => true,
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
