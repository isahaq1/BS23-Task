<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MockResponseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_mock_success_response()
    {
        $response = $this->withHeaders([
            'x-mock-status' => 'success',
        ])->get('/api/mockresponse-approved');

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Mock response for success']);
    }

    public function test_mock_fail_response()
    {
        $response = $this->withHeaders([
            'x-mock-status' => 'fail',
        ])->get('/api/mockresponse-failed');

         $response->assertStatus(400);
        $response->assertJson(['message' => 'Mock response for failure']);
    }
}
