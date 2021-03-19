<?php namespace App\Connectors\Sap\Di\Server;

abstract class Runner
{
    protected $client;

    protected $request;

    protected $lastKey;

    public function process($actionType = 'AddObject') {
    	$xml = $this->request->saveXml();

    	try {
    		$this->client->sendRequest($xml);
    		$this->setLastKey($this->client->getResponse()->getValueByQuery('xmlns:'.$actionType.'Response/xmlns:RetKey'));
    	} catch (\Exception  $e) {
    		throw $e;
    	}
    }

    /**
     * @param mixed $lastKey
     */
    protected abstract function setLastKey($lastKey): void;
}