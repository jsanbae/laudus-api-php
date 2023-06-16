<?php

namespace Jsanbae\LaudusAPIPHP\Credentials;

use Jsanbae\LaudusAPIPHP\Credentials\ExternalCredential;

class LaudusCredential implements ExternalCredential
{
    private $username;
    private $password;
    private $vatid;


    public function __construct(string $_username, string $_password, string $_vatid)
    {
        $this->username = $_username;
        $this->password = $_password;
        $this->vatid = $_vatid;
    }

    public function __invoke()
    {
        return $this->get();
    }

    public function Type():string
    {
        return 'LaudusAPI';
    }

    public function get():array
    {
        return [
            'userName' => $this->username, 
            'password' => $this->password, 
            'companyVATId' => $this->vatid
        ];
    }
}
