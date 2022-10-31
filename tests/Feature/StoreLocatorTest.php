<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class StoreLocatorTest extends TestCase
{
    use LazilyRefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_locator_route_renders()
    {
        $response = $this->get(route('store-locator'));

        $response->assertStatus(200);
    }

    public function test_store_locator_route_renders_vue_component()
    {
        $this->get(route('store-locator'))
            ->assertInertia(fn (Assert $page) => $page
                ->component('StoreLocator')
            );
    }
}
