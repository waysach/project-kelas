<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'tanggal',
        'keterangan',
        'jenis',
        'jumlah',
        'student_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}