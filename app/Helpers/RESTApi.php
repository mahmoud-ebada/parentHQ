<?php

namespace App\Helpers;
use Symfony\Component\HttpFoundation\Response;

trait RESTApi {
	
	/**
	* Return response with json object
	* @param string responseObject
	* @param string $responseKey
	* @param  Symfony\Component\HttpFoundation\Response statusCode 
	* @return \Illuminate\Http\JsonResponse
	*/
	public function sendJson($responseObject,$statusCode = Response::HTTP_OK,$responseKey = 'data'){
		$jsonResponse['statusCode'] = $statusCode;
		if($responseObject)
			$jsonResponse[$responseKey] = $responseObject;
		return response($jsonResponse,$statusCode);
	}
}
?>