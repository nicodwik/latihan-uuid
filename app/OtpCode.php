<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OtpCode extends Model
{
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
