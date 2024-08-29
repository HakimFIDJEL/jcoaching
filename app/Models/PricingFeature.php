<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\PricingFeature;
use App\Models\Pricing;

class PricingFeature extends Model
{
    use HasFactory;


    protected $fillable = [
        'pricing_id',
        'label',
    ];

    public function pricing()
    {
        return $this->belongsTo(Pricing::class);
    }

}
