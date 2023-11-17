<?php

use Tests\MockData;
use Jsanbae\LaudusAPIPHP\LaudusAPI;
use Jsanbae\LaudusAPIPHP\RequestSettings\SettingsMayorList;
use Jsanbae\LaudusAPIPHP\Credentials\LaudusCredential;

use PHPUnit\Framework\TestCase;

class MayorTest extends TestCase
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

    public function test_mayor_list()
    {
        $fecha_desde = new DateTimeImmutable('2023-01-01 00:00:00');
        $fecha_hasta = new DateTimeImmutable('2023-12-31 23:59:59');
        $account_start = 1000000;
        $account_end = 4999999;

        $options = (new SettingsMayorList($account_start, $account_end, $fecha_desde, $fecha_hasta))
                    ->paginate(0, 1);
        $api_response = $this->api_client->Mayor()->all($options);
        
        // $max_dump = 50000;
        // $rango_inicial = 0;
        // $excel = [];
        
        // do {
        //     $options = new SettingsMayorList($account_start, $account_end, $fecha_desde, $fecha_hasta, null, null, $rango_inicial); 
        //     $api_response = $this->api_client->Mayor()->all($options);

        //     if (empty($api_response['data'])) $this->assertEquals(1,0, "Can't retrieve Mayor from API");

        //     $data_size = count($api_response['data']);

        //     foreach ($api_response['data'] as $mayor) {

        //         $lineaMayor = [
        //             'aux_cuenta_codigo' => $mayor->accountNumber,
        //             'aux_nombre_cuenta' => '',
        //             'comp_nro' => $mayor->journalEntryNumber,
        //             'comp_tipo' => '',
        //             'comp_fecha' => $mayor->date,
        //             'comp_nombre' => $mayor->description,
        //             'valor_cargo' => $mayor->debit,
        //             'valor_abono' => $mayor->credit,
        //             'saldo' => '', 
        //             'sucursal_nombre' => $mayor->costCenterName,
        //             'rut' => $mayor->linkedToVATId,
        //             'raz_soc' => $mayor->linkedToName,
        //             'doc_nro' => $mayor->document,
        //         ];

        //         $excel[] = $lineaMayor;
        //     }

        //     $rango_inicial += $max_dump + 1;

        // } while ($data_size == $max_dump);

        // $myfile = fopen("mayor.csv", "w") or die("Unable to open file!");
        // fwrite($myfile,"Nro Cuenta;Nombre Cuenta;Nro Comp;Tipo Comp;Fecha Comp;Nombre Comp;Debe;Haber;Saldo;Centro Costo;RUT;Razon Social;Nro Doc" . "\n");

        // foreach ($excel as $lineaMayor) {
        //     $line = implode(';', $lineaMayor) . "\n";
        //     fwrite($myfile, $line);
        // }
        // fclose($myfile);


        $this->assertEquals(1,1, "Can't retrieve Pagos from API");
    }

    public function test_mayor_entidad_relacionada()
    {
        $VATId = "16.678.219-8";
        // $VATId = "99.544.700-2";
        $api_response = $this->api_client->Mayor()->getEntidadRelacionada($VATId);

        $this->assertEquals($VATId, $api_response['data']['employees'][0]->VATId, "Can't retrieve RelatedTo from API");
    }

}