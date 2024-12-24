<?php

namespace Tests;
class MockData {

    public function credential()
    {
        \Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../')->load();

        return [
            'username' => $_ENV['API_LAUDUS_USERNAME'],
            'password' => $_ENV['API_LAUDUS_PASSWORD'],
            'vatid' => $_ENV['API_LAUDUS_VATID'],
        ];
    }

    public function cuentas()
    {
        return [
            'contables' => [
                'account_number' => '1101201',
            ],
            'bancarias' => [
                'bank_id' => '04',
            ],
        ];
    }

    public function compras()
    {
        return [
            'pagos' => [
                'payment_id' => 396,
                'paymentType_code' => 'O',//Cheque C, Efectivo E, Nota de crédito R, Cargo en CC/PAC P, Transferencia I, Tarjeta de crédito T, Tarjeta de débito D, Anticipo A, Fondos por rendir F, Otros O
                'journalEntryDeposited_journalEntryNumber' => 2981,
                'otherDocuments_category_code' => "01",// "0A"
                'pago_new' => [
                    "paymentType" => ['code' => 'I'],
                    "issuedDate" => (new \DateTimeImmutable("2023-04-25"))->format('Y-m-d H:i:s'),// fecha del mov cartola
                    "deposited" => false,
                    "bank" => ["bankId" => '04'],
                    "createAccounting" => true,
                    "purchaseInvoices" => [
                        [
                            "purchaseInvoiceId" =>  354,
                            "originalAmount" => 241481,
                            "amount" => 241481,
                        ]
                    ]
                ]
            ]
        ];
    }

    public function comprobante()
    {
        return [
            'comp_id' => 2503,
            'comp_nro' => 2503,//2983,2609,2675;
            'comp_type' => 'I',
            'comp_new' =>  [
                "date" => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
                "type" => "E",
                "approved" => false,
                "generated" => true,
                "notes" => "",
                "lines" => [
                    [
                        "account" => ["accountId" => 100],
                        "description" => "Pago sueldo Javier Sánchez",
                        "debit" => 1307663,
                        "credit" => 0,
                        "parityToMainCurrency" => 1,
                        "originalDebit" => 1307663,
                        "originalCredit" =>   0,
                        "document" => "2023-01",
                        "relatedTo"=> ["relatedId"=> 10, "type"=> "E"]
                    ],
                    [
                        "account" => ["accountId" => 365],
                        "description" => "Pago sueldo Javier Sánchez",
                        "debit" => 0,
                        "credit" => 1307663,
                        "parityToMainCurrency" => 1,
                        "originalDebit" => 0,
                        "originalCredit" =>   1307663,
                    ],
                ]
            ]
        ];
    }

    public function centros_costos() : array 
    {
        return [
            "costCenterId" => "001",
            "name" => "IQUIQUE",
            "discontinued" => false,
            "fullPath" => "\IQUIQUE",
            "parentId" =>"",
            "code" => "",
            "notes" => "",
            "createdBy" => [
                "userId" => "01",
                "name" => "Administrador",
            ],
            "createdAt" => "14/12/2021 17:02:39",
            "modifiedBy" => [
                "userId" => "",
                "name" => "",
            ],
            "modifiedAt" => "" 
        ];
    }

    public function ventas()
    {
        return [
            'cobros' => [
                'receipt_id' => 130,
                'doc_number' => 130,
            ],
            'ventas' => [
                'doc_number' => 492,
                'customer_vatID' => '76.123.456-2',
            ],
        ];
    }

}