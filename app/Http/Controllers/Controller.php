<?php

namespace App\Http\Controllers;

use App\Traits\JsonResponseTrait;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use League\Fractal\Manager;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, JsonResponseTrait;

    public function __construct()
    {
        $fractal = new Manager();

        $this->fractal = $fractal;

        $this->setFractal($this->fractal);
    }
}
