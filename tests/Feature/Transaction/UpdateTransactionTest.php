<?php

namespace Tests\Feature\Transaction;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_transaction_by_user()
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create();

        $requestData = [
            'amount' => 100.00,
            'type' => 'expense',
            'description' => 'Test transaction',
        ];

        $response = $this->actingAs($user)->put('/api/update-transaction/'.$transaction->id, $requestData);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('transaction', $requestData);
    }
}
