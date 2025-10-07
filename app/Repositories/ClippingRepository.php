<?php
namespace App\Repositories;

use App\Models\Clipping;
use Prettus\Repository\Eloquent\BaseRepository;

class ClippingRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Clipping::class;
    }
}
