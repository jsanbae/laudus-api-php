<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints;

use Jsanbae\LaudusAPIPHP\APIBase;
use Jsanbae\LaudusAPIPHP\Endpoints\Remuneracion\LibroRemuneracion;
use Jsanbae\LaudusAPIPHP\Endpoints\Remuneracion\Empleado;

class Remuneracion 
{
    private $token;

    /** @var callable|null */
    private $refreshToken;

    public function __construct(string $_token, ?callable $refreshToken = null)
    {
        $this->token = $_token;
        $this->refreshToken = $refreshToken;
    }

    public function LibroRemuneracion(): APIBase
    {
        return new LibroRemuneracion($this->token, $this->refreshToken);
    }

    public function Empleado(): APIBase
    {
        return new Empleado($this->token, $this->refreshToken);
    }
}