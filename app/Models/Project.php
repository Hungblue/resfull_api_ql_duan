<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "projects";

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'avatar',
        'start_date',
        'plan_close_date',
        'type',
        'contract_status',
        'unit_price',
        'description',
        'size',
        'code',
        'leader_id',

    ];

    public function deadlines()
    {
        return $this->hasMany(Deadlines::class);
    }

    public function estimations()
    {
        return $this->hasMany(Estimations::class);
    }

    public function resources()
    {
        return $this->hasMany(Resources::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function listUser(){
        return $this->belongsToMany(Resources::class, User::class, 'id', 'username');
        }
    public function listUserResources(){
        return $this->belongsToMany( User::class,Resources::class, 'project_id', 'user_id');
        }
        
}
