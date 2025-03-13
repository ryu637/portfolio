<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'highlights',
        'highlights_jp',
        'feelings',
        'feelings_jp',
        'learnings',
        'learnings_jp',
        'plans',
        'plans_jp'
    ];

    
}
