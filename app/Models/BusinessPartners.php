<?php namespace App\Models;

use App\Entities\BusinessPartner;

class BusinessPartners extends BaseModel
{
    /**
     * @param $id
     * @return BusinessPartner
     */
    public function findById($id) {
        return new BusinessPartner(['id' => $id]);
    }
}
