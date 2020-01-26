<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use App\Exceptions\ExceptionTrait;

class DataProviderNotFound extends Exception
{
    use ExceptionTrait;
    
    public function render(){
        return $this->renderException("DataProviderNotFound","The provided DataProvider Not found", Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
