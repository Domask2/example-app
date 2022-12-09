<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed dataSourceFields
 * @property mixed dataBase
 * @property mixed description
 * @property string key
 * @property string type
 * @property string crud
 * @property string title
 * @property mixed dataSourceAccesses
 * @method static where(string $string, $id)
 */
class DataSource extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function dataSourceFields()
    {
        return $this->hasMany(DataSourceField::class)->orderBy('title');
    }

    public function dataSourceAccesses()
    {
        return $this->hasMany(DataSourceAccess::class)->orderBy('role');
    }

    public function dataBase()
    {
        return $this->belongsTo(DataBase::class);
    }

}
