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
        "monthlyPosition", 
        "description", 
        "supplier.supplierId", 
        "supplier.name", 
        "supplier.legalName", 
        "supplier.VATId", 
        "warehouse.warehouseId", 
        "warehouse.name", 
        "issuedDate", 
        "dueDate", 
        "total.total", 
        "total.currencyCode", 
        "total.parity"
    ];

    protected function getEndpoint():string
    {
        return 'https://api.laudus.cl/purchases/invoices/';
    }

    protected function listEndpoint():string
    {
        return 'https://api.laudus.cl/purchases/invoices/list';
    }
    
}
