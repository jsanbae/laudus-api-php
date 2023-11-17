<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints;

use Jsanbae\LaudusAPIPHP\APIBase;
use Jsanbae\LaudusAPIPHP\Endpoints\System\Codes;
use Jsanbae\LaudusAPIPHP\Endpoints\System\CodesCategory;

class System
{
    private $token;

    public function __construct(string $_token)
    {
        $this->token = $_token;
    }

    public function Codes():APIBase
    {
        return new Codes($this->token);
    }

    public function CodesCategory():APIBase
    {
        return new CodesCategory($this->token);
    }
}
