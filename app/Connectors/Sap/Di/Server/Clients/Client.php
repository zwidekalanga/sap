<?php namespace App\Connectors\Sap\Di\Server\Clients;

use App\Connectors\Sap\Di\Server\Handlers\Response;

class Client implements ClientInterface
{
    use Authentication;

    /**
     * @var \COM
     */
    private $obj;

    /**
     * @var Response
     */
    private $response;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->obj = new \COM('SBODI_Server.node') or die ('No connection');
    }

    /**
     * @param $xml
     */
    public function setResponse($xml) {
        $this->response = new Response('1.0', 'UTF-8');
        $this->response->loadXML($xml);
    }

    /**
     * @return Response
     */
    public function getResponse() : Response {
        return $this->response;
    }

    /**
     * @param $xml
     */
    public function sendRequest($xml) {
        $xml = mb_convert_encoding($xml, 'UTF-8', 'UTF-16');
        $response = $this->obj->Interact($xml);       
        $this->setResponse($response);
    }
}