<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OtpCode extends Model
{
    protected static function boot() {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function getIncrementing() {
        return false;
    }

    public function getKeyType() {
        return 'string';
    }

    protected $fillable = [
        'user_id', 'code', 'expired_at'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
