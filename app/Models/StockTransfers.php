<?php namespace App\Models;

use App\Entities\StockTransfer;

class StockTransfers
{
    /**
     * @param $id
     * @return StockTransfer
     */
    public function findById($id) {
        return new StockTransfer(['id' => $id]);
    }
}