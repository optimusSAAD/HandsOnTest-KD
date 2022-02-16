<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = ['user_id','month', 'year','amount','status',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
