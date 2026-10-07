<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints;

use Jsanbae\LaudusAPIPHP\APIBase;
use Jsanbae\LaudusAPIPHP\Endpoints\Compras\Facturas;
use Jsanbae\LaudusAPIPHP\Endpoints\Compras\Pagos;
use Jsanbae\LaudusAPIPHP\Endpoints\Compras\Proveedores;

class Compras
{
    private $token;

    /** @var callable|null */
    private $refreshToken;

    public function __construct(string $_token, ?callable $refreshToken = null)
    {
        $this->token = $_token;
        $this->refreshToken = $refreshToken;
    }

    public function Facturas(): APIBase
    {
        return new Facturas($this->token, $this->refreshToken);
    }

    public function Proveedores(): APIBase
    {
        return new Proveedores($this->token, $this->refreshToken);
    }

    public function Pagos(): APIBase
    {
        return new Pagos($this->token, $this->refreshToken);
    }
   

}
