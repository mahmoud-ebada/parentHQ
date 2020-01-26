<?php
namespace App\ParentHQ\DataProviders;

use App\ParentHQ\AbstractDataProvider;

class DataProviderX extends AbstractDataProvider {

    /**
     * implementation of AbstractDataProvider  abstract mapParamToKeys method 
     */
    function mapParamToKeys()
    {
        return [
            'statusCode' => 'statusCode',
            'balanceMin' => 'parentAmount',
            'balanceMax' => 'parentAmount',
            'currency' => 'Currency'
        ];
    }
    
    /**
     * implementation of AbstractDataProvider  abstract decodeStatusCode method 
     */
    function decodeStatusCode()
    {
        return [
            1 => 'authorised',
            2 => 'decline',
            3 => 'refunded'
        ];
    }

    /**
     * format User response
     * @param object $user
     * @return array
     */
    function formatUser($user){
        return [
            'id' => $user['parentIdentification'],
            'email' => $user['parentEmail'],
            'amount' => $user['parentAmount'],
            'currency' => $user['Currency'],
            'status_code' => $this->decodeStatusCode()[$user['statusCode']],
            'created_at' => $user['registerationDate']
        ];
    }
}
?>