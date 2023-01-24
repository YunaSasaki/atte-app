<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stamp extends Model
{
    protected $fillable = ['user_id', 'stamp_date', 'start_work', 'end_work'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rest()
    {
        return $this->hasMany(Rest::class);
    }
}
