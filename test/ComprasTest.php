<?php

use Tests\MockData;
use Jsanbae\LaudusAPIPHP\LaudusAPI;
use Jsanbae\LaudusAPIPHP\Credentials\LaudusCredential;
use Jsanbae\LaudusAPIPHP\RequestSettings\SettingsList;
use Jsanbae\LaudusAPIPHP\RequestSettings\FilterList;
use Jsanbae\LaudusAPIPHP\RequestSettings\OptionsList;
use Jsanbae\LaudusAPIPHP\RequestSettings\OrderByList;

use PHPUnit\Framework\TestCase;

class ComprasTest extends TestCase
{
    private $api_client;
    private $mock_data;
    
    public function setUp():void
    {
        parent::setUp();

        $this->mock_data = new MockData();
        ['username' => $username, 'password' => $password, 'vatid' => $vatid] = $this->mock_data->credential();
        $this->api_client = new LaudusAPI(new LaudusCredential($username, $password, $vatid));
    }

    public function test_compras_pagos_get()
    {
        $mock_data = $this->mock_data->compras()['pagos'];
        $payment_id = $mock_data['payment_id'];

        $api_response = $this->api_client->Compras()->Pagos()->get($payment_id);

        $this->assertEquals($api_response['data']['paymentId'], $payment_id, "Couldn't retrieve Pagos from API");
    }

    public function test_compras_pagos_list()
    {
        $mock_data = $this->mock_data->compras()['pagos'];
        $payment_id = $mock_data['payment_id'];
        $paymentType_code = $mock_data['paymentType_code'];
        $journalEntryDeposited_journalEntryNumber = $mock_data['journalEntryDeposited_journalEntryNumber'];
        $otherDocuments_category_code = $mock_data['otherDocuments_category_code'];

        $settingsList = new SettingsList();
        $settingsList->paginate(0, 10)
        ->setFields($this->api_client->Compras()->Pagos()->getFields())
        ->addFilter(new FilterList("paymentId",  "=", $payment_id))
        // ->addFilter(new FilterList("paymentType.code",  "=", $paymentType_code))
        // ->addFilter(new FilterList("journalEntryDeposited.journalEntryNumber",  "=", $journalEntryDeposited_journalEntryNumber))
        // ->addFilter(new FilterList("otherDocuments.category.code",  "=", $otherDocuments_category_code))
        ->addOrderBy(new OrderByList('paymentId', 'DESC'))
        ;

        $api_response = $this->api_client->Compras()->Pagos()->list($settingsList);

        $this->assertEquals($api_response['data'][0]->paymentId, $payment_id, "Couldn't retrieve Pagos from API");
    }

    public function test_compras_pagos_create()
    {
        $this->markTestSkipped('Test de Crear Pago Factura has been skipped.');
        $mock_data = $this->mock_data->compras()['pagos'];

        $pago_new = $mock_data['pago_new'];
        $purchase_invoice_id = $mock_data['pago_new']['purchaseInvoices'][0]['purchaseInvoiceId'];

        $api_response = $this->api_client->Compras()->Pagos()->create($pago_new);

        $this->assertEquals($api_response['data'][0]->purchaseInvoices_purchaseInvoiceId, $purchase_invoice_id, "Pagos couldn't be done from API");
    }

    public function test_compras_facturas()
    {
        $doc_number = 401978;

        $settingsList = new SettingsList();
        $settingsList->setFields($this->api_client->Compras()->Facturas()->getFields())
        ->addFilter(new FilterList("docNumber",  "=", $doc_number))
        ->addOrderBy(new OrderByList('docNumber', 'DESC'))
        ->paginate(0, 1)
        ;

        $api_response = $this->api_client->Compras()->Facturas()->list($settingsList);

        $this->assertEquals($api_response['data'][0]->docNumber, $doc_number, "Can't retrieve Pagos from API");
    }

}