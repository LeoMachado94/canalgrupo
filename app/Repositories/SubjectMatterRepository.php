<?php
namespace App\Repositories;

use App\Models\SubjectMatter;
use Prettus\Repository\Eloquent\BaseRepository;

class SubjectMatterRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return SubjectMatter::class;
    }
}
