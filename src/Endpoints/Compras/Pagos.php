<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints\Compras;

use Jsanbae\LaudusAPIPHP\APIBase;
use Jsanbae\LaudusAPIPHP\StdResponse;

class Pagos extends APIBase
{
    protected $fields = [
        'paymentId', 
        'paymentType.code', 
        'paymentType.description', 
        'document', 
        'deposited', 
        'bank.bankId', 
        'bank.name', 
        'accountOther.accountId', 
        'accountOther.accountNumber', 
        'accountOther.name', 
        'createAccounting', 
        'journalEntryIssued.journalEntryId',
        'journalEntryIssued.journalEntryNumber',
        'journalEntryIssued.type',
        'journalEntryDeposited.journalEntryId',
        'journalEntryDeposited.journalEntryNumber',
        'journalEntryDeposited.type',
        'notes',
        'purchaseInvoices.itemId', 
        'purchaseInvoices.purchaseInvoiceId', 
        'purchaseInvoices.docType.docTypeId', 
        'purchaseInvoices.docType.name', 
        'purchaseInvoices.docNumber', 
        'purchaseInvoices.supplier.supplierId', 
        'purchaseInvoices.supplier.name', 
        'purchaseInvoices.supplier.legalName', 
        'purchaseInvoices.supplier.VATId',
        'purchaseInvoices.originalAmount',
        'purchaseInvoices.currencyCode',
        'purchaseInvoices.parityToMainCurrency',
        'purchaseInvoices.amount',
        'purchaseInvoices.costCenter.costCenterId',
        'purchaseInvoices.costCenter.name',
        'otherDocuments.itemId',
        'otherDocuments.document',
        'otherDocuments.description',
        'otherDocuments.relatedTo.relatedId',
        'otherDocuments.relatedTo.type',
        'otherDocuments.relatedTo.name',
        'otherDocuments.relatedTo.vatId',
        'otherDocuments.account.accountId',
        'otherDocuments.account.accountNumber',
        'otherDocuments.account.name',
        'otherDocuments.category.code',
        'otherDocuments.category.description',
        'otherDocuments.originalAmount',
        'otherDocuments.currencyCode',
        'otherDocuments.parityToMainCurrency',
        'otherDocuments.amount',
        'otherDocuments.costCenter.costCenterId',
        'otherDocuments.costCenter.name',
    ];

    protected function getEndpoint():string
    {
        return 'https://api.laudus.cl/purchases/payments/';
    }

    protected function listEndpoint():string
    {
        return 'https://api.laudus.cl/purchases/payments/list';
    }

    public function createEndpoint():string
    {
        return 'https://api.laudus.cl/purchases/payments/';
    }
    
}
