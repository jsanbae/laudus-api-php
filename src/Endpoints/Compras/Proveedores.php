<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints\Compras;

use Jsanbae\LaudusAPIPHP\APIBase;

class Proveedores extends APIBase
{
    protected $fields = [
        'supplierId',
        'name',
        'notes', 
        'createdAt', 
        'createdBy', 
        'modifiedAt'
    ];

    protected function getEndpoint():string
    {
        return 'https://api.laudus.cl/purchases/suppliers/';
    }

    protected function listEndpoint():string
    {
        return 'https://api.laudus.cl/purchases/suppliers/list';
    }
}
