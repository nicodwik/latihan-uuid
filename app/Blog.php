<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $keyType = 'string';
    public $incrementing = false; 
    protected $guarded = [];
}
