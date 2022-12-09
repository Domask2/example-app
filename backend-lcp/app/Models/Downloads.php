<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Downloads extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'user_id',
        'file',
        'title',
        'description',
        'url',
        'project',
        'project_page',
        'visible'
    ];
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}

