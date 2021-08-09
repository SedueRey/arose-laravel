<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Student extends Model
{
    use HasFactory;

    use Uuid;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ratings() {
        return $this->belongsToMany(Rating::class);
    }
}
