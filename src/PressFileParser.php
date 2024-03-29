<?php

namespace Ubuntu\Press;

use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use ReflectionClass;
use Illuminate\Support\Str;
use Ubuntu\Press\Facades\Press;

class PressFileParser
{
    protected $filename;

    protected $data;

    protected $rawData;

    public function __construct($filename)
    {
        $this->filename = $filename;

        $this->splitFile();

        $this->explodeData();

        $this->processFields();
    }

    public function getData()
    {
        return $this->data;
    }

    public function getRawData()
    {
        return $this->rawData;
    }

    protected function splitFile()
    {
        preg_match('/^\-{3}(.*?)\-{3}(.*)/s', 
            File::exists($this->filename) ? File::get($this->filename) : $this->filename, 
            $this->rawData
        );
    }
    
    protected function explodeData()
    {
        foreach(explode("\r\n", trim($this->rawData[1])) as $fieldString){
            
            preg_match('/(.*):\s?(.*)/', $fieldString, $fieldArray);

            $this->data[$fieldArray[1]] = $fieldArray[2];
        }

        $this->data['body']=trim($this->rawData[2]);
    }
     
    protected function processFields()
    {
        foreach($this->data as $field => $value){

            $class = $this->getField(Str::title($field));
          
            /*
            if( ! class_exists($class) &&
             ! method_exists($class, 'process')){
                $class = 'Ubuntu\\Press\\Fields\\Extra';
            }
            */

            $this->data = array_merge(
                    $this->data, 
                    $class::process($field, $value, $this->data),
                );
        }
    }

    private function getField($field)
    {
        foreach(Press::availableFields() as $availableField)
        {
            $class = new ReflectionClass($availableField);

            if($class->getShortName() == $field) {
                return $class->getName();
            }
        }
        return 'Ubuntu\\Press\\Fields\\Extra';
    }
}