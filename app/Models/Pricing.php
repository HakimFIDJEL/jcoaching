<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\PricingFeature;
use App\Models\Pricing;

class Pricing extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pricings';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'price',
        'nbr_sessions',
        'online',
    ];

    public function nbrOfUsers() {        
        return $this->plans()->distinct('user_id')->count();
    }
    

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
        return $query->where('online', 1);
    }
}
