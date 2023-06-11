<?php

namespace Tests\Feature\Transaction;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DeleteTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_transaction_by_user(): void
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create();

        $response = $this->actingAs($user)->delete('/api/delete-transaction/' . $transaction->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('transaction', $transaction->toArray());
    }
}
