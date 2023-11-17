<?php

namespace Jsanbae\LaudusAPIPHP;

use Jsanbae\LaudusAPIPHP\RequestSettings\RequestSettings;

abstract class APIBase
{
    protected $token;
    protected $fields = [];

    public function __construct(string $_token)
    {
        $this->token = $_token;
    }

    abstract protected function getEndpoint():string;
    
    abstract protected function listEndpoint():string;

    abstract protected function createEndpoint():string;
    

    public function getFields():array
    {
        if (!property_exists($this, 'fields')) throw new \Exception("The 'fields' attribute must be defined.");

        return $this->fields;
    }

    public function list(RequestSettings $_settings):array
    {
        try {
            $settings = json_encode($_settings->toArray());

            $request = curl_init($this->listEndpoint()); 
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($request, CURLOPT_POSTFIELDS, $settings);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($request, CURLOPT_HTTPHEADER, array(
                "Accept: application/json",
                "Content-Type: application/json",
                "Content-Length: " . strlen($settings),
                "Authorization: Bearer " . $this->token)
            );
            //make request
            $response = curl_exec($request);
            //respond status code
            $responseStatusCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
            curl_close($request);
            $response_decoded = (array) json_decode($response);
            return (new StdResponse($response_decoded, $responseStatusCode))();
            
        } catch (\Throwable $t) {
            throw new \Exception("Error API Connection: " . $t->getMessage() . "\n");
        }
    }

    public function get(string $_resource_id):array
    {
        try {
            $request = curl_init($this->getEndpoint() . $_resource_id);
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($request, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($request, CURLOPT_HTTPHEADER, array(
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: Bearer " . $this->token)
            );

            //make request
            $response = curl_exec($request);    
            //respond status code
            $responseStatusCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
            curl_close($request);

            $response_decoded = (array) json_decode($response);

            return (new StdResponse($response_decoded, $responseStatusCode))();
                
        } catch (\Throwable $t) {
            throw new \Exception("Error API Connection: " . $t->getMessage() . "\n");
        }
    }

    public function create(array $_body):array
    {
        try {
            $body = json_encode($_body);

            $request = curl_init($this->createEndpoint()); 
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($request, CURLOPT_POSTFIELDS, $body);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($request, CURLOPT_HTTPHEADER, array(
                "Accept: application/json",
                "Content-Type: application/json",
                "Content-Length: " . strlen($body),
                "Authorization: Bearer " . $this->token)
            );
            //make request
            $response = curl_exec($request);
            //respond status code
            $responseStatusCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
            curl_close($request);
            $response_decoded = (array) json_decode($response);
            return (new StdResponse($response_decoded, $responseStatusCode))();
            
        } catch (\Throwable $t) {
            throw new \Exception("Error API Connection: " . $t->getMessage() . "\n");
        }
    }
}
