<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Musonza\Chat\Traits\Messageable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Messageable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'school',
        'city',
        'country',
        'photo',
        'bio'
    ];

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

    public function resources() {
        return $this->hasMany(Resources::class, 'uploaded_by');
    }

    public function students() {
        return $this->hasMany(Student::class);
    }

    public function rubrics() {
        return $this->hasMany(Rubric::class);
    }

    public function usedrubrics() {
        return $this->hasMany(Usedrubric::class);
    }
}
