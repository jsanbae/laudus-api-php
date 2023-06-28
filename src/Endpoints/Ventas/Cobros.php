<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints\Ventas;

use Jsanbae\LaudusAPIPHP\APIBase;

class Cobros extends APIBase
{
    protected $fields = [
        'receiptId',
        'receiptType.code',
        'receiptType.description',
        'issuedDate',
        'dueDate',
        'document',
        'bankOfDocument',
        'deposited',
        'bankOfDeposit.bankId',
        'bankOfDeposit.name',
        'createAccounting',
        'journalEntryDeposited.journalEntryId',
        'journalEntryDeposited.journalEntryNumber',
        'journalEntryDeposited.type',
        'notes',
        'createdBy.userId',
        'createdBy.name',
        'createdAt',
        'modifiedBy.userId',
        'modifiedBy.name',
        'modifiedAt',
        'salesInvoices.itemId',
        'salesInvoices.salesInvoiceId',
        'salesInvoices.docType.docTypeId',
        'salesInvoices.docType.name',
        'salesInvoices.docNumber',
        'salesInvoices.customer',
        'salesInvoices.customer.customerId',
        'salesInvoices.customer.name',
        'salesInvoices.customer.legalName',
        'salesInvoices.customer.VATId',
        'salesInvoices.customer.email',
        'salesInvoices.originalAmount',
        'salesInvoices.currencyCode',
        'salesInvoices.parityToMainCurrency',
        'salesInvoices.amount',
        'salesInvoices.costCenter',
        'otherDocuments',
    ];

    protected function getEndpoint():string
    {
        return 'https://api.laudus.cl/sales/receipts/';
    }
    
    protected function listEndpoint():string
    {
        return 'https://api.laudus.cl/sales/receipts/list';
    }

}