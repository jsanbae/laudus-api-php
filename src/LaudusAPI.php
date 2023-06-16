<?php

namespace Jsanbae\LaudusAPIPHP;

use Jsanbae\LaudusAPIPHP\StdResponse;
use Jsanbae\LaudusAPIPHP\Endpoints\Compras;
use Jsanbae\LaudusAPIPHP\Endpoints\Cuentas;
use Jsanbae\LaudusAPIPHP\Credentials\LaudusCredential;

class LaudusAPI
{
    const LOGIN = 'https://api.laudus.cl/security/login';
    private $credential;
    private $jwt;

    public function __construct(LaudusCredential $_credential)
    {
        $this->credential = $_credential;
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

}
