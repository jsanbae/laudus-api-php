# Laudus API PHP

Una interfaz simple creada en PHP para comunicarte con la [API de Laudus](https://api.laudus.cl).

## Quickstart

### 1. Configura las variables en tu archivo .env (guíate por .env_sample)

```(.env)
API_LAUDUS_USERNAME =
API_LAUDUS_PASSWORD =
API_LAUDUS_VATID =
```

### 2. Crea una instancia del Cliente API Laudus

```(php)
use Jsanbae\LaudusAPIPHP\LaudusAPI;
use Jsanbae\LaudusAPIPHP\Credentials\LaudusCredential;

$username = $_ENV['API_LAUDUS_USERNAME'];
$password = $_ENV['API_LAUDUS_PASSWORD'];
$vatid = $_ENV['API_LAUDUS_VATID'];

$api_client = new LaudusAPI(new LaudusCredential($username, $password, $vatid));
```

### 3. Usa alguno de los Servicios disponibles

```(php)
// Obten una factura de proveedor por ID
$doc_id = 100;
$data_from_api = $api_client->Compras()->Facturas()->get($doc_id);

//Obtener una lista de facturas de proveedor
use Jsanbae\LaudusAPIPHP\RequestSettings\SettingsList;
use Jsanbae\LaudusAPIPHP\RequestSettings\FilterList;
use Jsanbae\LaudusAPIPHP\RequestSettings\OptionsList;
use Jsanbae\LaudusAPIPHP\RequestSettings\OrderByList;

$doc_number = 100;
$settingsList = new SettingsList();
$settingsList->setFields($this->api_client->Compras()->Facturas()->getFields())
->addFilter(new FilterList("docNumber",  "=", $doc_number))
->addOrderBy(new OrderByList('docNumber', 'DESC'))
->paginate(0, 1)
;

$data_from_api = $this->api_client->Compras()->Facturas()->list($settingsList);
```

## Servicios Disponibles

Cuenta con unos pocos, se irán agregando en la medida que los vaya necesitando. Sientanse libres de enviar PR con sus propios servicios.

### Login

- Generar Token (JWT)
- Validar Token
- ReValidar Token

### Compras

- Obtener Factura por ID
- Listar Facturas (Filtrable)
- Obtener Proveedor por ID
- Listar Proveedores (Filtrable)
- Obtener Pago por ID
- Listar Pagos (Filtrable)
- Realizar Pago

### Ventas

- Obtener Factura por ID
- Listar Facturas (Filtrable)
- Obtener Cliente por ID
- Listar Clientes (Filtrable)
- Obtener Cobro por ID
- Listar Cobros (Filtrable)
- Realizar Cobro

### Cuentas

- Obtener Cuenta de Banco por ID
- Listar Cuentas de Bancos (Filtrable)
- Obtener Cuenta Contable por ID
- Listar Cuentas Contables (Filtrable)

## Crear Servicio

Para crear un servicio solo debe extender de la clase APIBase.

```(php)
<?php

use Jsanbae\LaudusAPIPHP\APIBase;

class Ventas extends APIBase
{
    protected $fields = []; // Campos del Endpoint

    protected function getEndpoint():string
    {
        return 'url_endpoint_get' // Ejemplo: 'https://api.laudus.cl/purchases/invoices/';
    }

    protected function listEndpoint():string
    {
        return return 'url_endpoint_list' // Ejemplo: 'https://api.laudus.cl/purchases/invoices/list';
    }
}

```

## Clase StdResponse

Con el objetivo de homologar todas las response del API de Laudus, se creó una clase que estandariza las respuestas.

```(php)
// Estructura del StdResponse, retorna un Array
$stdResponse = [
    "status" => '', // 'success' ó 'error'
    "statusCode" => '', // 200, 400's, 500
    "message" => '', // Bueno o malo
    "data" => [], // Viene vacío en caso de error y poblado en caso de éxito.
    "error" => [], // Viene vacío en caso de éxito y poblado en caso de error.
    "extra" => '', // Alguna información adicional
    'timestamp' => new \DateTimeImmutable() // Momento en que se generó el response
];
```



## Tests

Ejecuta los tests con PHPUnit:

```(bash)
./vendor/bin/phpunit ./test
```

## Contribuciones

Esta API quedá abierto a cualquier sugerencia, mejoras, etc. No dudes en forkear y enviar tus PRs.
