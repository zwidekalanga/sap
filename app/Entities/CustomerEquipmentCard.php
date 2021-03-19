<?php namespace App\Entities;

class CustomerEquipmentCard extends BaseEntity
{
    /**
     * @var string
     */
    protected $table = 'CustomerEquipmentCards';

    /**
     * @var string
     */
    protected $primaryKey = 'EquipmentCardNum';

    /**
     * @var array
     */
    protected $validation = array(
        // DO NOT EDIT
        'id' => '',
        'CustomerCode' => '',
        'ItemCode' => '',
        'InternalSerialNum' => '',
        'Subject' => '',
        'CallType' => '',
        // /DO NOT EDIT
    );
}