<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;

class TransactionController extends Controller
{
    public function __construct(private readonly Transaction $model)
    {
    }

    public function index(): JsonResponse
    {
        try {
            $transactions = $this->model->getTransactions();

            return new JsonResponse(
                $transactions,
                200
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                ['message' => $e->getMessage()],
                500
            );
        }
    }

    public function show(Transaction $transaction): JsonResponse
    {
        return new JsonResponse(
            $transaction,
            200
        );
    }

    public function store(TransactionRequest $request, Transaction $model): JsonResponse
    {
        try {
            $transaction = $request->validated();
            $model->create($transaction);

            return new JsonResponse($transaction, ResponseStatus::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), ResponseStatus::HTTP_NOT_FOUND);
        }
    }

    public function update(TransactionRequest $request, Transaction $transaction): JsonResponse
    {
        try {
            $transactionValidated = $request->validated();
            $updatedTransaction = $transaction->update($transactionValidated);

            return new JsonResponse($updatedTransaction, ResponseStatus::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), ResponseStatus::HTTP_NOT_FOUND);
        }
    }

    public function destroy(Transaction $transaction): JsonResponse
    {
        try {
            $transaction->delete();

            return new JsonResponse('', ResponseStatus::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), ResponseStatus::HTTP_NOT_FOUND);
        }
    }
}
