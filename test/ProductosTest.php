<?php

use Tests\MockData;
use Jsanbae\LaudusAPIPHP\LaudusAPI;
use Jsanbae\LaudusAPIPHP\RequestSettings\FilterList;
use Jsanbae\LaudusAPIPHP\RequestSettings\OrderByList;
use Jsanbae\LaudusAPIPHP\Credentials\LaudusCredential;
use Jsanbae\LaudusAPIPHP\RequestSettings\SettingsList;

use PHPUnit\Framework\TestCase;

class ProductosTest extends TestCase
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

    public function test_productos_list()
    {
        $product_id = $this->mock_data->productos()['product_id'];

        $settingsList = new SettingsList();
        $settingsList->setFields($this->api_client->Productos()->getFields())
        ->addFilter(new FilterList("productId",  "=", $product_id))
        ->addOrderBy(new OrderByList('productId', 'DESC'))
        ->paginate(0, 10)
        ;

        $api_response = $this->api_client->Productos()->list($settingsList);

        $this->assertEquals($api_response['data'][0]->productId, $product_id, "Couldn't retrieve productos from API");
    }

    public function test_productos_stock()
    {
        $api_response = $this->api_client->Productos()->getStock();

        $this->assertNotEmpty($api_response['data'], "Couldn't retrieve stock from API");
    }

    public function test_productos_stock_by_product_id()
    {
        $product_id = $this->mock_data->productos()['product_id'];

        $api_response = $this->api_client->Productos()->getStockByProductId($product_id);

        $this->assertEquals($api_response['data'][0]->productId, $product_id, "Couldn't retrieve stock from API");
    }

}