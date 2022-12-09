<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSourceField extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function dataSource()
    {
        return $this->belongsTo(DataSource::class);
    }

}
