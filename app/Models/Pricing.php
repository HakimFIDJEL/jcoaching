<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\PricingFeature;
use App\Models\Pricing;

class Pricing extends Model
{
    use HasFactory;

    protected $table = 'pricings';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'price',
        'nbr_sessions',
        'online',
    ];

    public function features()
    {
        return $this->hasMany(PricingFeature::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where(['online' => true, 'deleted_at' => null]);
    }

    public function softDelete()
    {
        $this->deleted_at = now();
        $this->save();
    }

    public function restore()
    {
        $this->deleted_at = null;
        $this->save();
    }


}
