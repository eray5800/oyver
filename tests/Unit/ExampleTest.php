<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */


     public function test_control_controly()
{
    $user = User::find(1);
    $this->actingAs($user);

    $response = $this->post('/vote/save', [
        'option' => 14,
    ]); 

    $response->assertStatus(200);
}

     
}

