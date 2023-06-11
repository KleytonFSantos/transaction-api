<?php

namespace Tests\Feature\Transaction;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetTransactionsByUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_transactions_by_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/api/transactions');

        $response->assertStatus(200);
        $response->assertJson([]);
    }
}
