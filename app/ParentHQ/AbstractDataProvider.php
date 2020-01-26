<?php 
namespace App\ParentHQ;

use JsonMachine\JsonMachine;
use App\Exceptions\DataProviderJsonFileNotFound;

abstract class AbstractDataProvider {

    private $json_file_name = '';
    
    function __construct($json_file_name){
        $this->json_file_name = "{$json_file_name}.json";
    }

    /**
     * @param
     * @return string DataProvider's json file name
     */
    function getJsonFileName(){
        return $this->json_file_name;
    }

    /**
     * load json data
     * @param
     * @return string json object
     */
    function loadJsonData(){
        if(!\File::exists(__DIR__."/jsons/{$this->getJsonFileName()}")){
            throw new DataProviderJsonFileNotFound;
        }
        $json_file = file_get_contents(__DIR__."/jsons/{$this->getJsonFileName()}");
        return json_decode($json_file, true);
        // TODO: handle large json files
    }

    /**
     * Filter Data provider 
     * @param array query dictionry
     * @return array result of user objects
     */
    function filter($query){
        $result = [];
        $users = $this->loadJsonData()['users'];
        if($users){
            foreach($users as $user){
                if($this->isMatched($user, $query)){
                    $result[] = $this->formatUser($user);
                }
            }
        }
        return $result;
    }
    
    /**
     * Check if user object content matched the query params
     * @param array $user
     * @param array $query
     * @return boolean
     */
    function isMatched($user, $query){
        $is_matched = true;
        $keys = $this->mapParamToKeys();

        if(array_key_exists('statusCode', $query)){
            $is_matched = $is_matched && ($query['statusCode']['value'] == $this->decodeStatusCode()[$user[$keys['statusCode']]]);
        }

        if(array_key_exists('currency', $query)){
            $is_matched = $is_matched && ($query['currency']['value'] == $user[$keys['currency']]);
        }

        if(array_key_exists('balanceMin', $query)){
            $is_matched = $is_matched && ($user[$keys['balanceMin']] >= (int)$query['balanceMin']['value']);
        }

        if(array_key_exists('balanceMax', $query)){
            $is_matched = $is_matched && ($user[$keys['balanceMax']] <= (int)$query['balanceMax']['value']);
        }
        return $is_matched;
    }

    /**
     * @param
     * @return array assoc for statuscode values
     */
    abstract function decodeStatusCode();

    /**
    * Map query Params to data provider user's object keys
    * @param
    * @return array dictionary 
    */
   abstract function mapParamToKeys();

   /**
    * abstract method Format User 
    * @param array $user
    * @return string formated user object
    */
    abstract function formatUser($user);
}
?>