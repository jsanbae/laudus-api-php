<?php

use Jsanbae\LaudusAPIPHP\Credentials\LaudusCredential;
use Jsanbae\LaudusAPIPHP\LaudusAPI;
use PHPUnit\Framework\TestCase;

class CountingLaudusAPI extends LaudusAPI
{
    public static $calls = 0;

    public static $response = [];

    public function __construct(?array $tokenData = null)
    {
        parent::__construct(new LaudusCredential('user', 'secret', '76123456-7'), $tokenData);
    }

    public function getToken(): array
    {
        self::$calls++;

        return self::$response;
    }
}

class LaudusAPITokenTest extends TestCase
{
    protected function setUp(): void
    {
        CountingLaudusAPI::$calls = 0;
        CountingLaudusAPI::$response = [];
    }

    public function test_token_vigente_no_llama_al_login(): void
    {
        $expiration = (new DateTimeImmutable('+2 days'))->format('c');
        CountingLaudusAPI::$response = $this->successResponse('fresh-token', $expiration);

        $api = new CountingLaudusAPI([
            'token' => 'cached-token',
            'expiration' => $expiration,
        ]);

        $this->assertSame(0, CountingLaudusAPI::$calls);
        $this->assertSame('cached-token', $api->tokenPayload()['token']);
    }

    public function test_sin_token_llama_get_token_una_sola_vez(): void
    {
        $expiration = (new DateTimeImmutable('+2 days'))->format('c');
        CountingLaudusAPI::$response = $this->successResponse('fresh-token', $expiration);

        $api = new CountingLaudusAPI(null);

        $this->assertSame(1, CountingLaudusAPI::$calls);
        $this->assertSame('fresh-token', $api->tokenPayload()['token']);
        $this->assertSame($expiration, $api->tokenPayload()['expiration']);

        $api->refreshToken();

        $this->assertSame(2, CountingLaudusAPI::$calls);
    }

    public function test_login_con_error_lanza_y_no_reintenta(): void
    {
        CountingLaudusAPI::$response = [
            'status' => 'error',
            'message' => 'bad credentials',
            'data' => [],
        ];

        try {
            new CountingLaudusAPI(null);
            $this->fail('El constructor debió fallar');
        } catch (Exception $e) {
            $this->assertStringContainsString('Error API Connection', $e->getMessage());
        }

        $this->assertSame(1, CountingLaudusAPI::$calls);
        $this->assertStringNotContainsString('Cache::', (string) file_get_contents(dirname(__DIR__).'/src/LaudusAPI.php'));
    }

    private function successResponse(string $token, string $expiration): array
    {
        return [
            'status' => 'success',
            'message' => 'OK',
            'data' => [
                'token' => $token,
                'expiration' => $expiration,
            ],
        ];
    }
}
