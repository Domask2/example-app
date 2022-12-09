<?php


namespace App\Services;

use App\Services\Magic\MagicService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;

abstract class CoreService
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var
     */
    public $magicService;

    /**
     * CoreRepository constructor.
     * @param MagicService $magicService
     */
    public function __construct(MagicService $magicService)
    {
        $this->model = $this->getModelClass();
        $this->magicService = $magicService;
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
