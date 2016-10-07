<?php

namespace Enniel\AmiLog\Tests;

use Enniel\AmiLog\AmiLogServiceProvider;
use React\EventLoop\LoopInterface;
use Illuminate\Support\Arr;
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
     * @var boolean
     */
    protected $running;

    //
    protected function getPackageProviders($app)
    {
        return [
            AmiLogServiceProvider::class,
            AmiServiceProvider::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->loop   = $this->app[LoopInterface::class];
        $this->loop->nextTick(function () {
            if (! $this->running) {
                $this->loop->stop();
            }
        });
        $this->stream = $this->app[Stream::class];
        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__.'/../database/migrations'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $events = $app['config']['ami.events'];
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
     * Get model attributes
     */
    protected function getModelAttribues($model)
    {
        $keys = $model->getFillable();
        return Arr::only($model->toArray(), $keys);
    }
}
