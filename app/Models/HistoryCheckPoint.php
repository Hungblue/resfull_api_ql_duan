<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryCheckPoint extends Model
{
    use HasFactory;
    protected $table = 'history_check_point';

    protected $fillable = [
        'check_point_id',
        'contract_id',
        'user_id',
        'status',
        'status_submit',
        'new_salary',
        'current_salary',
        'target_previous_period',
        'target_next_period',
        'development_expectations',
        'content',
        'point_average'
    ];
    
}
