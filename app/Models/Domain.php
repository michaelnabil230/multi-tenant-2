<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = [
        'domain',
        'tenant_id',
    ];

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->domain = strtolower($model->domain);
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
