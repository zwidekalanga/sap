<?php namespace App\Http\Controllers\Api\Version1;

use App\Entities\StockTransfer;
use App\Exceptions\BadRequestException;
use App\Http\Requests\GenericRequest as Request;
use App\Http\Controllers\Controller;
use App\Models\StockTransfers;

class StockTransferController extends Controller
{
    private $stockTransferModel;

    public function __construct(StockTransfers $stockTransfers) {
        $this->stockTransferModel = $stockTransfers;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request)
    {
        try {
            $request = $request->all();
            $stockTransfer = StockTransfer::create($request);
            return response()->json($stockTransfer->toArray());
        } catch (BadRequestException $e) {
            throw new HttpResponseException(response()->json($e->toArray(), $e->getCode()));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function put(Request $request)
    {
        $request = $request->all();

        try {
            $stockTransfer = $this->stockTransferModel->findById($request['id']);
            $stockTransfer->update($request);
            return response()->json($stockTransfer->toArray());
        } catch (BadRequestException $e) {
            throw new HttpResponseException(response()->json($e->toArray(), $e->getCode()));
        }
    }
}