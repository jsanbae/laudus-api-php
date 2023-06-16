<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints;

use Jsanbae\LaudusAPIPHP\APIBase;
use Jsanbae\LaudusAPIPHP\Endpoints\Cuentas\Bancarias;
use Jsanbae\LaudusAPIPHP\Endpoints\Cuentas\Contables;

class Cuentas
{
    private $token;

    public function __construct(string $_token)
    {
        $this->token = $_token;
    }

    public function Bancarias():APIBase
    {
        return new Bancarias($this->token);
    }

    public function Contables():APIBase
    {
        return new Contables($this->token);
    } 
}
