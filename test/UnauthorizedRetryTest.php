<?php

use Jsanbae\LaudusAPIPHP\APIBase;
use Jsanbae\LaudusAPIPHP\RequestSettings\SettingsList;
use PHPUnit\Framework\TestCase;

class FakeTransportEndpoint extends APIBase
{
    public $tokens = [];

    private $statusCodes;

    public function __construct(array $statusCodes, ?callable $refreshToken = null)
    {
        parent::__construct('token-old', $refreshToken);
        $this->statusCodes = $statusCodes;
    }

    public function listProbe(): array
    {
        return $this->list((new SettingsList())->setFields(['id']));
    }

    protected function dispatch(string $method, string $url, ?string $body, string $token): array
    {
        $this->tokens[] = $token;
        $statusCode = (int) array_shift($this->statusCodes);

        return [
            'statusCode' => $statusCode,
            'decoded' => ['message' => $statusCode === 401 ? 'Unauthorized' : 'ok'],
        ];
    }

    protected function getEndpoint(): string
    {
        return 'https://example.test/items/';
    }

    protected function listEndpoint(): string
    {
        return 'https://example.test/items/list';
    }

    protected function createEndpoint(): string
    {
        return 'https://example.test/items';
    }

    protected function deleteEndpoint(): string
    {
        return 'https://example.test/items/';
    }
}

class UnauthorizedRetryTest extends TestCase
{
    public function test_un_401_refresca_una_vez_y_reintenta_con_el_token_nuevo(): void
    {
        $refreshes = 0;
        $endpoint = new FakeTransportEndpoint([401, 200], function () use (&$refreshes) {
            $refreshes++;

            return 'token-new';
        });

        $response = $endpoint->listProbe();

        $this->assertSame(1, $refreshes);
        $this->assertSame(['token-old', 'token-new'], $endpoint->tokens);
        $this->assertSame('success', $response['status']);
    }

    public function test_dos_401_refrescan_solo_una_vez(): void
    {
        $refreshes = 0;
        $endpoint = new FakeTransportEndpoint([401, 401], function () use (&$refreshes) {
            $refreshes++;

            return 'token-new';
        });

        $response = $endpoint->listProbe();

        $this->assertSame(1, $refreshes);
        $this->assertSame(['token-old', 'token-new'], $endpoint->tokens);
        $this->assertSame('error', $response['status']);
        $this->assertSame(401, $response['statusCode']);
    }
}
