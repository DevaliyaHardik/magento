<?php
    class Hd_Process_Model_Process extends Mage_Core_Model_Abstract
    {
        CONST TYPE_IMPORT = 1;
        CONST TYPE_EXPORT = 2;
        CONST TYPE_CORN = 3;
        protected $headers = [];
        protected $filedData = [];
        protected $invalidData = [];
        protected $invalidHeaders = [];
        protected $requiredFiled = ['index','name','email','mobile'];

        public function setRequiredFiled($requiredFiled)
        {
            $this->requiredFiled = $requiredFiled;
            return $this;
        }

        public function getRequiredFiled()
        {
            if($this->requiredFiled){
                return $this->requiredFiled;
            }
            return null;
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

        public function addHeader($header,$key)
        {
            $this->headers[$key] = $header;
            return $this;
        }

        public function getHeader($key)
        {
            if($this->headers[$key]){
                return $this->headers[$key];
            }
            return null;
        }

        public function removeHeader($key)
        {
            if($this->headers[$key]){
               unlink($this->headers[$key]);
            }
            return $this;
        }

        public function setFiledDatas($filedData)
        {
            $this->filedData = $filedData;
            return $this;
        }

        public function getFiledDatas()
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

        public function setInvalidData($invalidData)
        {
            $this->invalidData = $invalidData;
            return $this;
        }

        public function getInvalidData()
        {
            if($this->invalidData){
                return $this->invalidData;
            }
            return null;
        }

        public function addInvalidData($invalidData)
        {
            $this->invalidData[] = $invalidData;
            return $this;
        }

        public function setInvalidHeaders($invalidHeaders)
        {
            $this->invalidHeaders = $invalidHeaders;
            return $this;
        }

        public function getInvalidHeaders()
        {
            if($this->invalidHeaders){
                return $this->invalidHeaders;
            }
            return null;
        }

        public function addInvalidHeader($invailHeader)
        {
            array_push($this->invalidHeaders,$invailHeader);
            return $this;
        }


        protected function _construct()
        {
            $this->_init('process/process');
        }

        public function uploadFile()
        {
            $fileName = $this->getData()['fileName'];
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
            try {
                $this->setInvalidHeaders($this->getHeaders());
                $this->addInvalidHeader('Error');
                foreach ($this->getRequiredFiled() as $key => $header) {
                    if(!in_array($header,$this->getHeaders())){
                        // $this->addHeader($header."is required","Error");
                        throw new Exception($header." Not in header.", 1);
                    }

                }
                foreach ($this->getHeaders() as $header) {
                    $columnModel = Mage::getModel('process/column');
                    $select = $columnModel->getCollection()
                            ->getSelect()
                            ->reset(Zend_Db_Select::COLUMNS)
                            ->columns(['process_id'])
                            ->where('process_id = ?', $this->getProcessId())
                            ->where('name = ?', $header);
                    $data = $columnModel->getResource()->getReadConnection()->fetchAll($select);
                    if(!$data){
                        $columnModel->setData('process_id',$this->getProcessId());
                        $columnModel->setData('name',$header);
                        $columnModel->setData('required',1);
                        if(!in_array($header,$this->getRequiredFiled())){
                            $columnModel->setData('required',0);
                        }
                        $columnModel->setData('castingType',$this->getCastingType($header));
                        $columnModel->setData('exception',0);
                        $columnModel->save();
                    }
                }
                return $this;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__($e->getMessage()));
            }
            //column reqired not existst then throw
            //replicate header into invalid header with error column
        }

        protected function validateData()
        {
            try {
                if(!$this->getFiledDatas()){
                    throw new Exception("No Data availabel in file", 1);
                }
                foreach ($this->getFiledDatas() as $key => $row) {
                    $valid = $this->validateRow($row);
                    if(count($valid) == count($row)){
                        $this->addFiledData($valid,$key);
                    }
                    else{
                        $this->removeFiledData($key);
                        $this->addInvalidData($valid);
                    }
                }
                // echo "<pre>";
                // print_r($this->getInvalidData());
                // print_r($this->filedData);
                // exit;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__($e->getMessage()));
            }
            //data not availabel then thow exception
            //loop for data
            //keep try catch
            //call validateRow method for each row
        }

        protected function validateRow($row)
        {
            foreach ($row as $key => $value) {
                $castingType = $this->getCastingType($key);
                if(in_array($key,$this->getRequiredFiled())){
                    if($value == ""){
                        $row['Error'] = $key ." is invalid";
                        return $row; 
                    }
                    if($castingType == 1){
                        if(gettype($value) == 'integer'){
                            return $row;
                        }
                        else{
                            $row[$key] = (int)$value;
                            return $row;
                        }
                    }
                    elseif($castingType == 3){
                        if(gettype($value) == 'string'){
                            return $row;
                        }
                        else{
                           $row['Error'] = $key ." is invalid";
                           return $row; 
                        }
                    }
                }
                else{
                    if($value == ""){
                        return $row; 
                    }
                    if($castingType == 1){
                        if(gettype($value) == 'integer'){
                            return $row;
                        }
                        else{
                           $row[$key] = (int)$value;
                           return $row;
                        }
                    }
                    elseif($castingType == 3){
                        if(gettype($value) == 'string'){
                            return $row;
                        }
                        else{
                            $row[$key] = (string)$row['$key'];
                            return $row;
                        }
                     }
                }
            }
        }

        protected function readFile()
        {
            $filePathName = $this->getFilePath(). DS . $this->getData()['fileName'];
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
                    $data[] = array_combine($this->headers, $row); 
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
            $this->genrateEntries();//->saveData()Varien_File_Csv 
            return true;          
        }

        protected function genrateInvalidDataReport()
        {
            $invalid = [];
            $invalid[] = $this->getInvalidHeaders();
            $data = $this->getInvalidData();
            foreach ($data as $key => $row) {
                $invalid[] = $row;
            }
            $csv = new Varien_File_Csv();
            $csv->saveData($this->getFilePath(). DS . 'invalid.csv',$invalid);

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
            ->where('process_id = ?', $this->getProcessId());
            $data = $entryModel->getResource()->getReadConnection()->fetchAll($select);
            foreach ($data as $key => $row) {
                $entries[] = json_decode($row['data']);
            }
            $csv = new Varien_File_Csv();
            $csv->saveData($this->getFilePath(). DS . 'entries.csv',$entries);
            return $entries;
        }


        protected function processEntry()
        {
            foreach ($this->getFiledDatas() as $key => $row) {
                $identifier = $this->getIdentifier($row);
                $row = $this->addFiledData($this->getJsonData($row),$key);
                $entryModel = Mage::getModel('process/entry');
                $select = $entryModel->getCollection()
                    ->getSelect()
                    ->reset(Zend_Db_Select::COLUMNS)
                    ->columns(['process_id'])
                    ->where('process_id = ?', $this->getProcessId())
                    ->where('identifier = ?', $identifier);
                $data = $entryModel->getResource()->getReadConnection()->fetchAll($select);
                if(!$data){
                    $entryModel->setData('process_id',$this->getProcessId());
                    $entryModel->setData('identifier',$identifier);
                    $entryModel->setData('startTime',date('h:s:i'));
                    $entryModel->setData('data',$this->getFiledData($key));
                    $entryModel->save();
                }
            }
            return $this;
            //data loop
            //call method prepareJsonData
            //getIdentifier method call
        }

        protected function getIdentifier($row)
        {
            return $row['name'];
        }

        protected function getJsonData($row)
        {
            return json_encode($row);
        }
        
        public function getCastingType($header)
        {
            if($header == 'index' || $header == 'mobile' || $header == 'number'){
                return Hd_Process_Model_Column::CASTING_INTEGER;
            }
            elseif($header == 'name' || $header == 'email'){
                return Hd_Process_Model_Column::CASTING_VARCHAR;
            }
        }

        public function getDefaultFile()
        {
            $defaultHeader = ['0'=>'index','1'=>'name','2'=>'email','3'=>'mobile'];
            $defaultData = ['index'=>'1','name'=>'hardik1','email'=>'hard1','mobile'=>'989898'];
            $finalData = [$defaultHeader,$defaultData];
            $csv = new Varien_File_Csv();
            $csv->saveData($this->getFilePath(). DS . 'default.csv',$finalData);
        }
    }
?>    