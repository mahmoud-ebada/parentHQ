<?php
namespace App\ParentHQ\DataProviders;

use App\ParentHQ\AbstractDataProvider;

class DataProviderY extends AbstractDataProvider {

    /**
     * implementation of AbstractDataProvider  abstract mapParamToKeys method 
     */
    function mapParamToKeys()
    {
        return [
            'statusCode' => 'status',
            'balanceMin' => 'balance',
            'balanceMax' => 'balance',
            'currency' => 'currency'
        ];
    }
    
    /**
     * implementation of AbstractDataProvider  abstract decodeStatusCode method 
     */
    function decodeStatusCode()
    {
        return [
            100 => 'authorised',
            200 => 'decline',
            300 => 'refunded'
        ];
    }

    /**
     * format User response
     * @param object $user
     * @return array
     */
    function formatUser($user){
        return [
            'id' => $user['id'],
            'email' => $user['email'],
            'amount' => $user['balance'],
            'currency' => $user['currency'],
            'status_code' => $this->decodeStatusCode()[$user['status']],
            'created_at' => \Carbon\Carbon::createFromFormat("d/m/Y", $user['created_at'])->format('Y-m-d')
        ];
    }
}
?>