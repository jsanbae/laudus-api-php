<?php

use Jsanbae\LaudusAPIPHP\LaudusAPI;
use Jsanbae\LaudusAPIPHP\Credentials\LaudusCredential;
use Jsanbae\LaudusAPIPHP\RequestSettings\SettingsList;
use Jsanbae\LaudusAPIPHP\RequestSettings\FilterList;
use Jsanbae\LaudusAPIPHP\RequestSettings\OptionsList;
use Jsanbae\LaudusAPIPHP\RequestSettings\OrderByList;

use PHPUnit\Framework\TestCase;

class SystemTest extends TestCase
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

    public function test_system_codes_list()
    {
        $settingsList = new SettingsList();
        $settingsList->setFields($this->api_client->System()->Codes()->getFields())
        ->paginate(0, 999)
        // ->addFilter(new FilterList("code",  "=", "0A"))
        ->addFilter(new FilterList("category.codeCategoryId",  "=", 16))
        // ->addFilter(new FilterList("metadata",  "=", "<account>100</account>"))
        ->addOrderBy(new OrderByList('code', 'ASC'))
        ;
        $api_response = $this->api_client->System()->Codes()->list($settingsList);

        $this->assertEquals(1,1, "Can't retrieve Pagos from API");
    }
    
    public function test_system_codes_category_list()
    {
        $settingsList = new SettingsList();
        $settingsList->setFields($this->api_client->System()->CodesCategory()->getFields())
        // ->addFilter(new FilterList("code",  "=", "0A"))
        ->addFilter(new FilterList("categoryId",  "=", 16))
        ->addOrderBy(new OrderByList('categoryId', 'ASC'))
        ->paginate(0, 999)
        ;
        $api_response = $this->api_client->System()->CodesCategory()->list($settingsList);

        $this->assertEquals(1,1, "Can't retrieve Pagos from API");
    }
}