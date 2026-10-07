<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints;

use Jsanbae\LaudusAPIPHP\APIBase;
use Jsanbae\LaudusAPIPHP\Endpoints\Ventas\Clientes;
use Jsanbae\LaudusAPIPHP\Endpoints\Ventas\Cobros;
use Jsanbae\LaudusAPIPHP\Endpoints\Ventas\Facturas;

class Ventas
{
    private $token;

    /** @var callable|null */
    private $refreshToken;

    public function __construct(string $_token, ?callable $refreshToken = null)
    {
        $this->token = $_token;
        $this->refreshToken = $refreshToken;
    }

    public function Clientes(): APIBase
    {
        return new Clientes($this->token, $this->refreshToken);
    }

    public function Cobros(): APIBase
    {
        return new Cobros($this->token, $this->refreshToken);
    }

    public function Facturas(): APIBase
    {
        return new Facturas($this->token, $this->refreshToken);
    }

}
