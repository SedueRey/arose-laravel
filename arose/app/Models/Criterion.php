<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterion extends Model
{
    use HasFactory;

    protected $table = 'criteria';

    protected $fillable = [
        'title',
        'description',
        'rubric_id'
    ];

    public function rubric() {
        return $this->belongsTo(Rubric::class, 'rubric_id');
    }

    public function ratings() {
        return $this->hasMany(Rating::class);
    }
}
