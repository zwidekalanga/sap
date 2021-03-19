<?php namespace App\Models;

use App\Entities\ServiceContract;

class ServiceContracts
{
    /**
     * @param $id
     * @return ServiceContract
     */
    public function findById($id) {
        return new ServiceContract(['id' => $id]);
    }
}