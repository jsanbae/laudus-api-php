<?php

use Tests\MockData;
use Jsanbae\LaudusAPIPHP\LaudusAPI;
use Jsanbae\LaudusAPIPHP\Credentials\LaudusCredential;
use Jsanbae\LaudusAPIPHP\RequestSettings\SettingsList;
use Jsanbae\LaudusAPIPHP\RequestSettings\FilterList;
use Jsanbae\LaudusAPIPHP\RequestSettings\OptionsList;
use Jsanbae\LaudusAPIPHP\RequestSettings\OrderByList;

use PHPUnit\Framework\TestCase;

class APILaudusTest extends TestCase
{
    private $api_client;

    public function setUp():void
    {
        parent::setUp();
       
        $mock_data = new MockData();
        ['username' => $username, 'password' => $password, 'vatid' => $vatid] = $mock_data->credential();

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
        ->addFilter(new FilterList('id', '>', 0))
        ->addOrderBy(new OrderByList('category', 'DESC'))
        ->paginate(0, 1)
        ;

        $this->assertArrayHasKey('fields', $settingsList->toArray(), "Can't get fields");
        $this->assertArrayHasKey('filterBy', $settingsList->toArray(), "Can't get filterBy");
        $this->assertArrayHasKey('orderby', $settingsList->toArray(), "Can't get orderby");
        $this->assertArrayHasKey('options', $settingsList->toArray(), "Can't get options");
    }

}