<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints;

use Jsanbae\LaudusAPIPHP\APIBase;
use Jsanbae\LaudusAPIPHP\Endpoints\System\Codes;
use Jsanbae\LaudusAPIPHP\Endpoints\System\CodesCategory;

class System
{
    private $token;

    /** @var callable|null */
    private $refreshToken;

    public function __construct(string $_token, ?callable $refreshToken = null)
    {
        $this->token = $_token;
        $this->refreshToken = $refreshToken;
    }

    public function Codes(): APIBase
    {
        return new Codes($this->token, $this->refreshToken);
    }

    public function CodesCategory(): APIBase
    {
        return new CodesCategory($this->token, $this->refreshToken);
    }
}
