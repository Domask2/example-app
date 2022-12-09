<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    /**
     * @var mixed
     */
    protected $table = 'level';
    protected $fillable = [
        'id',
        'level'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
