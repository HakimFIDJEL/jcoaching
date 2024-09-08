<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Workout;
use Carbon\Carbon;

class RestPeriod extends Model
{
    use HasFactory;

    protected $fillable = ['start_date', 'end_date'];
    protected $dates = ['start_date', 'end_date'];

    public static function overlapsWithOtherRestPeriods($start_date, $end_date, $excludeId = null)
    {
        return self::when($excludeId, function ($query) use ($excludeId) {
                    $query->where('id', '!=', $excludeId);
                })
                ->where(function($query) use ($start_date, $end_date) {
                    $query->whereBetween('start_date', [$start_date, $end_date])
                        ->orWhereBetween('end_date', [$start_date, $end_date])
                        ->orWhere(function($query) use ($start_date, $end_date) {
                            $query->where('start_date', '<', $start_date)
                                    ->where('end_date', '>', $start_date);
                        })
                        ->orWhere(function($query) use ($start_date, $end_date) {
                            $query->where('start_date', '<', $end_date)
                                    ->where('end_date', '>', $end_date);
                        });
                })->exists();
    }

    public static function overlapsWithWorkouts($start_date, $end_date)
    {
        return Workout::whereBetween('date', [$start_date, $end_date])
                    ->orWhere(function($query) use ($start_date) {
                        $query->where('date', '<', $start_date)
                                ->where('date', '>', $start_date->copy()->subHour());
                    })->exists();
    }

}
