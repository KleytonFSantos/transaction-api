<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;

class TransactionController extends Controller
{
    public function __construct(private readonly Transaction $model)
    {
    }
    public function index(User $user): JsonResponse
    {
        try {
            $transactions = Auth::user()->transaction()->get();

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

    public function filterByType($type): JsonResponse
    {
        try {
            $expenses = $this->model->filterByType($type);

            return new JsonResponse($expenses, ResponseStatus::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), ResponseStatus::HTTP_NOT_FOUND);
        }
    }
}
