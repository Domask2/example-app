<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $db_key)
 * @property integer id
 */
class DataBase extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function dataSources()
    {
        return $this->hasMany(DataSource::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
