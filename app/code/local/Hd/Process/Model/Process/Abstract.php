<?php
class Hd_Process_Model_Process_Abstract extends Mage_Core_Model_Abstract
{
    protected $headers = [];
    protected $filedData = [];
    protected $invalidDatas = [];
    protected $requiredFiled = [];
    protected $processColumn = [];
    protected $currentRow = [];
    protected $currentRowTmp = [];
    protected $process = null;

    protected function _construct()
    {
        $this->_init('process/abstract');
    }

    public function getProcess()
    {
        if($this->process){
            return $this->process;
        }
        return null;
    }

    public function setProcess($process)
    {
        $this->process = $process;
        return $this;            
    }

    public function getRequiredFiled()
    {
        if($this->requiredFiled){
            return $this->requiredFiled;
        }
        $model = Mage::getModel('process/column');
        $columnModel = Mage::getModel('process/column');
        $select = $columnModel->getCollection()
                ->getSelect()
                ->reset(Zend_Db_Select::COLUMNS)
                ->columns(['name','required','castingType'])
                ->where('process_id = ?', $this->getProcess()->getProcessId())
                ->where('required = ?', 1);
        $this->requiredFiled = $columnModel->getResource()->getReadConnection()->fetchAll($select);
        return $this->requiredFiled;
    }

    public function getProcessColumn()
    {
        if($this->processColumn){
            return $this->processColumn;
        }
        $model = Mage::getModel('process/column');
        $columnModel = Mage::getModel('process/column');
        $select = $columnModel->getCollection()
                ->getSelect()
                ->where('process_id = ?', $this->getProcess()->getProcessId());
        $this->processColumn = $columnModel->getResource()->getReadConnection()->fetchAll($select);
        // $this->processColumn = array_combine($this->getHeaders(),$data);
        return $this->processColumn;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    public function getHeaders()
    {
        if($this->headers){
            return $this->headers;
        }
        return null;
    }

    public function getCurrentRowTmp()
    {
        if(!$this->currentRowTmp){
            $this->currentRowTmp = array_combine(array_keys($this->currentRow),array_fill(0,count($this->currentRow),null));
        }
        return $this->currentRowTmp;
    }

    public function setFiledDatas($filedData)
    {
        $this->filedData = $filedData;
        return $this;
    }

    public function &getFiledDatas()
    {
        if($this->filedData){
            return $this->filedData;
        }
        return null;
    }

    public function addFiledData($filedData,$key)
    {
        $this->filedData[$key] = $filedData;
        return $this;
    }

    public function getFiledData($key)
    {
        if($this->filedData[$key]){
            return $this->filedData[$key];
        }
        return null;
    }

    public function removeFiledData($key)
    {
        if($this->filedData[$key]){
           unset($this->filedData[$key]);
        }
        return $this;
    }

    public function setInvalidDatas($invalidDatas)
    {
        $this->invalidDatas = $invalidDatas;
        return $this;
    }

    public function getInvalidDatas()
    {
        if($this->invalidDatas){
            return $this->invalidDatas;
        }
        return null;
    }

    public function addInvalidData($invalidData)
    {
        $this->invalidDatas[] = $invalidData;
        return $this;
    }

    public function uploadFile()
    {
        $fileName = $this->getProcess()->getData()['fileName'];
        $uploder = new Varien_File_Uploader('fileName');
        $uploder->setAllowCreateFolders(true)
	        ->setAllowRenameFiles(true)
	        ->setAllowedExtensions(['csv'])
	        ->save($this->getFilePath(),$fileName);

        return $this;    
    }

    public function getFilePath()
    {
        return Mage::getBaseDir('media'). DS . 'process'. DS .'import';
    }

    protected function validateHeaders()
    {
        $requiredFiled = array_column($this->getRequiredFiled(),'name');
        if($missingHeaders = array_diff($requiredFiled, $this->getHeaders())){
            throw new Exception("Mising Headers : ". implode(', ',$missingHeaders), 1); 
        }
    }

    protected function validateData()
    {
        if(!$this->getFiledDatas()){
            throw new Exception("No Data availabel in file", 1);
        }
        foreach ($this->getFiledDatas() as $key => &$row) {
            try{
                $this->_validateRow($row);
                $row = $this->validateRow($row);
                $this->_prepareRow($row);
            }catch(Exception $e){
                $this->currentRow['message'] = $e->getMessage();
                $this->addInvalidData($this->currentRow);
                $this->removeFiledData($key);
            }
        }
        // echo "<pre>";
        // print_r($this->getInvalidDatas());
        // print_r($this->getFiledDatas());exit;
    }

    public function validateRow($row)
    {
        return $row;
    }

    public function prepareProcessColumn()
    {
        $keys = [];
        foreach ($this->getProcessColumn() as $key => $column) {
            if(in_array($column['name'],$this->getHeaders())){
                $keys[] = $key;
            }
        }
        foreach ($keys as $key) {
            $processColumn[$this->getProcessColumn()[$key]['name']] = $this->getProcessColumn()[$key];
        }
        return $processColumn;
    }

    protected function _validateRow($row)
    {
        $this->currentRow = $row;
        $tmpRow = $this->getCurrentRowTmp();
        $invalid = false;
        $processColumn = $this->prepareProcessColumn();
        foreach ($this->currentRow as $key => $value) {
            try {
                if($key == 'Index'){
                    $tmpRow[$key] = $value;
                    continue;
                }
                $this->currentRow[$key] = $this->validateRowValueCasting($value,$processColumn[$key]['castingType'],$processColumn[$key]['required']);

            } catch (Exception $e) {
                $invalid = true;
                $tmpRow[$key] = $value;
            }
        }
        if($invalid){
            $this->currentRow = $tmpRow;
            throw new Exception("Invalid row.", 1);
        }
        return $this->currentRow;
    }

    protected function validateRowValueCasting($value,$castingType,$required)
    {
        return $value;
        // if($required == 1){
        //     if(empty($value)){
        //         throw new Exception("Invalid", 1);
        //     }
        //     if($castingType == 1){
        //         if(!$value = (int)$value){
        //             throw new Exception("Invalid", 1);
        //         }
        //         return $value;
        //     }
        //     elseif($castingType == 3){
        //         if(!$value = (string)$value){
        //             throw new Exception("Invalid", 1);
        //         }
        //         return $value;
        //     }        
        // }
        // else{
        //     if(empty($value)){
        //         return null;
        //     }
        //     if($castingType == 1){
        //         if(!$value = (int)$value){
        //             return '';
        //         }
        //         return $value;
        //     }
        //     elseif($castingType == 3){
        //         if(!$value = (string)$value){
        //             return '';
        //         }
        //         return $value;
        //     }           
        // }
    }

    protected function readFile()
    {
        $filePathName = $this->getFilePath(). DS . $this->getProcess()->getData()['fileName'];
        $handler = fopen($filePathName, "r");
        $headerFlag = false;
        $data = [];
        while ($row = fgetcsv($handler)) 
        {        
            if($headerFlag == false){
                $this->setHeaders($row);
                $this->validateHeaders();
                $headerFlag = true;
            }
            else{
                $data[] = array_combine($this->getHeaders(), $row); 
            }
        }
        $this->setFiledDatas($data);
    }

    public function verify()
    {
        $this->readFile();
        $this->validateData();
        $this->processEntry();
        $this->genrateInvalidDataReport();//->saveData()Varien_File_Csv
        // echo "<pre>";
        // print_r($this->getInvalidDatas());
        // print_r($this->getFiledDatas());
        // exit;

        return true;          
    }

    protected function _prepareRow(&$row)
    {
        $entry = [
            'process_id' => $this->getProcess()->getProcessId(),
            'identifier' => $this->getIdentifier($row),
            'data' => null,
        ];
        $tabelRow = $this->prepareRowForJson($row);
        $entry['data'] = json_encode($tabelRow);
        $row = $entry;

    }

    public function prepareRowForJson($row)
    {
        return $row;
    }

    protected function processEntry()
    {
        $entryModel = Mage::getModel('process/entry');
        $readConnection = $entryModel->getResource()->getReadConnection();
        if($this->getFiledDatas()){
            $readConnection->insertOnDuplicate($entryModel->getResource()->getMainTable(),$this->getFiledDatas());
        }
    }

    public function getIdentifier($row)
    {
        return null;
    }

    protected function getJsonData($row)
    {
        return json_encode($row);
    }

    protected function genrateInvalidDataReport()
    {
        $csv = new Varien_File_Csv();
        $headers = $this->getHeaders();
        array_push($headers,'message');
        $data = $this->getInvalidDatas();
        array_unshift($data, $headers);
        $csv->saveData($this->getFilePath(). DS .'invalid.csv',$data);
    }

    protected function genrateEntries()
    {
        $entries = [];
        $entries[] = $this->getHeaders();
        $entryModel = Mage::getModel('process/entry');
        $select = $entryModel->getCollection()
        ->getSelect()
        ->reset(Zend_Db_Select::COLUMNS)
        ->columns(['data'])
        ->where('process_id = ?', $this->getProcess()->getProcessId());
        $data = $entryModel->getResource()->getReadConnection()->fetchAll($select);
        foreach ($data as $key => $row) {
            $entries[] = json_decode($row['data']);
        }
        $csv = new Varien_File_Csv();
        $csv->saveData($this->getFilePath(). DS . 'entries.csv',$entries);
        return $entries;
    }

    public function execute()
    {
        $time = date('Y-m-d h:s:i');
        $entry = Mage::getModel('process/entry');
        $select = $entry->getCollection()
            ->getSelect()
            ->where('process_id = ?', $this->getProcess()->getProcessId())
            ->where('startTime IS NULL')
            ->limit($this->getProcess()->getData('perRequestCount'));
        $entryData = $entry->getResource()->getReadConnection()->fetchAll($select);
        if(!$entryData){
            throw new Exception("No recored remaining to execte", 1);
        }
        $where = 'entry_id IN('.implode(', ',array_column($entryData,'entry_id')).')';
        $update = Mage::getSingleton('core/resource')->getConnection('core_write');
        $update->update($entry->getResource()->getMainTable(), ['startTime' => $time], $where);
        $this->import($entryData);
        $update->update($entry->getResource()->getMainTable(), ['endTime' => $time], $where);
    }

    public function import($entryData)
    {
        foreach ($entryData as $key => $entry) {
            $requestModel = Mage::getModel($this->getProcess()->getData('requestModel'));
            $requestModel->setData(json_decode($entry['data'], true));
            if(!$requestModel->save()){
                throw new Exception("Data was not processed", 1);
            }
        }
    }

    public function getRequired($row)
    {
        foreach ($row as $key => $value) {
            if($value == 1){
                $row[$key] = "Required";
            }
            else{
                $row[$key] = "Not Required";
            }
        }
        return $row;
    }
    
    public function getSampleFile()
    {
        $columnModel = Mage::getModel('process/column');
        $select = $columnModel->getCollection()
            ->getSelect()
            ->reset(Zend_Db_Select::COLUMNS)
            ->columns(['name','sampleData','required'])
            ->where('process_id = ?', $this->getProcess()->getProcessId());
        $data = $columnModel->getResource()->getReadConnection()->fetchAll($select);
        // print_r($this->getRequired(array_column($data,'required')));exit;
        $finalData = [array_column($data,'name'),array_column($data,'sampleData'),$this->getRequired(array_column($data,'required'))];
        $csv = new Varien_File_Csv();
        $csv->saveData($this->getFilePath(). DS . 'sample.csv',$finalData);
        return true;
    }
}