<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes, Uuid;

    protected $table = 'customers';

    protected $fillable = [
        'full_name',
        'document',
        'phone',
        'cus_id'
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
