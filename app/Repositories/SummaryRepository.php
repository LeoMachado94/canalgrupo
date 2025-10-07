<?php
namespace App\Repositories;

use App\Models\Summary;
use Prettus\Repository\Eloquent\BaseRepository;

class SummaryRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Summary::class;
    }
}
