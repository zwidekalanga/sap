<?php namespace App\Connectors;

use Exception;

class SapConnector {

	protected $businessObj;

	protected $sapCom;

	protected $retCode;

	public $errCode = 0;

	public $errMsg = '';

    /**
     * SapConnector constructor.
     * @param array $configs
     * @throws Exception
     */
    public function __construct(array $configs = array()) {
        try {
            $this->sapCom = new \COM('SAPbobsCOM.company') or die ('No connection');

            $this->sapCom->DbServerType = "6";
            $this->sapCom->Server = "SAPSERVER";
            $this->sapCom->LicenseServer = "SAPSERVER:30000";
            $this->sapCom->Username = $configs['username'];
            $this->sapCom->Password = $configs['password'];
            $this->sapCom->CompanyDB = $configs['database'];

            $lRetCode = $this->sapCom->Connect;

            if ($lRetCode != 0) {
                throw new Exception($this->getError($lRetCode));
            }

        } catch (com_exception $e) {
            throw $e;
        }
    }

    /**
     * @param int $errCode
     * @return string
     */
    public function getError($errCode = 0) {
        if ($this->errMsg == '') {
            $this->setError($errCode);
        }

        return $this->errMsg;
    }

    /**
     * @param $errCode
     */
    protected function setError($errCode) {
        $this->sapCom->GetLastError($errCode, $this->errMsg);

        if ($this->errMsg == '') {
            $this->errMsg = $this->sapCom->GetLastErrorDescription();
        }
    }

    public function table($name) {
        $this->businessObj = $this->sapCom->GetBusinessObject($name);
        return $this;
    }

    public function where($id, $itemTypeCode = 0) {
        if ($itemTypeCode == 0) {
            if (strlen($id) > 15) {
                throw new Exception('Key is out of index');
            }
        }

        try {
            if (!$this->businessObj->GetByKey($id)) {
                throw new Exception('Objects not found');
            }
        } catch (com_exception $e) {
            throw $e;
        }

        return $this;
    }

    public function insert($data) {
        try {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $count = 0;
                    
                    foreach ($value as $line) {
                        $this->businessObj->$key->SetCurrentLine($count);
                        $this->setLineProperties($line, $key);
                        $this->businessObj->$key->add;

                        $count++;
                    }

                } else {
                    $this->setProperties($key, $value);
                }
            }

            $RetCode = $this->businessObj->add();
            
            if ($RetCode == 0) {
                return $this->sapCom->GetNewObjectKey();
            } else {
                throw new Exception($this->getError($RetCode));
            }

        } catch (com_exception $e) {
            throw new $e;
        }
    }

    public function update($data) {
        try {
            foreach ($data as $key => $value) {
                if ($key == 'id') {
                    continue;
                }

                if (is_array($value)) {
                    foreach ($value as $line) {
                        if (isset($line['LineNum'])) {
                            $this->businessObj->$key->add;
                        }
                        $this->businessObj->$key->SetCurrentLine($lineNum);
                        $this->setLineProperties($line, $key);
                    }

                } else {
                    $this->setProperties($key, $value);
                }
            }

            $RetCode = $this->businessObj->update();

            if ($RetCode == 0) {
                return $this->sapCom->GetNewObjectKey();
            } else {
                throw new Exception($this->getError($RetCode));
            }

        } catch (com_exception $e) {
            throw new $e;
        }
    }

    private function setProperties ($key, $value, $parent = null) {
        $obj = ($parent) ? $this->businessObj->$parent : $this->businessObj;

        if (strncmp_startswith($key, 'U_')) {
            $obj->UserFields->Fields->Item($key)->Value = $value;
        } else {
            $obj->$key = $value;
        }
    }

    public function setLineProperties($line, $parent) {
        foreach ($line as $key => $item) {
            if ($key == 'LineNum') {
                continue;
            }

            $this->setProperties($key, $item, $parent);
        }
    }

    public function __destruct() {
        $this->businessObj->Disconnect;
    }
}