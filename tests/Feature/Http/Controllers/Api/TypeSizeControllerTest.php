<?php

namespace Tests\Feature\Http\Controllers\Api;

use Tests\TestCase;

class TypeSizeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex(): void
    {
        $response = $this->get(route('api.type_sizes.index'));

        $response->assertStatus(200);
    }
}
