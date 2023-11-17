<?php

use Tests\MockData;
use Jsanbae\LaudusAPIPHP\LaudusAPI;
use Jsanbae\LaudusAPIPHP\RequestSettings\FilterList;
use Jsanbae\LaudusAPIPHP\RequestSettings\OrderByList;
use Jsanbae\LaudusAPIPHP\Credentials\LaudusCredential;
use Jsanbae\LaudusAPIPHP\RequestSettings\SettingsList;

use PHPUnit\Framework\TestCase;

class CuentasTest extends TestCase
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

    public function test_cuentas_contables_list()
    {
        $account_number = $this->mock_data->cuentas()['contables']['account_number'];

        $settingsList = new SettingsList();
        $settingsList->setFields($this->api_client->Cuentas()->Contables()->getFields())
        ->addFilter(new FilterList("accountNumber",  "=", $account_number))
        ->addOrderBy(new OrderByList('accountNumber', 'DESC'))
        ->paginate(0, 10)
        ;

        $api_response = $this->api_client->Cuentas()->Contables()->list($settingsList);

        $this->assertEquals($api_response['data'][0]->accountNumber, $account_number, "Couldn't retrieve cuentas from API");
    }

    public function test_cuentas_bancarias_list()
    {
        $bank_id = $this->mock_data->cuentas()['bancarias']['bank_id'];

        $settingsList = new SettingsList();
        $settingsList->setFields($this->api_client->Cuentas()->Bancarias()->getFields())
        ->addFilter(new FilterList("bankId",  "=", $bank_id))
        ->addOrderBy(new OrderByList('bankId', 'ASC'))
        ->paginate(0, 10)
        ;

        $api_response = $this->api_client->Cuentas()->Bancarias()->list($settingsList);

        $this->assertEquals($api_response['data'][0]->bankId, $bank_id, "Couldn't retrieve cuentas bancarias from API");
    }

}