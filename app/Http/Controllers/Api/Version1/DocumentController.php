<?php namespace App\Http\Controllers\Api\Version1;

use App\Entities\Document;
use App\Exceptions\BadRequestException;
use App\Http\Requests\GenericRequest as Request;
use App\Http\Controllers\Controller;
use App\Models\Documents;

use Illuminate\Http\Exceptions\HttpResponseException;

class DocumentController extends Controller
{
    private $documentModel;

    public function __construct(Documents $documents) {
        $this->documentModel = $documents;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request)
    {
        try {
            $request = $request->all();
            $document = Document::create($request);
            return response()->json($document->toArray());
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
            $document = $this->documentModel->findById($request['id']);
            $document->update($request);
            return response()->json($document->toArray());
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
            $document = $this->documentModel->findById($request['id']);
            $document->delete();
            return response()->json($document->toArray());
        } catch (BadRequestException $e) {
            throw new HttpResponseException(response()->json($e->toArray(), $e->getCode()));
        }
    }
}