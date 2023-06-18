<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function getTransactions()
    {
        return Auth::user()->transaction()
            ->when(request('description') && request('description') !== 'undefined', function ($query) {
                $query->where('description', 'LIKE', '%'.request('description').'%');
            })
            ->when(request('type'), function ($query) {
                $query->where('type', request('type'));
            })
            ->when(request('dateFrom') && request('dateTo'), function ($query) {
                $dateFrom = Carbon::createFromFormat('Y-m-d', request('dateFrom'))->startOfDay()->format('Y-m-d H:i:s');
                $dateTo = Carbon::createFromFormat('Y-m-d', request('dateTo'))->endOfDay()->format('Y-m-d H:i:s');
                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->when(request('orderBy') && ! request('orderTo'), function ($query) {
                $query->orderBy(request('orderBy'), 'desc');
            })
            ->when(request('orderBy') && request('orderTo'), function ($query) {
                $query->orderBy(request('orderBy'), request('orderTo'));
            })
            ->get();
    }
}
