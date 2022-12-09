<?php

namespace App\Models\Magic;

use Illuminate\Database\Eloquent\Model;

/**
 * @method create($__data)
 * @method where($column, $operator = null, $value = null, $boolean = 'and')
 */
class MagicEntity extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    /**
     * primaryKey
     *
     * @var integer
     * @access protected
     */
    protected $primaryKey = null;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
