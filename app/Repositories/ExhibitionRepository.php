<?php
namespace App\Repositories;

use App\Models\Exhibition;
use Prettus\Repository\Eloquent\BaseRepository;

class ExhibitionRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Exhibition::class;
    }
}
