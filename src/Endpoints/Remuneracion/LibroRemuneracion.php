<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints\Remuneracion;

use Jsanbae\LaudusAPIPHP\APIBase;

class LibroRemuneracion extends APIBase 
{
    protected $fields = [
        "payrollId",
        "date",
        "notes",
    ];

    public function __construct(string $_token)
    {
        parent::__construct($_token);
    }

    protected function getEndpoint(): string
    {
        return 'https://api.laudus.cl/hr/payroll/';
    }

    protected function listEndpoint(): string
    {
        return 'https://api.laudus.cl/hr/payroll/list';
    }

    protected function createEndpoint(): string
    {
        return '';
    }

    protected function deleteEndpoint(): string
    {
        return '';
    }

}