<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resources extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'resources';

    protected $fillable = [
        'project_id',
        'user_id',
        'start_date',
        'end_date',
        'busy_rate',
        'status',

    ];

    public function projects()
    {
        return $this->belongsTo(Project::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class,'id');
    }
}
