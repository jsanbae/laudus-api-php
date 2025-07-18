<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints;

use Jsanbae\LaudusAPIPHP\APIBase;
use Jsanbae\LaudusAPIPHP\StdResponse;

class Productos extends APIBase 
{
    protected $fields = [
        'productId',
        'sku',
        'description',
        'allowFreeDescription',
        'barCode',
        'type',
        'productCategory.productCategoryId',
        'productCategory.name',
        'productCategory.fullPath',
        'discontinued',
        'unitOfMeasure',
        'unitOfMeasureAlt',
        'conversionFactor',
        'canBeSold',
        'canBePurchased',
        'unitPrice',
        'unitPriceWithTaxes',
        'incomeCurrencyCode',
        'allowUserChangePrices',
        'maxDiscount',
        'unitCost',
        'purchaseCurrencyCode',
        'stockable',
        'minimumStock',
        'VATRate',
        'VATRetentionRate',
        'applyGeneralVATRate',
        'applyGeneralVATRetentionRate',
        'subjectToAlcoholTax',
        'alcoholTaxRate',
        'productCodeOnTaxpayerSwap',
        'notInvoiceable',
        'notInvoiceableIsIncome',
        'costAccount.accountId',
        'costAccount.accountNumber',
        'costAccount.name',
        'incomeAccount.accountId',
        'incomeAccount.accountNumber',
        'incomeAccount.name',
        'account.accountId',
        'account.accountNumber',
        'account.name',
        'notes',
        'createdBy.userId',
        'createdBy.name',
        'createdAt',
        'modifiedBy.userId',
        'modifiedBy.name',
        'modifiedAt',
        'pictures.fileId',
        'pictures.description',
        'pictures.type'
    ];

    public function __construct(string $_token)
    {
        parent::__construct($_token);
    }

    protected function getEndpoint():string
    {
        return '';
    }

    protected function listEndpoint():string
    {
        return 'https://api.laudus.cl/production/products/list';
    }

    protected function createEndpoint():string
    {
        return '';
    }


    public function getStock():array
    {
        try {
            $endpoint_url = "https://api.laudus.cl/production/products/stock";

            $request = curl_init($endpoint_url);
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($request, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($request, CURLOPT_HTTPHEADER, array(
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: Bearer " . $this->token)
            );
    
            //make request
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

    public function getStockByProductId(string $_productId):array
    {
        try {
            $endpoint_url = "https://api.laudus.cl/production/products/".$productId."/stock";

            $request = curl_init($endpoint_url);
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($request, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($request, CURLOPT_HTTPHEADER, array(
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: Bearer " . $this->token)
            );
    
            //make request
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
