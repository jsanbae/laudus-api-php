<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints;

use Jsanbae\LaudusAPIPHP\APIBase;

class Comprobante extends APIBase 
{
    protected $fields = [
        'journalEntryId',
        'journalEntryNumber',
        'date',
        'type',
        'typeNumber',
        'approved',
        // 'approvedBy.userId',
        // 'approvedBy.name',
        'generated',
        'generatedBy',
        'bookId',
        'notes',
        'createdBy.userId',
        'createdBy.name',
        'createdAt',
        // 'modifiedBy.userId',
        // 'modifiedBy.name',
        'modifiedAt',
        'lines.lineId',
        'lines.account.accountId',
        'lines.account.accountNumber',
        'lines.account.name',
        'lines.description',
        'lines.debit',
        'lines.credit',
        // 'lines.currencyCode',
        'lines.parityToMainCurrency',
        // 'lines.originalDebit',
        // 'lines.originalCredit',
        'lines.costCenter.costCenterId',
        'lines.costCenter.name',
        'lines.document',
        // 'lines.relatedTo.relatedId',
        // 'lines.relatedTo.type',// c = Customer, s = Supplier, e = Employee
        // 'lines.relatedTo.name',
        // 'lines.relatedTo.vatId',
    ];

    public function __construct(string $_token)
    {
        parent::__construct($_token);
    }

    protected function getEndpoint():string
    {
        return 'https://api.laudus.cl/accounting/journal/entries/';
    }

    protected function listEndpoint():string
    {
        return 'https://api.laudus.cl/accounting/journal/entries/list';
    }

    protected function createEndpoint():string
    {
        return 'https://api.laudus.cl/accounting/journal/entries/';
    }

}
