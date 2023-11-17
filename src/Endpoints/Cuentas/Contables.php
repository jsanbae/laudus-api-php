<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints\Cuentas;

use Jsanbae\LaudusAPIPHP\APIBase;

class Contables extends APIBase
{
    protected $fields = [
        'accountId',
        'accountNumber',
        'name',
        'notes', 
        'createdAt', 
        'createdBy', 
        'modifiedAt'
    ];

    protected function getEndpoint():string
    {
        return 'https://api.laudus.cl/accounting/accounts/';
    }
    
    protected function listEndpoint():string
    {
        return 'https://api.laudus.cl/accounting/accounts/list';
    }

    protected function createEndpoint():string
    {
        return 'https://api.laudus.cl/accounting/accounts/';
    }
}
