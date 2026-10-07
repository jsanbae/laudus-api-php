<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints;

use Jsanbae\LaudusAPIPHP\APIBase;
use Jsanbae\LaudusAPIPHP\Endpoints\Cuentas\Bancarias;
use Jsanbae\LaudusAPIPHP\Endpoints\Cuentas\Contables;

class Cuentas
{
    private $token;

    /** @var callable|null */
    private $refreshToken;

    public function __construct(string $_token, ?callable $refreshToken = null)
    {
        $this->token = $_token;
        $this->refreshToken = $refreshToken;
    }

    public function Bancarias(): APIBase
    {
        return new Bancarias($this->token, $this->refreshToken);
    }

    public function Contables(): APIBase
    {
        return new Contables($this->token, $this->refreshToken);
    } 
}
