<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'quantity',
        'unit',
        'source',
        'collection_date',
        'status',
    ];

    protected $casts = [
        'collection_date' => 'date',
    ];
}
