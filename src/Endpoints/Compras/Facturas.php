<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints\Compras;

use Jsanbae\LaudusAPIPHP\APIBase;


class Facturas extends APIBase
{
    protected $fields = [
        "purchaseInvoiceId",
        "docType.docTypeId",
        "docType.name",
        "docNumber",
        "description",
        "supplier.supplierId",
        "supplier.name",
        "supplier.legalName",
        "supplier.VATId",
        "issuedDate",
        "dueDate",
        "fiscalPeriod",
        "receivedBySIIAt",
        "nullDoc",
        "totals.exempt",
        "totals.net",
        "totals.tariff",
        "totals.VAT",
        "totals.total",
        "totals.currencyCode",
        "totals.parity",
        "totalsOriginalCurrency.net",
        "totalsOriginalCurrency.total",
        "totalsOriginalCurrency.currencyCode",
        "totalsOriginalCurrency.parity",
        "payInOriginalCurrency",
        "createAccounting",
        "references.description",
        "createdBy.userId",
        "createdBy.name",
        "createdAt",
        "modifiedBy.userId",
        "modifiedBy.name",
        "modifiedAt",
        "costCenterAllocation.allocationId",
        "costCenterAllocation.costCenter.costCenterId",
        "costCenterAllocation.costCenter.name",
        "costCenterAllocation.percentage",
        "items.itemId",
        "items.product.productId",
        "items.product.sku",
        "items.product.description",
        "items.product.unitOfMeasure",
        "items.product.allowFreeDescription",
        "items.product.applyGeneralVATRate",
        "items.product.vatRate",
        "items.itemDescription",
        "items.quantity",
        "items.unitCost",
        "items.lot.lot",
        "items.costCenter.costCenterId",
        "items.costCenter.name",
        // "items.account.accountId",
        // "items.account.accountNumber",
        // "items.account.name"
    ];

    protected function getEndpoint(): string
    {
        return 'https://api.laudus.cl/purchases/invoices/';
    }

    protected function listEndpoint(): string
    {
        return 'https://api.laudus.cl/purchases/invoices/list';
    }

    protected function createEndpoint(): string
    {
        return 'https://api.laudus.cl/purchases/invoices/';
    }

    protected function deleteEndpoint(): string
    {
        return '';
    }
    
}
