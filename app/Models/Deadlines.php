<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deadlines extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'deadlines';

    protected $fillable = [
        'project_id',
        'name',
        'date',
        'status',
        'pic',

    ];

    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
