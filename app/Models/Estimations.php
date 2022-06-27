<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estimations extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'estimations';

    protected $fillable = [
        'project_id',
        'name',
        'date',
        'effort',
        'unit_price',
        'total'
    ];

    public function projects()
    {
        return $this->belongsTo(Project::class);
    }
}
