<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $fillable = [
        'id',
        'user_id',
        'question_id',
        'question_quantity'
    ];

    protected $with = ['question'];
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id','id');
    }
}
