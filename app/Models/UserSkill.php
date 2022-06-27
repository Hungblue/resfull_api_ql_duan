<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
    use HasFactory;
    protected $table = 'user_skill';

    protected $fillable = [
        'user_id',
        'skill_id',
        'time_experience',
    ];
    // public function UserSkill()
    // {
    //     return $this->hasMany(Master::class, 'id');
    // }
    public function nameSkill()
    {
        return $this->belongsTo(Master::class, 'skill_id');
    }
}
