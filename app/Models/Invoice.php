<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;



class Invoice extends Model
{

public $incrementing = false;
protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'company_id',
        'invoice_date',
        'period',
        'total_hours',
        'hourly_rate',
        'tva_rate',
        'total',
        'pdf_path',
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

    public function company()
{
    return $this->belongsTo(Company::class, 'company_id'); 
}

public function getRouteKeyName()
{
    return 'id'; 
}

protected $casts = [
    'invoice_date' => 'datetime',
];

}
