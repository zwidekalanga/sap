<?php namespace App\Http\Controllers\Api\Version1;

use App\Entities\CustomerEquipmentCard;
use App\Exceptions\BadRequestException;
use App\Http\Requests\GenericRequest as Request;
use App\Http\Controllers\Controller;
use App\Models\CustomerEquipmentCards;

use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerEquipmentCardController extends Controller
{
    private $customerEquipmentCardModel;

    public function __construct(CustomerEquipmentCards $customerEquipmentCards) {
        $this->customerEquipmentCardModel = $customerEquipmentCards;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request)
    {
        try {
            $request = $request->all();
            $customerEquipmentCard = CustomerEquipmentCard::create($request);
            return response()->json($customerEquipmentCard->toArray());
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
            $customerEquipmentCard = $this->customerEquipmentCardModel->findById($request['id']);
            $customerEquipmentCard->update($request);
            return response()->json($customerEquipmentCard->toArray());
        } catch (BadRequestException $e) {
            throw new HttpResponseException(response()->json($e->toArray(), $e->getCode()));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $request = $request->all();

        try {
            $customerEquipmentCard = $this->customerEquipmentCardModel->findById($request['id']);
            $customerEquipmentCard->delete();
            return response()->json($customerEquipmentCard->toArray());
        } catch (BadRequestException $e) {
            throw new HttpResponseException(response()->json($e->toArray(), $e->getCode()));
        }
    }
}