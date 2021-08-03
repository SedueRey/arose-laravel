<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    use HasFactory;
    protected $fillable = [
        'filename',
        'filepath',
        'country',
        'desc',
        'level',
        'format',
        'type',
        'uploaded_by'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
