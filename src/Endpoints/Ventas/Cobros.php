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

    public function Cobrar(array $_cobro):array
    {
        try {

            $request = curl_init('https://api.laudus.cl/sales/receipts'); 
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($request, CURLOPT_POSTFIELDS, json_encode($_cobro));
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