<?php namespace App\Http\Controllers\Api\Version1;

use App\Entities\ServiceContract;
use App\Models\ServiceContracts;
use App\Exceptions\BadRequestException;
use App\Http\Requests\GenericRequest as Request;
use App\Http\Controllers\Controller;

use Illuminate\Http\Exceptions\HttpResponseException;

class ServiceContractController extends Controller
{
    private $serviceContractModel;

    public function __construct(ServiceContracts $serviceContracts) {
        $this->serviceContractModel = $serviceContracts;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request)
    {
        try {
            $request = $request->all();
            $serviceContract = ServiceContract::create($request);
            return response()->json($serviceContract->toArray());
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
            $serviceContract = $this->serviceCallModel->findById($request['id']);
            $serviceContract->update($request);
            return response()->json($serviceContract->toArray());
        } catch (BadRequestException $e) {
            throw new HttpResponseException(response()->json($e->toArray(), $e->getCode()));
        }
    }
}