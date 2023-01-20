<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    protected $fillable = ['stamp_id', 'rest_date', 'start_rest', 'end_rest'];

    public function stamp()
    {
        $this->belongsTo(Stamp::class);
    }
}
