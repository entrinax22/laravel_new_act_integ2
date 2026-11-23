<?php

namespace App\Http\Controllers;

use App\Services\APIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalAPIController extends Controller
{
    public function index(APIService $apiService, Request $request){
        try{   

            $limit = $request->query('limit', 5);
            $result = $apiService->products($limit);

            return view('api.products', [
                'products' => $result['products'],
                'error' => $result['error']
            ]);

        }catch(\Exception $e){
            Log::error('Error fetching products from DummyJSON API: '.$e->getMessage());
            return view('api.products', [
                'products' => [],
                'error' => 'An error occurred while fetching products. Please try again later.'
            ]);
        }
    }
}
