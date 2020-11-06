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
        'id', 'user_id', 'code', 'expired_at'
    ];

    protected $casts = [
        'expired_at' => 'datetime:Y-m-d H:m:s',
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
