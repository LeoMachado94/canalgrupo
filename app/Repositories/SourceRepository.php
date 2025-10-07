<?php
namespace App\Repositories;

use App\Models\Source;
use Prettus\Repository\Eloquent\BaseRepository;

class SourceRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Source::class;
    }
}
