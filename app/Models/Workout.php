<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\RestPeriod;

class Workout extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['date'];

    protected $fillable = [
        'user_id',
        'plan_id',
        'date',
        'status',
        'notified',
    ];

    public function plan() {
        return $this->belongsTo(Plan::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeIndependant($query) {
        return $query->where('plan_id', null);
    }
    
    public function hasOverlappingWorkouts($newStart, $newEnd, $workoutId)
    {
        return Workout::where('id', '!=', $workoutId)
            ->where(function($query) use ($newStart, $newEnd) {
                $query->whereBetween('date', [$newStart, $newEnd->copy()->subSecond()])
                    ->orWhere(function($query) use ($newStart) {
                        $query->where('date', '<', $newStart)
                            ->where('date', '>', $newStart->copy()->subHour());
                    });
            })->exists();
    }

    public function hasOverlappingRestPeriods($newStart, $newEnd)
    {
        return RestPeriod::where(function($query) use ($newStart, $newEnd) {
            $query->whereBetween('start_date', [$newStart, $newEnd->copy()->subSecond()])
                ->orWhereBetween('end_date', [$newStart->copy()->addSecond(), $newEnd])
                ->orWhere(function($query) use ($newStart) {
                    $query->where('start_date', '<', $newStart)
                        ->where('end_date', '>', $newStart);
                })
                ->orWhere(function($query) use ($newEnd) {
                    $query->where('start_date', '<', $newEnd)
                        ->where('end_date', '>', $newEnd);
                });
        })->exists();
    }


   
}
