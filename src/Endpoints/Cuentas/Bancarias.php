<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints\Cuentas;

use Jsanbae\LaudusAPIPHP\APIBase;

class Bancarias extends APIBase
{
    protected $fields = [
        'bankId', 
        'account.accountId', 
        'account.accountNumber', 
        'currencyCode', 
        'debitsReconciliationMethod', 
        'creditsReconciliationMethod', 
        'lastPrintedCheckNumber', 
        'statement_dateColumn', 
        'statement_descriptionColumn', 
        'statement_documentColumn', 
        'statement_debitColumn', 
        'statement_creditColumn', 
        'statement_delimiter', 
        'statement_separator',
        'notes',
        'createdAt', 
        'modifiedAt'
    ];

    protected function getEndpoint():string
    {
        return 'https://api.laudus.cl/accounting/banks/';
    }
    
    protected function listEndpoint():string
    {
        return 'https://api.laudus.cl/accounting/banks/list';
    }

}