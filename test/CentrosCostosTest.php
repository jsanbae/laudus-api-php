<?php

use Tests\MockData;
use PHPUnit\Framework\TestCase;
use Jsanbae\LaudusAPIPHP\LaudusAPI;
use Jsanbae\LaudusAPIPHP\RequestSettings\FilterList;
use Jsanbae\LaudusAPIPHP\RequestSettings\OrderByList;
use Jsanbae\LaudusAPIPHP\RequestSettings\SettingsList;
use Jsanbae\LaudusAPIPHP\Credentials\LaudusCredential;

class CentrosCostosTest extends TestCase
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

    public function test_centros_costos_get()
    {
        $centros_costos_id = $this->mock_data->centros_costos()['costCenterId'];
        $api_response = $this->api_client->CentrosCostos()->get($centros_costos_id);

        $this->assertEquals($api_response['data']['costCenterId'], $centros_costos_id, "Couldn't retrieve Centros Costos from API");
    }

    public function test_centros_costos_list()
    {
        $centros_costos_name =  $this->mock_data->centros_costos()['name'];

        $settingsList = new SettingsList();
        $settingsList->setFields($this->api_client->CentrosCostos()->getFields())
        ->addFilter(new FilterList("name",  "=", $centros_costos_name))
        ->addOrderBy(new OrderByList('name', 'DESC'))
        ->paginate(0, 999)
        ;
        $api_response = $this->api_client->CentrosCostos()->list($settingsList);

        $this->assertEquals($api_response['data'][0]->name, $centros_costos_name, "Couldn't retrieve Comprobante from API");
    }

}