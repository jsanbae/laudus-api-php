<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints\Ventas;

use Jsanbae\LaudusAPIPHP\APIBase;

class Clientes extends APIBase
{
    protected $fields = [
        'customerId',
        'name',
        'legalName',
        'VATId',
        'activityName',
        'account.accountId',
        'account.accountNumber',
        'account.name',
        'dealer.dealerId',
        'dealer.name',
        'term.termId',
        'term.name',
        // 'priceList',
        // 'customerCategory',
        // 'salesman',
        'address',
        'city',
        'county',
        'zipCode',
        'state',
        'country',
        'foreigner',
        'phone1',
        'phone2',
        'email',
        'DTEEmail',
        'creditLimit',
        'daysToExpiration',
        'discount',
        'blocked',
        'notes',
        'createdBy.userId',
        'createdBy.name',
        'createdAt',
        'modifiedBy.userId',
        'modifiedBy.name',
        'modifiedAt',
    ];

    public function __construct(string $_token)
    {
        parent::__construct($_token);
    }

    protected function getEndpoint(): string
    {
        return 'https://api.laudus.cl/sales/customers/';
    }

    protected function listEndpoint(): string
    {
        return 'https://api.laudus.cl/sales/customers/list';
    }

    protected function createEndpoint(): string
    {
        return 'https://api.laudus.cl/sales/customers/';
    }

    protected function updateEndpoint(): string
    {
        return 'https://api.laudus.cl/sales/customers/';
    }

    protected function deleteEndpoint(): string
    {
        return 'https://api.laudus.cl/sales/customers/';
    }
}
