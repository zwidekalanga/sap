<?php namespace App\Connectors\Sap\Di\Server\Handlers;

trait RequestOptions
{
    /**
     * @var DOMElement
     */
    private $adminInfo;

    /**
     * @var DOMElement
     */
    private $businessOjbect;

    /**
     * @var DOMElement
     */
    private $oType;

    /**
     * @var DOMElement
     */
    private $queryParam;

    /**
     * @param string $objectType
     */
    public function withBodyElement($objectType = 'AddObject') {
        $requestObject = $this->addToBodyNS(
            'http://www.sap.com/SBO/DIS',
            'dis:'.$objectType
        );

        $bom = $this->addToBody('BOM');
        $requestObject->appendChild($bom);

        $this->businessOjbect = $this->createElement('BO');
        $bom->appendChild($this->businessOjbect);

        $this->adminInfo = $this->createElement('AdmInfo');
        $this->businessOjbect->appendChild($this->adminInfo);

        $this->adminInfo->appendChild($this->oType);

        if ($objectType != 'AddObject') {
            $this->businessOjbect->appendChild($this->queryParam);
        }
    }

    /**
     * @param $name
     * @param null $value
     * @return mixed
     */
    public function addToBusinessObject($name, $value = null) {
        $item = $this->createElement($name, $value);
        $this->businessOjbect->appendChild($item);

        return $item;
    }

    /**
     * @param $name
     */
    public function setOType($name): void
    {
        $this->oType = $this->createElement('Object', $name);
    }

    /**
     * @param array $params
     */
    public function setQueryParams($params = array()) {
        $this->queryParam = $this->createElement('QueryParams');
        
        foreach ($params as $name => $value) {
            $item = $this->createElement($name, $value);
            $this->queryParam->appendChild($item);
        }
    }
}