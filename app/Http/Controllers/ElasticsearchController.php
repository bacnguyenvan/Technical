<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Elasticsearch\ClientBuilder;

class ElasticsearchController extends Controller
{
    private $elasticClient;

    public function __construct()
    {
        $client = ClientBuilder::create()

        ->setHosts(['https://localhost:9200'])
        ->setBasicAuthentication('elastic', '123456')
        ->setSSLVerification(false)
        ->build();
        
        $this->elasticClient = $client ;
    }
    public function index()
    {
        $params = [
            'index' => 'sample_index',
            'id' => 'sample_id',
            'body' => [
                'price' => 10
            ]
        ];

        $response = $this->elasticClient->index($params);

        return $response;

    }


    public function search()
    {
        $params = [
            'index' => 'sample_index',
            'id' => 'sample_id',
            // 'body' => [
            //     'price' => 10
            // ]
        ];

        $response = $this->elasticClient->get($params);

        return $response;
    }

    public function create()
    {
        dd("qq");
    }

    public function update()
    {
        $params = [
            'index' => 'sample_index',
            'id' => 'sample_id',
            'body' => [
                'doc' => [
                    'price' => 5000
                ]
            ]
        ];

        $response = $this->elasticClient->update($params);

        return $response;
    }
}
