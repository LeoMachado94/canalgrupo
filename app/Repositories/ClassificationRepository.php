<?php
namespace App\Repositories;

use App\Models\Classification;
use Prettus\Repository\Eloquent\BaseRepository;

class ClassificationRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Classification::class;
    }
}
