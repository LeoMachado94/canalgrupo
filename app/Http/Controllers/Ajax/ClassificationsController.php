<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\ClassificationRepository;

class ClassificationsController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ClassificationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function lists()
    {
        return $this->repository->all();
    }
}
