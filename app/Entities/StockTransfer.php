<?php namespace App\Entities;

class StockTransfer extends BaseEntity
{
    /**
     * @var string
     */
    protected $table = 'StockTransfer';

    /**
     * @var string
     */
    protected $primaryKey = 'AbsEntry';

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