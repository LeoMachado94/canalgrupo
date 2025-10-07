<?php
namespace App\Repositories;

use App\Models\Vehicle;
use Prettus\Repository\Eloquent\BaseRepository;

class VehicleRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Vehicle::class;
    }
}
