<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorrectResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'letters',
        'sum_letters',
        'result',
        'found_at_round',
        'max_round'
    ];
}
