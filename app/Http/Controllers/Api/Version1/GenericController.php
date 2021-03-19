<?php namespace App\Http\Controllers\Api\Version1;

use App\Http\Controllers\Controller;
use App\Exceptions\BadRequestException;
use App\Http\Requests\GenericRequest as Request;
use App\Entities\Generic;
use App\Models\Generics;

use Illuminate\Http\Exceptions\HttpResponseException;

class GenericController extends Controller
{

    private $genericModel;

    public function __construct(Generics $generics) {
        $this->genericModel = $generics;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request)
    {
        try {
            $request = $request->all();
            $generics = Generic::create($request);
            return response()->json($generics->toArray());
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
            $generics = $this->genericModel->findById($request['id']);
            $generics->update($request);
            return response()->json($generics->toArray());
        } catch (BadRequestException $e) {
            throw new HttpResponseException(response()->json($e->toArray(), $e->getCode()));
        }
    }
}