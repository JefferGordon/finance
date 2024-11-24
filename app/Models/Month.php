<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    // En el modelo Month
    public function transactions()
    {
    return $this->hasMany(Transaction::class);
    }

}
