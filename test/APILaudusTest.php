<?php

use Jsanbae\LaudusAPIPHP\LaudusAPI;
use Jsanbae\LaudusAPIPHP\Credentials\LaudusCredential;
use Jsanbae\LaudusAPIPHP\SettingsList\SettingsList;
use Jsanbae\LaudusAPIPHP\SettingsList\FilterList;
use Jsanbae\LaudusAPIPHP\SettingsList\OptionsList;
use Jsanbae\LaudusAPIPHP\SettingsList\OrderByList;

use PHPUnit\Framework\TestCase;

class APILaudusTest extends TestCase
{
    private $api_client;
    public function setUp():void
    {
        parent::setUp();
        
        Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../')->load();

        $username = $_ENV['API_LAUDUS_USERNAME'];
        $password = $_ENV['API_LAUDUS_PASSWORD'];
        $vatid = $_ENV['API_LAUDUS_VATID'];

        $this->api_client = new LaudusAPI(new LaudusCredential($username, $password, $vatid));
    }
    public function test_get_token()
    {
        $token = $this->api_client->getToken();
        $this->assertArrayHasKey('token', $token['data'], "Couldn't get token");
    }

    public function test_is_valid_token()
    {
        $token = $this->api_client->getToken()['data'];
        $is_valid_token = $this->api_client->isValidToken($token);

        $this->assertTrue($is_valid_token, 'Token is not valid');
    }

    public function test_settingslist()
    {
        $settingsList = new SettingsList();
        $settingsList->setFields(['id','name', 'category', 'price', 'stock', 'active', 'createdAt', 'modifiedAt'])
        ->setOptions(new OptionsList(0, 1))
        ->addFilter(new FilterList('id', '>', 0))
        ->addOrderBy(new OrderByList('category', 'DESC'))
        ;

        $this->assertArrayHasKey('fields', $settingsList->toArray(), "Can't get fields");
        $this->assertArrayHasKey('filterBy', $settingsList->toArray(), "Can't get filterBy");
        $this->assertArrayHasKey('orderby', $settingsList->toArray(), "Can't get orderby");
        $this->assertArrayHasKey('options', $settingsList->toArray(), "Can't get options");
    }

    public function test_cuentas_contables()
    {
        $account_number = '1101201';
        $settingsList = new SettingsList();
        $settingsList->setFields($this->api_client->Cuentas()->Contables()->getFields())
        ->setOptions(new OptionsList(0, 10))
        ->addFilter(new FilterList("accountNumber",  "=", $account_number))
        ->addOrderBy(new OrderByList('accountNumber', 'DESC'))
        ;

        $api_response = $this->api_client->Cuentas()->Contables()->list($settingsList);

        $this->assertEquals($api_response['data'][0]->accountNumber, $account_number, "Couldn't retrieve cuentas from API");
    }

    public function test_cuentas_bancarias()
    {
        $settingsList = new SettingsList();
        $settingsList->setFields($this->api_client->Cuentas()->Bancarias()->getFields())
        ->setOptions(new OptionsList(0, 10))
        // ->addFilter(new FilterList("account.accountId",  "=", 365))
        ->addFilter(new FilterList("bankId",  "=", '04'))
        ->addOrderBy(new OrderByList('bankId', 'DESC'))
        ;

        $api_response = $this->api_client->Cuentas()->Bancarias()->list($settingsList);

        $this->assertEquals($api_response['data'][0]->bankId, '04', "Couldn't retrieve cuentas bancarias from API");
    }

    public function test_compras_pagos()
    {
        $payment_id = 396;
        // $payment_id = 412;
        $settingsList = new SettingsList();
        $settingsList->setOptions(new OptionsList(0, 10))
        ->setFields($this->api_client->Compras()->Pagos()->getFields())
        ->addFilter(new FilterList("paymentId",  "=", $payment_id))
        ->addOrderBy(new OrderByList('paymentId', 'DESC'))
        ;

        // $api_response = $this->api_client->Compras()->Pagos()->get($payment_id);
        $api_response = $this->api_client->Compras()->Pagos()->list($settingsList);

        $this->assertEquals($api_response['data'][0]->paymentId, $payment_id, "Couldn't retrieve Pagos from API");
    }

    public function test_compras_pagos_pagar()
    {
        $this->markTestSkipped('Test de Pago Factura has been skipped.');

        $payment_type = 'I';
        $bank_id = '04';
        $purchase_invoice_id = 354;
        $payment_date = (new \DateTimeImmutable("2023-04-25"))->format('Y-m-d H:i:s');
        $payment_amount = 241481;

        $pago = [
            "paymentType" => ['code' => $payment_type],
            "issuedDate" => $payment_date,// fecha del mov cartola
            "deposited" => false,
            "bank" => [
                "bankId" => $bank_id
            ],
            "createAccounting" => true,
            "purchaseInvoices" => [
                [
                    "purchaseInvoiceId" =>  $purchase_invoice_id,
                    "originalAmount" => $payment_amount,
                    "amount" => $payment_amount,
                ]
            ]
        ];

        $api_response = $this->api_client->Compras()->Pagos()->Pagar($pago);

        $this->assertEquals($api_response['data'][0]->purchaseInvoices_purchaseInvoiceId, $purchase_invoice_id, "Pagos couldn't be done from API");
    }

    public function test_compras_facturas()
    {
        $doc_number = 401978;

        $settingsList = new SettingsList();
        $settingsList->setFields($this->api_client->Compras()->Facturas()->getFields())
        ->setOptions(new OptionsList(0, 1))
        ->addFilter(new FilterList("docNumber",  "=", $doc_number))
        ->addOrderBy(new OrderByList('docNumber', 'DESC'))
        ;

        $api_response = $this->api_client->Compras()->Facturas()->list($settingsList);

        $this->assertEquals($api_response['data'][0]->docNumber, $doc_number, "Can't retrieve Pagos from API");
    }

    public function test_ventas_cobros_list()
    {
        $doc_number = 130;
        $receipt_id = 101;

        $settingsList = new SettingsList();
        // $settingsList->setFields($this->api_client->Ventas()->Cobros()->getFields())
        $settingsList->setFields($this->api_client->Ventas()->Cobros()->getFields())
        ->setOptions(new OptionsList(0, 1))
        ->addFilter(new FilterList("salesInvoices.docNumber",  "contains", [$doc_number]))
        ->addOrderBy(new OrderByList('salesInvoices.docNumber', 'DESC'))
        ;

        // $api_response = $this->api_client->Ventas()->Cobros()->list($settingsList);
        $api_response = $this->api_client->Ventas()->Cobros()->get($receipt_id);

        $this->assertEquals($api_response['data'][0]->salesInvoice, $doc_number, "Can't retrieve Pagos from API");
    }

    public function test_ventas_facturas_list()
    {
        $doc_number = 492;
        // $cliente_vatID = "";

        $settingsList = new SettingsList();
        $settingsList->setFields($this->api_client->Ventas()->Facturas()->getFields())
        ->setOptions(new OptionsList(0, 1))
        ->addFilter(new FilterList("docNumber",  "contains", [$doc_number]))
        // ->addFilter(new FilterList("customer.VATId",  "contains", [$cliente_vatID]))
        ->addOrderBy(new OrderByList('docNumber', 'DESC'))
        ;

        $api_response = $this->api_client->Ventas()->Facturas()->list($settingsList);
        // $api_response = $this->api_client->Ventas()->Cobros()->get($receipt_id);

        $this->assertEquals($api_response['data'][0]->salesInvoice, $doc_number, "Can't retrieve Pagos from API");
    }

}