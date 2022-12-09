<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    /**
     * @var mixed
     */
    protected $table = 'categories';
    protected $fillable = [
        'id',
        'slug',
        'name',
        'description',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
