<?php namespace App\Http\Controllers\Api\Version1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceCallRequest;
use App\Exceptions\BadRequestException;
use App\Entities\ServiceCall;
use App\Models\ServiceCalls;

use Illuminate\Http\Exceptions\HttpResponseException;

class ServiceCallController extends Controller
{

    private $serviceCallModel;

    public function __construct(ServiceCalls $serviceCalls) {
        $this->serviceCallModel = $serviceCalls;
    }

    /**
     * @param ServiceCallRequest $serviceCallRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(ServiceCallRequest $serviceCallRequest)
    {
        try {
            $serviceCallRequest = $serviceCallRequest->all();
            $serviceCall = ServiceCall::create($serviceCallRequest);
            return response()->json($serviceCall->toArray());
        } catch (BadRequestException $e) {
            throw new HttpResponseException(response()->json($e->toArray(), $e->getCode()));
        }
    }

    /**
     * @param ServiceCallRequest $serviceCallRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function put(ServiceCallRequest $serviceCallRequest)
    {
        $serviceCallRequest = $serviceCallRequest->all();

        try {
            $serviceCall = $this->serviceCallModel->findById($serviceCallRequest['id']);
            $serviceCall->update($serviceCallRequest);
            return response()->json($serviceCall->toArray());
        } catch (BadRequestException $e) {
            throw new HttpResponseException(response()->json($e->toArray(), $e->getCode()));
        }
    }
}