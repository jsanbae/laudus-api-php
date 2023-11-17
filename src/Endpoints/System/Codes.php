<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints\System;

use Jsanbae\LaudusAPIPHP\APIBase;

class Codes extends APIBase
{
    protected $fields = [
        'codeId',
        'code',
        'description',
        'abbreviation',
        'category.codeCategoryId',
        'category.description',
        'discontinued',
        'order',
        'allowChanges',
        'metadata'
    ];

    protected function getEndpoint():string
    {
        return 'https://api.laudus.cl/system/codes/';
    }
    
    protected function listEndpoint():string
    {
        return 'https://api.laudus.cl/system/codes/list';
    }

    protected function createEndpoint():string
    {
        return 'https://api.laudus.cl/system/codes/';
    }

}