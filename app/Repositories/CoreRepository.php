<?php


namespace App\Repositories;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;

abstract class CoreRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * CoreRepository constructor.
     */
    public function __construct()
    {
        $this->model = $this->getModelClass();
    }

    /**
     * @return mixed
     */
    abstract protected function getModelClass();

    /**
     * @return Application|Model|mixed
     */
    protected function entity()
    {
        return new $this->model;
    }
}
