<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',

        'product_type',
        'product_name',
        'product_quantity',
        'product_price',

        'price_ht',
        'price_ttc',
        'taxes',
        'currency',
        'description',

        'user_id',
        'customer_firstname',
        'customer_lastname',
        'customer_email',
        'customer_phone',
        'customer_address',
        'customer_city',
        'customer_postal_code',
        'customer_country',

        'payment_method',
        'stripe_session_id',
        'status',
        'reduction_id',
        'ip_address',
        
        'cgv_terms_accepted_at',
        'rgpd_terms_accepted_at',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function reduction() {
        return $this->belongsTo(Reduction::class);
    }

    public function plan() {
        return $this->hasOne(Plan::class);
    }

    public function workouts() {
        return $this->hasMany(Workout::class);
    }

    public function invoice() {
        return $this->hasOne(Invoice::class);
    }

}
