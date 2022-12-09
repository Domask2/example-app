<?php

namespace App\Http\Controllers;

use App\Services\Magic\MagicService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $magicService;

    public function __construct(MagicService $service)
    {
        $this->magicService = $service;
    }
}
