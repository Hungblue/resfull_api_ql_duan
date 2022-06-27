<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckPoint extends Model
{
    use HasFactory;
    protected $table = 'check_point';

    protected $fillable = [
        'name_assess',
        'start_date',
        'end_date',
        'number_staff',
        'status',
        'content',
    ];
    public function newKillUserCheckPoin()
    {
        return $this->belongsToMany( User::class,Kills::class, 'check_point_id', 'name_skill')->withTimestamps();
    }
    public function achievementWorks()
    {
        return $this->belongsToMany(Project::class, AchievementWork::class, 'check_point_id', 'project_id')->withTimestamps();
    }
}
