<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'total',
        'paid_amount',
        'status',       // <-- Tambahkan ini
        'table_number', // <-- Tambahkan ini
        'notes',        // <-- Tambahkan ini
    ];

    /**
     * Relasi ke model User (untuk mengetahui siapa kasir/member).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model TransactionDetail (untuk mengetahui item apa saja yang dibeli).
     */
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
