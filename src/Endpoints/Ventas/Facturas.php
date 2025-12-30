<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints\Ventas;

use Jsanbae\LaudusAPIPHP\APIBase;

class Facturas extends APIBase
{
    protected $fields = [
        "salesInvoiceId",

        "docType.docTypeId",
        "docType.name",

        "docNumber",

        "customer.customerId",
        "customer.name",
        "customer.legalName",
        "customer.VATId",
        "customer.email",
        "contact.contactId",
        "contact.firstName",
        "contact.lastName",
        "contact.VATId",
        "contact.email",

        "salesman.salesmanId",
        "salesman.name",

        "dealer.dealerId",
        "dealer.name",

        "carrier.carrierId",
        "carrier.name",

        "priceList.priceListId",
        "priceList.name",

        "term.termId",
        "term.name",

        "branch.branchId",
        "branch.name",

        // "pos.posId",
        // "pos.name",

        "warehouse.warehouseId",
        "warehouse.name",

        "issuedDate",
        "dueDate",
        "nullDoc",

        "totals.net",
        "totals.vat",
        // "totals.taxes.taxId",
        // "totals.taxes.taxName",
        // "totals.taxes.amount",
        "totals.vatWithheld",
        "totals.notInvoiceable_income",
        "totals.notInvoiceable_total",
        "totals.total",
        "totals.currencyCode",
        "totals.parity",

        "totalsOriginalCurrency.net",
        "totalsOriginalCurrency.vat",
        // "totalsOriginalCurrency.taxes.taxId",
        // "totalsOriginalCurrency.taxes.taxName",
        // "totalsOriginalCurrency.taxes.amount",
        "totalsOriginalCurrency.vatWithheld",
        "totalsOriginalCurrency.notInvoiceable_income",
        "totalsOriginalCurrency.notInvoiceable_total",
        "totalsOriginalCurrency.total",
        "totalsOriginalCurrency.currencyCode",
        "totalsOriginalCurrency.parity",

        "payInOriginalCurrency",
        "SII_transactionType",
        // "SII_serviceType",
        "referenceType",
        "purchaseOrderNumber",

        "deliveryAddress.addressId",
        // "deliveryAddress.description",
        "deliveryAddress.address",
        "deliveryAddress.city",
        "deliveryAddress.county",
        "deliveryAddress.zipCode",
        "deliveryAddress.state",
        "deliveryAddress.country",

        "deliveryCost",
        "deliveryNotes",
        "deliveryVehiclePlate",
        "bypassCreditLimit",

        "source.code",
        "source.description",

        "sourceOrderId",
        "notes",
        // "createAccounting",

        // "journalEntry.journalEntryId",
        // "journalEntry.journalEntryNumber",
        // "journalEntry.type",

        // "exportData.incoterm.code",
        // "exportData.incoterm.description",
        // "exportData.amountIncoterm",
        // "exportData.salesAgreement.code",
        // "exportData.salesAgreement.description",
        // "exportData.freightType.code",
        // "exportData.freightType.description",
        // "exportData.portFrom.code",
        // "exportData.portFrom.description",
        // "exportData.portTo.code",
        // "exportData.portTo.description",
        // "exportData.terms.code",
        // "exportData.terms.description",

        // "DTE.trackId",
        // "DTE.documentStatus",
        // "DTE.uploadStatus",
        // "DTE.sentToCustomerAt",

        // "references.referenceId",
        // "references.docType.docTypeId",
        // "references.docType.name",
        // "references.code",
        // "references.date",
        // "references.document",
        // "references.description",

        "createdBy.userId",
        "createdBy.name",

        "createdAt",

        "modifiedBy.userId",
        "modifiedBy.name",
        "modifiedAt",

        // "customFields.additionalProp1",
        // "customFields.additionalProp2",
        // "customFields.additionalProp3",

        "items.itemId",
        "items.itemOrder",
            
        "items.product.productId",
        "items.product.sku",
        "items.product.description",
        "items.product.unitOfMeasure",
        "items.product.allowFreeDescription",
        // "items.product.allowUserChangePrices",
        // "items.product.applyGeneralVATRate",
        "items.product.maxDiscount",
                
        "items.itemDescription",
        "items.quantity",
        "items.originalUnitPrice",
        "items.currencyCode",
        "items.parityToMainCurrency",
        "items.unitPrice",
        // "items.VAT",
        // "items.VATRate",

        // "items.taxes.taxId",
        // "items.taxes.taxName",
        // "items.taxes.amount",
     
        "items.discountPercentage",
                
        "items.lot.lot",
        "items.lot.expiration",
                
        // "items.salesmanCommission",
        // "items.dealerCommission",
        "items.noteOfCreditType",
        "items.notInvoiceable",
        "items.notInvoiceable_isIncome",

        "items.costCenter.costCenterId",
        "items.costCenter.name",

        "items.account.accountId",
        "items.account.accountNumber",
        "items.account.name",
                
        "items.traceFrom.traceId",
        "items.traceFrom.fromStep",
        "items.traceFrom.fromId",
                  
        // "items.customFields.additionalProp1",
        // "items.customFields.additionalProp2",
        // "items.customFields.additionalProp3",
    ];

    protected function getEndpoint(): string
    {
        return 'https://api.laudus.cl/sales/invoices/';
    }
    
    protected function listEndpoint(): string
    {
        return 'https://api.laudus.cl/sales/invoices/list';
    }

    protected function createEndpoint(): string
    {
        return 'https://api.laudus.cl/sales/invoices';
    }

    protected function deleteEndpoint(): string
    {
        return '';
    }

}