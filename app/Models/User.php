<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'status',
        'joined_date',
        'email',
        'phone',
        'join_projects',
        'busy_rate',
        'country',
        'cmnd',
        'phone_number',
        'birthday',
        'role_id',
        'number_years_experience'

    ];
    protected $table = 'users';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function resources()
    {
        return $this->hasOne(Resources::class);
    }

    public function AauthAcessToken()
    {
        return $this->hasMany(OauthAccessToken::class);
    }
    public function kill()
    {
        return $this->belongsToMany(Master::class, UserSkill::class, 'user_id', 'skill_id')->withTimestamps();
    }
}
