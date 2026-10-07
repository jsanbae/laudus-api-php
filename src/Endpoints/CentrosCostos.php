<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints;

use Jsanbae\LaudusAPIPHP\APIBase;

class CentrosCostos extends APIBase
{
    protected $fields = [
        "costCenterId",
        "name",
        "discontinued",
        "fullPath",
        "parentId",
        "code",
        "notes",
        "createdBy.userId",
        "createdBy.name",
        "createdAt",
        "modifiedBy.userId",
        "modifiedBy.name",
        "modifiedAt"
    ];

    public function __construct(string $_token, ?callable $refreshToken = null)
    {
        parent::__construct($_token, $refreshToken);
    }

    protected function getEndpoint(): string
    {
        return 'https://api.laudus.cl/purchases/costcenters/';
    }

    protected function createEndpoint(): string
    {
        return 'https://api.laudus.cl/purchases/costcenters';
    }

    protected function listEndpoint(): string
    {
        return 'https://api.laudus.cl/purchases/costcenters/list';
    }

    protected function deleteEndpoint(): string
    {
        return '';
    }
}
