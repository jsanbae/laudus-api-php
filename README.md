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
$settingsList->setFields($api_client->Compras()->Facturas()->getFields())
->addFilter(new FilterList("docNumber",  "=", $doc_number))
->addOrderBy(new OrderByList('docNumber', 'DESC'))
->paginate(0, 1)
;

$data_from_api = $api_client->Compras()->Facturas()->list($settingsList);
```

Los servicios que lo soportan también permiten crear, modificar y eliminar:

```(php)
// Crear un cliente
$data_from_api = $api_client->Ventas()->Clientes()->create([
    "name" => "GONZALO JOSE QUEZADA ROSS",
    "legalName" => "GONZALO JOSE QUEZADA ROSS",
    "VATId" => "6.286.477-K",
]);

// Modificar un cliente (se recomienda enviar el objeto completo)
$customer_id = 1;
$cliente = $api_client->Ventas()->Clientes()->get($customer_id)['data'];
$cliente['notes'] = 'Cliente actualizado';
$data_from_api = $api_client->Ventas()->Clientes()->update($customer_id, $cliente);

// Eliminar un cliente
$data_from_api = $api_client->Ventas()->Clientes()->delete($customer_id);
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
- Crear Proveedor
- Obtener Pago por ID
- Listar Pagos (Filtrable)
- Realizar Pago

### Ventas

- Obtener Factura por ID
- Listar Facturas (Filtrable)
- Obtener Cliente por ID
- Listar Clientes (Filtrable)
- Crear Cliente
- Modificar Cliente
- Eliminar Cliente
- Obtener Cobro por ID
- Listar Cobros (Filtrable)
- Realizar Cobro

### Cuentas

- Obtener Cuenta de Banco por ID
- Listar Cuentas de Bancos (Filtrable)
- Obtener Cuenta Contable por ID
- Listar Cuentas Contables (Filtrable)

### Remuneración

- Listar Libro de Remuneraciones (Filtrable)
- Obtener Empleado por ID
- Listar Empleados (Filtrable)
- Crear Empleado
- Modificar Empleado
- Eliminar Empleado

Al crear un empleado, la API de Laudus exige más datos que en otras entidades: `birthDate`, `contractStartDate`, `gender`, `type` (tipo de trabajador), `contractType`, `workingDayType`, `healthPlan.isapre.isapreId`, `healthPlan.planType` y una previsión (`AFP.AFPId` o `exCaja.exCajaId`). Los códigos válidos se pueden obtener consultando un empleado existente.

```(php)
$data_from_api = $api_client->Remuneracion()->Empleado()->create([
    "firstName" => "GONZALO JOSE",
    "lastName1" => "QUEZADA",
    "lastName2" => "ROSS",
    "VATId" => "6.286.477-K",
    "gender" => "M",
    "birthDate" => "1960-01-01 00:00:00",
    "contractStartDate" => "2026-10-01 00:00:00",
    "type" => "...",
    "contractType" => "...",
    "workingDayType" => "...",
    "healthPlan" => [
        "isapre" => ["isapreId" => "..."],
        "planType" => "...",
    ],
    "AFP" => ["AFPId" => "..."],
]);
```

## Crear Servicio

Para crear un servicio solo debe extender de la clase APIBase. Los endpoints que no soporte el servicio se dejan como string vacío. `updateEndpoint()` es opcional y solo se define si el servicio permite modificar.

```(php)
<?php

use Jsanbae\LaudusAPIPHP\APIBase;

class Clientes extends APIBase
{
    protected $fields = []; // Campos del Endpoint

    protected function getEndpoint(): string
    {
        return 'url_endpoint_get'; // Ejemplo: 'https://api.laudus.cl/sales/customers/';
    }

    protected function listEndpoint(): string
    {
        return 'url_endpoint_list'; // Ejemplo: 'https://api.laudus.cl/sales/customers/list';
    }

    protected function createEndpoint(): string
    {
        return 'url_endpoint_create'; // Ejemplo: 'https://api.laudus.cl/sales/customers/';
    }

    protected function updateEndpoint(): string
    {
        return 'url_endpoint_update'; // Ejemplo: 'https://api.laudus.cl/sales/customers/';
    }

    protected function deleteEndpoint(): string
    {
        return 'url_endpoint_delete'; // Ejemplo: 'https://api.laudus.cl/sales/customers/';
    }
}

```

Cada servicio expone los métodos `get($id)`, `list($settings)`, `create($body)`, `update($id, $body)` y `delete($id)`.

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
