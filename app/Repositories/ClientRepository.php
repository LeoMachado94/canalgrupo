<?php
namespace App\Repositories;

use App\Models\Client;
use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Client::class;
    }
}
