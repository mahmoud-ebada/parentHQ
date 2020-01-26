<?php 
namespace App\Exceptions;
use Exception;

trait ExceptionTrait{

        /**
        * Render exception as HTTP response json object 
        * @param  \Illuminate\Http\Request  $request
        * @param  \Exception  $exception
        * @return \Illuminate\Http\Response
        */

	public function apiException($request,Exception $exception){
        return parent::render($request, $exception);
	}

	/**
	* Render Exception as json object
	* @param $exceptionName,$exceptionMessage,$statusCode
	* @return \Illuminate\Http\Response
	*/
	public function renderException($exceptionName,$exceptionMessage,$statusCode)
	{
		$exceptionJson['statusCode'] = $statusCode;
		$exceptionJson['error']['name'] = $exceptionName;
		$exceptionJson['error']['message'] = $exceptionMessage;
		return response()->json($exceptionJson,$statusCode);
	}
}
?>