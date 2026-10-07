<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints;

use Jsanbae\LaudusAPIPHP\APIBase;
use Jsanbae\LaudusAPIPHP\RequestSettings\SettingsMayorList;

class Mayor extends APIBase 
{
    protected $fields = [
        'journalEntryId',
        'journalEntryNumber',
        'date',
        'accountNumber',
        'lineId',
        'description',
        'debit',
        'credit',
        'currencyCode',
        'parityToMainCurrency',
        'originalDebit',
        'originalCredit',
        'costCenterId',
        'costCenterName',
        'document',
        'linkedToName',
        'linkedToVATId',
    ];

    public function __construct(string $_token, ?callable $refreshToken = null)
    {
        parent::__construct($_token, $refreshToken);
    }

    protected function getEndpoint():string
    {
        return '';
    }

    protected function listEndpoint(): string
    {
        return 'https://api.laudus.cl/accounting/ledger';
    }

    protected function createEndpoint(): string
    {
        return '';
    }

    protected function deleteEndpoint(): string
    {
        return '';
    }

    public function all(SettingsMayorList $_options): array
    {
        $endpoint_url = $this->listEndpoint() . "?accountNumberFrom=" . $_options->getAccountNumberFrom() . "&offset=" . $_options->getOffset() . "&limit=" . $_options->getLimit();
        if (!is_null($_options->getAccountNumberTo())) $endpoint_url .= "&accountNumberTo=" . $_options->getAccountNumberTo();
        if (!is_null($_options->getDateFrom())) $endpoint_url .= "&dateFrom=" . $_options->getDateFrom()->format("Y-m-d\TH:i:s");
        if (!is_null($_options->getDateTo())) $endpoint_url .= "&dateTo=" . $_options->getDateTo()->format("Y-m-d\TH:i:s");
        if (!is_null($_options->getCostCenterId())) $endpoint_url .= "&costCenterId=" . $_options->getCostCenterId();
        if (!is_null($_options->getBookId())) $endpoint_url .= "&bookId=" . $_options->getBookId();

        return $this->send('GET', $endpoint_url);
    }

    public function getEntidadRelacionada(string $_VATId, string $_country_Code = null):array
    {
        $endpoint_url = "https://api.laudus.cl/accounting/relatedTo?VATId=" . $_VATId;
        if ($_country_Code) $endpoint_url .= "&countryCode=" . $_country_Code;

        return $this->send('GET', $endpoint_url);
    }

}
