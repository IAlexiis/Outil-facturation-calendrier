<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CalendarLine extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'calendar_id',
        'uid',
        'title',
        'description',
        'start',
        'end',
        'duration_minutes',
        'total_hours',
        'location',
        'status',
        'is_billable',
        'hourly_rate',
        'amount',
        'tva_rate',
        'tva_amount',
        'total_with_tva',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }
}
