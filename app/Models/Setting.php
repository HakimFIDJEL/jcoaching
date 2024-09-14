<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_address',
        'company_logo',
        'company_phone',
        'company_email',
        'company_facebook',
        'company_twitter',
        'company_instagram',
        'company_linkedin',
        'company_youtube',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'pinterest',
        'youtube',
        'nutrition_idea',
        'nutrition_price',
        'workout_price'
    ];
}
