<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints;

use Jsanbae\LaudusAPIPHP\APIBase;
use Jsanbae\LaudusAPIPHP\Endpoints\Compras\Facturas;
use Jsanbae\LaudusAPIPHP\Endpoints\Compras\Pagos;
use Jsanbae\LaudusAPIPHP\Endpoints\Compras\Proveedores;

class Compras
{
    private $token;

    public function __construct(string $_token)
    {
        $this->token = $_token;
    }

    public function Facturas(): APIBase
    {
        return new Facturas($this->token);
    }

    public function Proveedores(): APIBase
    {
        return new Proveedores($this->token);
    }

    public function Pagos(): APIBase
    {
        return new Pagos($this->token);
    }
   

}
