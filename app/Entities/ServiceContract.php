<?php namespace App\Entities;

class ServiceContract extends BaseEntity
{
    /**
     * @var string
     */
    protected $table = 'ServiceContracts';

    /**
     * @var string
     */
    protected $primaryKey = 'ContractID';

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