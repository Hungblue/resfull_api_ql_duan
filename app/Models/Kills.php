<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kills extends Model
{
    use HasFactory;
    protected $table = 'skills';

    protected $fillable = [
        'check_point_id',
        'name_skill',
        'level_id',
        'type_skill_id',
        'content',
        'user_id'
    ];
}
