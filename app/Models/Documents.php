<?php namespace App\Models;

use App\Entities\Document;

class Documents
{
    /**
     * @param $id
     * @return Document
     */
    public function findById($id) {
        return new Document(['id' => $id]);
    }
}