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
        'statement.dateColumn', 
        'statement.descriptionColumn', 
        'statement.documentColumn', 
        'statement.debitColumn', 
        'statement.creditColumn', 
        'statement.delimiter', 
        'statement.separator',
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