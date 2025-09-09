<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints;

use Jsanbae\LaudusAPIPHP\APIBase;
use Jsanbae\LaudusAPIPHP\Endpoints\Remuneracion\LibroRemuneracion;
use Jsanbae\LaudusAPIPHP\Endpoints\Remuneracion\Empleado;

class Remuneracion 
{
    private $token;

    public function __construct(string $_token)
    {
        $this->token = $_token;
    }

    public function LibroRemuneracion(): APIBase
    {
        return new LibroRemuneracion($this->token);
    }

    public function Empleado(): APIBase
    {
        return new Empleado($this->token);
    }
}