<?php

namespace App\Models;

use App\Http\TransactionType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';
    protected $fillable = [
        'type',
        'description',
        'amount',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y',
    ];

    public function filterByType($type): array|Collection
    {
        return $this->query()
            ->where('type', $type)
            ->where('user_id', Auth::user()->id)
            ->get();
    }
}
