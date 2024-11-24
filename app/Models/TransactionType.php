<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function month()
    {
        return $this->belongsTo(Month::class);
    }
}
