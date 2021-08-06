<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usedrubric extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'rubric_id',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rubric() {
        return $this->belongsTo(Rubric::class, 'rubric_id');
    }
}
