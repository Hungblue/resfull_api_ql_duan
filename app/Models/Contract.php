<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    protected $table = 'contract';

    protected $fillable = [
        'user_id',
        'type_contract',
        'start_date',
        'end_date',
        'basic_salary',
        'salary_rank',
        'salary',
        'salary_type',
        'salary_allowance',
        'type_allowance',
        'position',
    ];
}
