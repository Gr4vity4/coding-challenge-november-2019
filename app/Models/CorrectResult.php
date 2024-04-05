<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorrectResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'letters_mapping',
        'first_input',
        'second_input',
        'third_input',
        'sum_input',
        'query_first_input',
        'query_second_input',
        'query_third_input',
        'query_sum',
        'attempts',
    ];
}
