<?php

namespace App\Http\Controllers;

use App\Helpers\RESTApi;
use Illuminate\Http\Request;
use App\ParentHQ\DataProviderFilter;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use RESTApi;
    public function index(Request $request){
        $dataProviderFilter = new DataProviderFilter();
        $dataProviderFilter->builderQuery($request);
        $filteredData = $dataProviderFilter->filter();
        return $this->sendJson($filteredData);
    }
}
