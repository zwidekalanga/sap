<?php namespace App\Models;

use App\Entities\Generic;

class Generics
{
    /**
     * @param $id
     * @return Document
     */
    public function findById($id) {
        return new Generic(['id' => $id]);
    }
}