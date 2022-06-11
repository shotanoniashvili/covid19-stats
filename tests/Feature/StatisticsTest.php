<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatisticsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCountryDataLoadsSuccessfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->json('GET', 'api/countries')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'code',
                        'name',
                        'latest_statistics' => [
                            'confirmed',
                            'recovered',
                            'death'
                        ]
                    ]
                ]
            ]);
        $user->delete();
    }

    public function testSummaryLoadsSuccessfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->json('GET', 'api/summary')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'confirmed',
                    'recovered',
                    'death',
                ]
            ]);
        $user->delete();
    }
}
