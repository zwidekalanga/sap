<?php namespace App\Connectors\Sap\Di\Server\Handlers;

use App\Connectors\Sap\Di\Server\Handlers\RequestOptions;

class Request extends \DOMDocument
{

    use RequestOptions;

    /**
     * @var DOMElement
     */
    protected $wrapper;

    /**
     * @var DOMElement
     */
    protected $body;

    /**
     * @var DOMElement
     */
    protected $header;

    /**
     * Request constructor.
     * @param $version
     * @param $encoding
     */
    public function __construct ($version, $encoding){
        parent::__construct($version, $encoding);

        $this->setUp();
    }

    /**
     * @param $namespaceURI
     * @param $qualifiedName
     * @return \DOMElement
     */
    public function addToBodyNS($namespaceURI, $qualifiedName) {
        $item = $this->createElementNS($namespaceURI, $qualifiedName);
        $this->body->appendChild($item);

        return $item;
    }

    /**
     * @param $name
     * @param $value
     * @return \DOMElement
     */
    public function addToHeader($name, $value) {
        $item = $this->createElement($name, $value);
        $this->header->appendChild($item);

        return $item;
    }

    /**
     * @param $name
     * @param null $value
     * @return \DOMElement
     */
    public function addToBody($name, $value = null) {
        $item = $this->createElement($name, $value);
        $this->body->appendChild($item);

        return $item;
    }

    /**
     * @param $name
     * @param null $value
     * @param null $object
     */
    public function addToObject($name, $value = null, $object = null) {
        $item = $this->createElement($name, $value);
        $object->appendChild($item);
    }

    /**
     *  Sets up the request with basic request imformation
     */
    private function setUp() {
        $this->wrapper = $this->createElementNS('http://schemas.xmlsoap.org/soap/envelope/', 'env:Envelope');
        $this->appendChild($this->wrapper);

        $this->header = $this->createElement('env:Header');
        $this->wrapper->appendChild($this->header);

        $this->body = $this->createElement('env:Body');
        $this->wrapper->appendChild($this->body);
    }
}