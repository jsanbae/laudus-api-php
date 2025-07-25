<?php

namespace Jsanbae\LaudusAPIPHP;

use Jsanbae\LaudusAPIPHP\StdResponse;
use Jsanbae\LaudusAPIPHP\Credentials\LaudusCredential;
use Jsanbae\LaudusAPIPHP\Endpoints\CentrosCostos;
use Jsanbae\LaudusAPIPHP\Endpoints\Compras;
use Jsanbae\LaudusAPIPHP\Endpoints\Comprobante;
use Jsanbae\LaudusAPIPHP\Endpoints\Cuentas;
use Jsanbae\LaudusAPIPHP\Endpoints\Mayor;
use Jsanbae\LaudusAPIPHP\Endpoints\Productos;
use Jsanbae\LaudusAPIPHP\Endpoints\System;
use Jsanbae\LaudusAPIPHP\Endpoints\Ventas;

class LaudusAPI
{
    const LOGIN = 'https://api.laudus.cl/security/login';
    private $credential;
    private $jwt;

    public function __construct(LaudusCredential $_credential)
    {
        $this->credential = $_credential;

        $getTokenResponse = $this->getToken();

        if ($getTokenResponse['status'] === 'error') throw new \Exception("Error API Connection: " . $getTokenResponse['message'] . "\n");

        $this->jwt = $this->getToken()['data'];
    }

    //obtiene un token realizando un request a la API
    public function getToken():array
    {
        //esquema de request Login
        $requestBodyJson = json_encode($this->credential->get());
        
        try {
            $request = curl_init(self::LOGIN);
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($request, CURLOPT_POSTFIELDS, $requestBodyJson);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($request, CURLOPT_HTTPHEADER, [
                "Accept: application/json",
                "Content-type: application/json", 
                "Content-Length: ".strlen($requestBodyJson)
            ]);

            //make post
            $response = curl_exec($request);
            //respond status code
            $responseStatusCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
            
            // close cURL resource, and free up system resources
            curl_close($request); 
            
            $response_decoded = (array) json_decode($response);

            return (new StdResponse($response_decoded, $responseStatusCode))();

        } catch (\Throwable $t) {
            throw new \Exception("Error API Connection: " . $t->getMessage() . "\n");
        }
    }

    //indica si el token almacenado en el objeto credential es válido
    //si el token almacenado no es válido obtiene un nuevo token e igualmente indica su validez
    public function isValidToken($token):bool
    {
        $ltNow = new \DateTimeImmutable();
        $ltNow = $ltNow->format('c');

        if (isset($token['expiration']) && $token['expiration'] >= $ltNow) return true;
        
        return false;
    }

    private function reValidatedToken():string
    {
        return (!$this->isValidToken($this->jwt)) ? $this->getToken()['token'] : $this->jwt['token'];
    }

    public function Cuentas():Cuentas
    {
        $jwt = $this->reValidatedToken();

        return new Cuentas($jwt);
    }

    public function Compras():Compras
    {
        $jwt = $this->reValidatedToken();

        return new Compras($jwt);
    }
    
    public function Ventas():Ventas
    {
        $jwt = $this->reValidatedToken();

        return new Ventas($jwt);
    }

    public function Mayor():Mayor
    {
        $jwt = $this->reValidatedToken();

        return new Mayor($jwt);
    }
    public function Comprobante():Comprobante
    {
        $jwt = $this->reValidatedToken();

        return new Comprobante($jwt);
    }

    public function CentrosCostos(): CentrosCostos 
    {
        $jwt = $this->reValidatedToken();

        return new CentrosCostos($jwt);
    }

    public function System():System
    {
        $jwt = $this->reValidatedToken();

        return new System($jwt);
    }

    public function Productos():Productos
    {
        $jwt = $this->reValidatedToken();

        return new Productos($jwt);
    }

}
