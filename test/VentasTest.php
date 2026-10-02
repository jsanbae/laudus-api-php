<?php

use Tests\MockData;
use PHPUnit\Framework\TestCase;
use Jsanbae\LaudusAPIPHP\LaudusAPI;
use Jsanbae\LaudusAPIPHP\RequestSettings\FilterList;
use Jsanbae\LaudusAPIPHP\RequestSettings\OrderByList;

use Jsanbae\LaudusAPIPHP\Credentials\LaudusCredential;
use Jsanbae\LaudusAPIPHP\RequestSettings\SettingsList;

class VentasTest extends TestCase
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

    public function test_ventas_cobros_list()
    {
        $doc_number = 130;

        $settingsList = (new SettingsList())
        ->setFields($this->api_client->Ventas()->Cobros()->getFields())
        ->addFilter(new FilterList("salesInvoices.docNumber",  "=", [$doc_number]))
        ->addOrderBy(new OrderByList('salesInvoices.docNumber', 'DESC'))
        ->paginate(0, 1)
        ;

        $api_response = $this->api_client->Ventas()->Cobros()->list($settingsList);

        $this->assertEquals($api_response['data'][0]->salesInvoices_docNumber, $doc_number, "Can't retrieve Pagos from API");
    }

    public function test_ventas_cobros_get()
    {
        $receipt_id = $this->mock_data->ventas()['cobros']['receipt_id'];
        $api_response = $this->api_client->Ventas()->Cobros()->get($receipt_id);

        $this->assertEquals($api_response['data']['receiptId'], $receipt_id, "Can't retrieve Pagos from API");
    }

    public function test_ventas_facturas_list()
    {
        $doc_number = $this->mock_data->ventas()['ventas']['doc_number'];
        $customer_vatID = $this->mock_data->ventas()['ventas']['customer_vatID'];

        $settingsList = (new SettingsList())
        ->setFields($this->api_client->Ventas()->Facturas()->getFields())
        // ->addFilter(new FilterList("docNumber",  "=", $doc_number))
        // ->addFilter(new FilterList("customer.VATId",  "=", [$customer_vatID]))
        ->addOrderBy(new OrderByList('docNumber', 'DESC'))
        ->paginate(0, 10)
        ;

        $api_response = $this->api_client->Ventas()->Facturas()->list($settingsList);

        $this->assertEquals($api_response['data'][0]->docNumber, $doc_number, "Can't retrieve Pagos from API");
    }

    public function test_ventas_clientes_get()
    {
        $customer_id = $this->mock_data->ventas()['clientes']['customer_id'];

        $api_response = $this->api_client->Ventas()->Clientes()->get($customer_id);

        $this->assertEquals($api_response['data']['customerId'], $customer_id, "Couldn't retrieve Cliente from API");
    }

    public function test_ventas_clientes_list()
    {
        $customer_id = $this->mock_data->ventas()['clientes']['customer_id'];

        $settingsList = (new SettingsList())
        ->setFields($this->api_client->Ventas()->Clientes()->getFields())
        ->addFilter(new FilterList("customerId",  "=", $customer_id))
        ->addOrderBy(new OrderByList('customerId', 'DESC'))
        ->paginate(0, 1)
        ;

        $api_response = $this->api_client->Ventas()->Clientes()->list($settingsList);

        $this->assertEquals($api_response['data'][0]->customerId, $customer_id, "Couldn't retrieve Clientes from API");
    }

    public function test_ventas_clientes_create()
    {
        $this->markTestSkipped('Test de Crear Cliente has been skipped.');

        $cliente_new = $this->mock_data->ventas()['clientes']['cliente_new'];

        $api_response = $this->api_client->Ventas()->Clientes()->create($cliente_new);

        $this->assertNotNull($api_response['data']['customerId'], "Couldn't create Cliente from API");
    }

    public function test_ventas_clientes_update()
    {
        $this->markTestSkipped('Test de Modificar Cliente has been skipped.');

        $customer_id = $this->mock_data->ventas()['clientes']['customer_id'];
        $cliente = $this->api_client->Ventas()->Clientes()->get($customer_id)['data'];
        $cliente['notes'] = 'Modificado desde test';

        $api_response = $this->api_client->Ventas()->Clientes()->update($customer_id, $cliente);

        $this->assertEquals($api_response['data']['notes'], 'Modificado desde test', "Couldn't update Cliente from API");
    }

    public function test_ventas_clientes_delete()
    {
        $this->markTestSkipped('Test de Eliminar Cliente has been skipped.');

        $customer_id = $this->mock_data->ventas()['clientes']['customer_id'];

        $api_response = $this->api_client->Ventas()->Clientes()->delete($customer_id);

        $this->assertEquals('success', $api_response['status'], "Couldn't delete Cliente from API");
    }
}