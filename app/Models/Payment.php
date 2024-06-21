<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 'total_amount', 'date', 'narration','createdBy','approvedBy','status'
    ];

    public function details()
    {
        return $this->hasMany(PaymentDetails::class, 'transaction_id', 'transaction_id');
    }
}
