<?php namespace App\Http\Controllers\Api\Version1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessPartnerRequest;
use App\Exceptions\BadRequestException;
use App\Entities\BusinessPartner;
use App\Models\BusinessPartners;

use Illuminate\Http\Exceptions\HttpResponseException;

class BusinessPartnerController extends Controller
{

    private $businessPartnerModel;

    public function __construct(BusinessPartners $businessPartners) {
        $this->businessPartnerModel = $businessPartners;
    }

    /**
     * @param BusinessPartnerRequest $businessPartnerRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(BusinessPartnerRequest $businessPartnerRequest)
    {
        try {
            $businessPartnerRequest = $businessPartnerRequest->all();
            $businessPartner = BusinessPartner::create($businessPartnerRequest);
            return response()->json($businessPartner->toArray());
        } catch (BadRequestException $e) {
            throw new HttpResponseException(response()->json($e->toArray(), $e->getCode()));
        }
    }

    /**
     * @param BusinessPartnerRequest $businessPartnerRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function put(BusinessPartnerRequest $businessPartnerRequest)
    {
        $businessPartnerRequest = $businessPartnerRequest->all();

        try {
            $businessPartner = $this->businessPartnerModel->findById($businessPartnerRequest['id']);
            $businessPartner->update($businessPartnerRequest);
            return response()->json($businessPartner->toArray());
        } catch (BadRequestException $e) {
            throw new HttpResponseException(response()->json($e->toArray(), $e->getCode()));
        }
    }

    /**
     * @param BusinessPartnerRequest $businessPartnerRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(BusinessPartnerRequest $businessPartnerRequest)
    {
        $businessPartnerRequest = $businessPartnerRequest->all();

        try {
            $businessPartner = $this->businessPartnerModel->findById($businessPartnerRequest['id']);
            $businessPartner->delete();
            return response()->json($businessPartner->toArray());
        } catch (BadRequestException $e) {
            throw new HttpResponseException(response()->json($e->toArray(), $e->getCode()));
        }
    }
}