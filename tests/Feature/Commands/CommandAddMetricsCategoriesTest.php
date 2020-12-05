<?php

namespace Tests\Feature\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommandAddMetricsCategoriesTest extends TestCase
{
    /**
     * @return void
     */
    public function testAddMetricsCategoriesCommand()
    {
        $this->artisan('category:metric')
            ->expectsOutput(trans('messages.crud', [
                'resource' => trans('fields.metrics'),
                'status' => trans('fields.updated')
            ]))
            ->assertExitCode(0);
    }
}
