<?php namespace App\Entities;


class BusinessPartner extends BaseEntity
{
    /**
     * @var string
     */
    protected $table = 'BusinessPartners';

    /**
     * @var string
     */
    protected $primaryKey = 'CardCode';

    /**
     * @var array
     */
    protected $validation = array(
        // DO NOT EDIT
        'id' => '',
        'CardCode' => '',
        'CardName' => '',
        'CardType' => '',
        // /DO NOT EDIT
    );
}
