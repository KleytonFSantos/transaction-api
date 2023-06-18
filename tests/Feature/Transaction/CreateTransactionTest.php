<?php

namespace Tests\Feature\Transaction;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
class CreateTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_transaction_by_user(): void
    {
        $user = User::factory()->create();

        $requestData = [
            'amount' => 100.00,
            'type' => 'expense',
            'description' => 'Test transaction',
        ];

        $response = $this->actingAs($user)->post('/api/add-transaction', $requestData);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson($requestData);

        $this->assertDatabaseHas('transaction', $requestData);
    }
}
