<?php

use Tests\MockData;
use PHPUnit\Framework\TestCase;
use Jsanbae\LaudusAPIPHP\LaudusAPI;
use Jsanbae\LaudusAPIPHP\RequestSettings\FilterList;
use Jsanbae\LaudusAPIPHP\RequestSettings\OrderByList;
use Jsanbae\LaudusAPIPHP\RequestSettings\SettingsList;
use Jsanbae\LaudusAPIPHP\Credentials\LaudusCredential;

class ComprobanteTest extends TestCase
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

    public function test_comprobante_get()
    {
        $comp_id = $this->mock_data->comprobante()['comp_id'];
        $api_response = $this->api_client->Comprobante()->get($comp_id);
        $this->assertEquals($api_response['data']['journalEntryId'], $comp_id, "Couldn't retrieve Comprobante from API");
    }

    public function test_comprobante_list()
    {
        $comp_number =  $this->mock_data->comprobante()['comp_nro'];
        $comp_type =  $this->mock_data->comprobante()['comp_type'];

        $settingsList = new SettingsList();
        $settingsList->setFields($this->api_client->Comprobante()->getFields())
        ->addFilter(new FilterList("journalEntryNumber",  "=", $comp_number))
        ->addFilter(new FilterList("type",  "=", $comp_type))
        ->addOrderBy(new OrderByList('journalEntryNumber', 'DESC'))
        ->paginate(0, 999)
        ;
        $api_response = $this->api_client->Comprobante()->list($settingsList);

        $this->assertEquals($api_response['data'][0]->journalEntryNumber, $comp_number, "Couldn't retrieve Comprobante from API");
    }

    public function test_comprobante_create()
    {
        $this->markTestSkipped('Test de Crear Comprobante has been skipped.');

        $comp_data = $this->mock_data->comprobante()['comp_new'];
        $api_response = $this->api_client->Comprobante()->create($comp_data);

        $this->assertNotNull($api_response['data'][0]->journalEntryNumber, "Couldn't create Comprobante from API");
    }
}