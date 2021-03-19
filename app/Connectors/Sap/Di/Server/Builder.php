<?php namespace App\Connectors\Sap\Di\Server;

use App\Connectors\Sap\Di\Server\Handlers\Request;

class Builder extends Runner
{
    protected $table;

    public function __construct(Connector $connector)
    {
        $this->client = $connector->getClient();

        $this->request = new Request('1.0', 'UTF-16');
        $this->request->addToHeader('SessionID', $this->client->getSession());
    }

    public function prepQueryRequest() {
        $this->request->withBodyElement();
    }

    public function table($name) {
        $table = $BusinessObjectType = $name;

        if (strpos($name,'.')) {
            list($table, $BusinessObjectType) = explode('.', $name);
        }

        $this->table = $table;
        $this->request->setOType('o'.$BusinessObjectType);

        return $this;
    }

    public function where($query = array()) {
        if (!empty($query)) {
            $this->request->setQueryParams($query);
        }

        return $this;
    }

    public function insert($data) {
        $this->request->withBodyElement();
        $this->set($data);

        $this->process();

        return $this->getLastKey();
    }

    public function update($data) {
        $this->request->withBodyElement('UpdateObject');
        $this->set($data);

        $this->process('UpdateObject');
    }

    public function set($data = array()) {
        $primaryBusinessObject = $this->request->addToBusinessObject($this->table);
        $row = $this->request->createElement('row');
        $primaryBusinessObject->appendChild($row);

        $excludeKey =  array('id', 'DocType', 'ObjectType', 'PrimaryKey');

        foreach ($data as $key => $value) {
            if (in_array($key, $excludeKey)) {
                continue;
            }

            if (is_array($value)) {
                $secondaryBusinessObject = $this->request->addToBusinessObject($key);

                foreach ($value as $lines) {
                    if (isset($lines['LineNum'])) {
                        for ($i = 0; $i < $lines['LineNum']; $i++) {
                            $row = $this->request->createElement('row');
                            $secondaryBusinessObject->appendChild($row);
                        }

                        unset($lines['LineNum']);
                    }

                    $this->row($lines, function ($row) use ($secondaryBusinessObject) {
                        $secondaryBusinessObject->appendChild($row);
                    });
                }
            } else {
                $entry = $this->request->createElement($key, htmlspecialchars($value));
                $row->appendChild($entry);
            }
        }
    }

    public function row($array = array(), $callback) {
        if (is_callable($callback)) {
            $row = $this->request->createElement('row');

            foreach ($array as $key => $value) {
                $entry = $this->request->createElement($key, htmlspecialchars($value));
                $row->appendChild($entry);
            }

            call_user_func($callback, $row);
        }
    }

    public function find(array $query) {
        $this->request->withBodyElement('GetByKey');

        if (!empty($query)) {
            $this->request->setQueryParams($query);
        }

        $this->process();
    }

    public function delete(array $query) {
        $this->request->withBodyElement('RemoveObject');

        if (!empty($query)) {
            $this->request->setQueryParams($query);
        }

        $this->process();
    }

    public function cancel(array $query) {
        $this->request->withBodyElement('CancelObject');

        if (!empty($query)) {
            $this->request->setQueryParams($query);
        }

        $this->process();
    }

    public function close(array $query) {
        $this->request->withBodyElement('CloseObject');

        if (!empty($query)) {
            $this->request->setQueryParams($query);
        }

        $this->process();
    }

    public function select(string $sql) {
        $requestObject = $this->request->addToBodyNS(
            'http://www.sap.com/SBO/DIS',
            'dis:ExecuteSQL'
        );

        $query = $this->request->createElement('DoQuery', htmlspecialchars($sql));
        $requestObject->appendChild($query);

        $xml = $this->request->saveXml();
        
        try {
            $this->client->sendRequest($xml);
            return $this->client->getResponse();
        } catch (\Exception  $e) {
            throw $e;
        }
    }

    /**
     * @return mixed
     */
    protected function getLastKey()
    {
        return $this->lastKey;
    }

    /**
     * @param mixed $lastKey
     */
    protected function setLastKey($lastKey): void
    {
        $this->lastKey = $lastKey;
    }
}