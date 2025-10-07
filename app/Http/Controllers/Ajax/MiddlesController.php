<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\MiddleRepository;

class MiddlesController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MiddleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function lists()
    {
        return $this->repository->all(['id', 'name']);
    }
}
