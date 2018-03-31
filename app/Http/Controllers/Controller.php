<?php

namespace App\Http\Controllers;

use App\Repository\Contracts\Repository;
use Laravel\Lumen\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{

    /**
     * @var Repository
     */
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function all() {
        return response()->json($this->repository->all(), 200);
    }

}
