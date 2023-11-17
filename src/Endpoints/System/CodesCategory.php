<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints\System;

use Jsanbae\LaudusAPIPHP\APIBase;

class CodesCategory extends APIBase
{
    protected $fields = [
        'categoryId',
        'codeCategoryId',
        'description',
    ];

    protected function getEndpoint():string
    {
        return '';
    }
    
    protected function listEndpoint():string
    {
        return 'https://api.laudus.cl/system/codes/category/list';
    }

    protected function createEndpoint():string
    {
        return '';
    }

}