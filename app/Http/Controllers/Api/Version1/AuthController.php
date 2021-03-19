<?php namespace App\Http\Controllers\Api\Version1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthLogoutRequest;
use App\Connectors\Sap\Di\Server\Connector;
use App\Models\Auth;
use App\Exceptions\BadRequestException;
use App\Connectors\Sap\Di\Server\Builder;
use Illuminate\Container\Container;

use Illuminate\Http\Exceptions\HttpResponseException;

class AuthController extends Controller
{
    /**
     * @var Connector
     */
    private $connector;

    /**
     * AuthController constructor.
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @param AuthLoginRequest $authRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthLoginRequest $authRequest) {
        $authRequest = $authRequest->all();
        $this->connector->createClientSession($authRequest);

        return response()->json(['SessionId' => $this->connector->getClient()->getSession()]);
    }

    /**
     * @param AuthLogoutRequest $authLogoutRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(AuthLogoutRequest $authLogoutRequest) {
        $authLogoutRequest = $authLogoutRequest->all();

        if (!$this->connector->destroyClientSession($authLogoutRequest['SessionId'])) {
            return response()->json(['message' => 'Unable to logout']);
        };

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function session() {
        try {
            $db = Container::getInstance()->make(Builder::class);
            $response = $db->select('SELECT COUNT(CardCode) FROM OCRD'); //you can call sql query on the server, but i haven't expose it to a endpoint

            return response()->json([
                'code' => 200,
                'message' => 'Valid Session'
            ]);
        } catch (BadRequestException $e) {
            throw new HttpResponseException(response()->json($e->toArray(), $e->getCode()));
        }
    }
}