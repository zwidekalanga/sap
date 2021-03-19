<?php namespace App\Models;

use App\Entities\ServiceCall;

class ServiceCalls extends BaseModel
{
    /**
     * @param $id
     * @return ServiceCall
     */
    public function findById($id) {
        return new ServiceCall(['id' => $id]);
    }
}
