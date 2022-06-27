<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchievementWork extends Model
{
    use HasFactory;
    protected $table = 'achievement_work';

    protected $fillable = [
        'check_point_id',
        'project_id',
        'participation_time',
        'work_name',
        'result_user',
        'result_leader',
        'comment',
        'user_id'
    ];
}
