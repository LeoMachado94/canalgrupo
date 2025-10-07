<?php
namespace App\Repositories;

use App\Models\Editorial;
use Prettus\Repository\Eloquent\BaseRepository;

class EditorialRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Editorial::class;
    }
}
