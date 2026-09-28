<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;

class Student extends Model
{
    protected $fillable = [
        'nama',
        'kelas',
        'nis',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}