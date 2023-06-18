<?php

namespace Tests\Feature\Transaction;

use App\Models\Transaction;
use App\Models\User;
use Tests\TestCase;

class FilterTransactionByTypeTest extends TestCase
{
    public function test_get_transactions_by_user(): void
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory(10)->create();

        $response = $this->actingAs($user)->get('api/transactions/expense');

        $response->assertStatus(200);
        $response->assertJson([]);
    }
}
