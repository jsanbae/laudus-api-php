<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints;

use Jsanbae\LaudusAPIPHP\APIBase;
use Jsanbae\LaudusAPIPHP\Endpoints\Ventas\Cobros;
use Jsanbae\LaudusAPIPHP\Endpoints\Ventas\Facturas;

class Ventas
{
    private $token;

    public function __construct(string $_token)
    {
        $this->token = $_token;
    }

    public function Cobros():APIBase
    {
        return new Cobros($this->token);
    }

    public function Facturas():APIBase
    {
        return new Facturas($this->token);
    }

}
