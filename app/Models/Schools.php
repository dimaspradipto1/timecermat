<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schools extends Model
{
    use HasFactory;

    protected $table = 'schools';

    protected $fillable = [
        'name',
        'regu',
        'score',
        'slot',
        'is_active',
    ];

    protected $casts = [
        'score' => 'integer',
        'slot' => 'integer',
        'is_active' => 'boolean',
    ];
}
