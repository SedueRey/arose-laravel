<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'points',
        'criterion_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function criterion() {
        return $this->belongsTo(Criterion::class, 'criterion_id');
    }
}
