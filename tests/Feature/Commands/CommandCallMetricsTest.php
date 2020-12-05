<?php

namespace Tests\Feature\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommandCallMetricsTest extends TestCase
{
    /**
     * Test callMetrics command
     *
     * @return void
     */
    public function testCallMetricsCommand()
    {
        $this->artisan('metrics:start')
            ->expectsOutput(trans('messages.crud', [
                'resource' => trans('fields.metrics'),
                'status' => trans('fields.updated')
            ]))
            ->assertExitCode(0);
    }
}
