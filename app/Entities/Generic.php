<?php namespace App\Entities;

class Generic extends BaseEntity
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $primaryKey;


    /**
     * @var array
     */
    protected $validation = array(
        // DO NOT EDIT
        'id' => ''
        // /DO NOT EDIT
    );

    public function preCreateHook($data)
    {
        if (isset($data['ObjectType'])) {
            $this->setTable($data['ObjectType']);
        }

        if (isset($data['PrimaryKey'])) {
            $this->setPrimaryKey($data['PrimaryKey']);
        }

        return parent::preCreateHook($data);
    }

    public function preUpdateHook($data) 
    {
        if (isset($data['ObjectType'])) {
            $this->setTable($data['ObjectType']);
        }

        if (isset($data['PrimaryKey'])) {
            $this->setPrimaryKey($data['PrimaryKey']);
        }

        return parent::preUpdateHook($data);
    }

    protected function setTable($table) {
        $this->table = $table;
    }

    protected function setPrimaryKey($primaryKey) {
         $this->primaryKey = $primaryKey;
    }
}