<?php
namespace App\ParentHQ;

use Exception;
use DirectoryIterator;
use Illuminate\Http\Request;
use App\Exceptions\DataProviderNotFound;

    class DataProviderFilter {
        private $data_providers = [];
        private $params = [];
        private $result = [];
        /**
         * Build query from Request object
         * @param Request
         * @return array, associative array of query params
         */
        function builderQuery(Request $request){
            if($request->all()){

                // statusCode
                if($request->has('statusCode') && null != $request->get('statusCode')){
                    $this->params['statusCode'] = [
                        'key' => 'statusCode',
                        'operator' => '=',
                        'value' => $request->get('statusCode')
                    ];
                }

                // currency
                if($request->has('currency') && null != $request->get('currency')){
                    $this->params['currency'] = [
                        'key' => 'currency',
                        'operator' => '=',
                        'value' => $request->get('currency')
                    ];
                }

                // provider
                if($request->has('provider') && null != $request->get('provider')){
                    $this->params['provider'] = $request->get('provider');
                }

                // balanceMin
                if($request->has('balanceMin') && null != $request->get('balanceMin')){
                    $this->params['balanceMin'] = [
                        'key' => 'balance',
                        'operator' => '>=',
                        'value' => $request->get('balanceMin')
                    ];
                }

                // balanceMax
                if($request->has('balanceMax') && null != $request->get('balanceMax')){
                    $this->params['balanceMax'] = [
                        'key' => 'balance',
                        'operator' => '<=',
                        'value' => $request->get('balanceMax')
                    ];
                }
            }
        }

        /**
         * Filter DataProviders by request parameters
         * @param
         * @return array list of user objects
         */
        function filter(){
            $this->loadDataProviders();
            if(count($this->data_providers)){
                if(array_key_exists('provider',$this->params)){
                    $data_provider = $this->data_providers[0];
                    $this->result = $data_provider->filter($this->params);
                } else{
                    foreach($this->data_providers as $provider){
                        $this->result = array_merge($this->result, $provider->filter($this->params));
                    }
                }
            }
            return $this->result;
        }

        /**
         * Load data providers dependos on parameter has provider or not
         */
        private function loadDataProviders(){
            $dataProvidersDirectoryPath = "\App\ParentHQ\DataProviders\\";
            if(array_key_exists('provider',$this->params)){
                $dataProviderClassName = $dataProvidersDirectoryPath.$this->params['provider'];
                if(!class_exists($dataProviderClassName)){
                    throw new DataProviderNotFound();
                }
                $this->data_providers[] = new $dataProviderClassName($this->params['provider']);
            }
            else{
                $filesInFolder = \File::files(__DIR__.'/jsons');     
                foreach($filesInFolder as $path) { 
                    $json_file_name = pathinfo($path);
                    $dataProviderClassName = $dataProvidersDirectoryPath.$json_file_name['filename'];
                    if(class_exists($dataProviderClassName)){
                        $this->data_providers[] = new $dataProviderClassName($json_file_name['filename']);
                    }
                }
            }
        }
    }
?>