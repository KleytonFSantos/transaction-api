<?php

namespace App\Http;

enum TransactionType: string
{
    case EXPENSE = 'expense';
    case INCOME = 'income';
}
