<?php

use Tests\MockData;
use Jsanbae\LaudusAPIPHP\LaudusAPI;
use Jsanbae\LaudusAPIPHP\RequestSettings\FilterList;
use Jsanbae\LaudusAPIPHP\RequestSettings\OrderByList;
use Jsanbae\LaudusAPIPHP\Credentials\LaudusCredential;
use Jsanbae\LaudusAPIPHP\RequestSettings\SettingsList;

use PHPUnit\Framework\TestCase;

class RemuneracionTest extends TestCase
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

    public function test_libro_list()
    {
        $payroll_id = $this->mock_data->remuneracion()['payroll_id'];

        $settingsList = new SettingsList();
        $settingsList->setFields($this->api_client->Remuneracion()->LibroRemuneracion()->getFields())
        ->addFilter(new FilterList("payrollId",  "=", $payroll_id))
        ->addOrderBy(new OrderByList('payrollId', 'DESC'))
        ->paginate(0, 10)
        ;

        $api_response = $this->api_client->Remuneracion()->LibroRemuneracion()->list($settingsList);

        $this->assertEquals($api_response['data'][0]->payrollId, $payroll_id, "Couldn't retrieve libro from API");
    }

    public function test_empleado_list()
    {
        $employee_id = $this->mock_data->remuneracion()['employee_id'];

        $settingsList = new SettingsList();
        $settingsList->setFields($this->api_client->Remuneracion()->Empleado()->getFields())
        ->addFilter(new FilterList("employeeId",  "=", $employee_id))
        ->addOrderBy(new OrderByList('employeeId', 'DESC'))
        ->paginate(0, 10)
        ;

        $api_response = $this->api_client->Remuneracion()->Empleado()->list($settingsList);

        $this->assertEquals($api_response['data'][0]->employeeId, $employee_id, "Couldn't retrieve empleado from API");
    }

    public function test_empleado_get()
    {
        $employee_id = $this->mock_data->remuneracion()['employee_id'];
        $api_response = $this->api_client->Remuneracion()->Empleado()->get($employee_id);
        $this->assertEquals($api_response['data']['employeeId'], $employee_id, "Couldn't retrieve empleado from API");
    }

}