<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints;

use Jsanbae\LaudusAPIPHP\APIBase;

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

    public function __construct(string $_token, ?callable $refreshToken = null)
    {
        parent::__construct($_token, $refreshToken);
    }

    protected function getEndpoint(): string
    {
        return '';
    }

    protected function listEndpoint(): string
    {
        return 'https://api.laudus.cl/production/products/list';
    }

    protected function createEndpoint(): string
    {
        return '';
    }

    protected function deleteEndpoint(): string
    {
        return '';
    }


    public function getStock(): array
    {
        return $this->send('GET', 'https://api.laudus.cl/production/products/stock');
    }

    public function getStockByProductId(string $_productId):array
    {
        return $this->send('GET', 'https://api.laudus.cl/production/products/'.$_productId.'/stock');
    }

}
