<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questions';
    protected $fillable = [
        'id',
        'key',
        'slug',
        'category',
        'level',
        'classification',
        'question',
        'answer',
        'image',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $with = ['category', 'level', 'classification'];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }

    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_id', 'id');
    }
}
