<?php

namespace Jsanbae\LaudusAPIPHP\Credentials;

interface ExternalCredential
{
    public function get():array;
    public function Type():string;
}
