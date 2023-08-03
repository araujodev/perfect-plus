<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes, Uuid;

    protected $table = 'invoices';

    protected $fillable = [
        'type',
        'value',
        'due_date',
        'customer_id',
        'pay_id',
        'status',
        'url'
    ];

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
