<?php namespace App\Models;

use App\Entities\CustomerEquipmentCard;

class CustomerEquipmentCards
{
    /**
     * @param $id
     * @return CustomerEquipmentCard
     */
    public function findById($id) {
        return new CustomerEquipmentCard(['id' => $id]);
    }
}