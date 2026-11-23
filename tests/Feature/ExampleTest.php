<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase; // Import RefreshDatabase trait
use Tests\TestCase; // Import base TestCase

class ExampleTest extends TestCase { // Feature test for homepage
    use RefreshDatabase; // Run migrations on in-memory database
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
