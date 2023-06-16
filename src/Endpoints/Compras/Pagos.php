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
    ];

    protected function getEndpoint():string
    {
        return 'https://api.laudus.cl/purchases/payments/';
    }

    protected function listEndpoint():string
    {
        return 'https://api.laudus.cl/purchases/payments/list';
    }

    public function Pagar(array $_pago):array
    {
        try {

            $request = curl_init('https://api.laudus.cl/purchases/payments'); 
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($request, CURLOPT_POSTFIELDS, json_encode($_pago));
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($request, CURLOPT_HTTPHEADER, array(
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: Bearer " . $this->token)
            );

            //make POST
            $response = curl_exec($request);
            //respond status code
            $responseStatusCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
            curl_close($request);

            $response_decoded = (array) json_decode($response);

            return (new StdResponse($response_decoded, $responseStatusCode))();
            
        } catch (\Throwable $t) {
            throw new \Exception("Error API Connection: " . $t->getMessage() . "\n");
        }
    }

}
