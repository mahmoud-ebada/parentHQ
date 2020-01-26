<?php

namespace App\Exceptions;

use Exception;
use App\Exceptions\ExceptionTrait;

class DataProviderJsonFileNotFound extends Exception
{
    use ExceptionTrait;
    
    public function render(){
        return $this->renderException("DataProviderJsonFileNotFound","The json file for provided DataProvider Not found",422);
    }
}
