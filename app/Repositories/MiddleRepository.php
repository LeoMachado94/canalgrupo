<?php
namespace App\Repositories;

use App\Models\Middle;
use Prettus\Repository\Eloquent\BaseRepository;

class MiddleRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Middle::class;
    }
}
