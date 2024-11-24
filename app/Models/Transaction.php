<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['transaction_type_id', 'month_id','year', 'amount', 'description','empresa_id', 'transaction_date'];

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function month()
    {
        return $this->belongsTo(Month::class);
    }
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
    protected $casts = [
        'year' => 'integer',
    ];
}
