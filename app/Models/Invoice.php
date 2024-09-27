<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'order_id',
        'path',
        'filename',
        'type',
        'size',
        'extension',
        'mime_type',
        'is_cancelled',
        'cancellation_reason',
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
