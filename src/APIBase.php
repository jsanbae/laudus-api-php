<?php

namespace Jsanbae\LaudusAPIPHP;

use Jsanbae\LaudusAPIPHP\RequestSettings\RequestSettings;

abstract class APIBase
{
    protected $token;

    /** @var callable|null */
    protected $refreshToken;

    protected $fields = [];

    public function __construct(string $_token, ?callable $refreshToken = null)
    {
        $this->token = $_token;
        $this->refreshToken = $refreshToken;
    }

    abstract protected function getEndpoint(): string;
    
    abstract protected function listEndpoint(): string;

    abstract protected function createEndpoint(): string;
    
    abstract protected function deleteEndpoint(): string;

    protected function updateEndpoint(): string
    {
        return '';
    }

    /**
     * Get the fields for the API
     * 
     * @return array
     */
    public function getFields():array
    {
        if (!property_exists($this, 'fields')) throw new \Exception("The 'fields' attribute must be defined.");

        return $this->fields;
    }

    /**
     * List resources from the API
     * 
     * @param RequestSettings $_settings
     * @return array
     */
    public function list(RequestSettings $_settings): array
    {
        $settings = json_encode($_settings->toArray());

        return $this->send('POST', $this->listEndpoint(), $settings);
    }

    /**
     * Get a resource from the API
     * 
     * @param string $_resource_id
     * @return array
     */
    public function get(string $_resource_id): array
    {
        return $this->send('GET', $this->getEndpoint() . $_resource_id);
    }

    /**
     * Create a resource in the API
     * 
     * @param array $_body
     * @return array
     */
    public function create(array $_body): array
    {
        return $this->send('POST', $this->createEndpoint(), json_encode($_body));
    }

    /**
     * Update a resource in the API
     * 
     * @param string $_resource_id
     * @param array $_body
     * @return array
     */
    public function update(string $_resource_id, array $_body): array
    {
        return $this->send('PUT', $this->updateEndpoint() . $_resource_id, json_encode($_body));
    }

    /**
     * Delete a resource from the API
     * 
     * @param string $_resource_id
     * @return array
     */
    public function delete(string $_resource_id): array
    {
        return $this->send('DELETE', $this->deleteEndpoint() . $_resource_id);
    }

    /**
     * Envía la llamada y, si Laudus responde 401, refresca el bearer una sola vez y reintenta.
     *
     * @param string $method
     * @param string $url
     * @param string|null $body
     * @return array
     */
    protected function send(string $method, string $url, ?string $body = null): array
    {
        $result = $this->executeOnce($method, $url, $body, $this->token);

        if ((int) $result['statusCode'] === 401 && is_callable($this->refreshToken)) {
            $newToken = call_user_func($this->refreshToken);
            if (is_string($newToken) && $newToken !== '') {
                $this->token = $newToken;
            }
            $result = $this->executeOnce($method, $url, $body, $this->token);
        }

        $decoded = (isset($result['decoded']) && is_array($result['decoded'])) ? $result['decoded'] : [];

        return (new StdResponse($decoded, (int) $result['statusCode']))();
    }

    /**
     * @param string $method
     * @param string $url
     * @param string|null $body
     * @param string $token
     * @return array{statusCode:int,decoded:array}
     */
    protected function executeOnce(string $method, string $url, ?string $body, string $token): array
    {
        try {
            return $this->dispatch($method, $url, $body, $token);
        } catch (\Throwable $t) {
            throw new \Exception("Error API Connection: " . $t->getMessage() . "\n");
        }
    }

    /**
     * Transporte HTTP. Los tests lo sustituyen para simular 401 sin red.
     *
     * @param string $method
     * @param string $url
     * @param string|null $body
     * @param string $token
     * @return array{statusCode:int,decoded:array}
     */
    protected function dispatch(string $method, string $url, ?string $body, string $token): array
    {
        $headers = [
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization: Bearer " . $token,
        ];

        if ($body !== null) {
            $headers[] = "Content-Length: " . strlen($body);
        }

        $request = curl_init($url);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_HTTPHEADER, $headers);

        if ($body !== null) {
            curl_setopt($request, CURLOPT_POSTFIELDS, $body);
        }

        $curlCommand = $this->generateCurlCommand($url, $method, $headers, $body === null ? '' : $body);
        file_put_contents('php://stderr', "API Base - Comando {$method} cURL:\n" . $curlCommand);

        $response = curl_exec($request);
        $responseStatusCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
        curl_close($request);

        $decoded = json_decode((string) $response);
        $decoded = (is_array($decoded) || is_object($decoded)) ? (array) $decoded : [];

        return [
            'statusCode' => (int) $responseStatusCode,
            'decoded' => $decoded,
        ];
    }

    /**
     * Genera una cadena de texto con el comando cURL equivalente para Bash.
     * 
     * @param string $url
     * @param string $method
     * @param array $headers
     * @param string $data
     * @return string
     */
    private function generateCurlCommand(string $url, string $method, array $headers, string $data = ''): string 
    {
        $command = "curl -X $method '$url'";
        
        foreach ($headers as $header) {
            $command .= " \\\n  -H '$header'";
        }

        if (!empty($data)) {
            // Escapar comillas simples para evitar errores en la terminal
            $safeData = str_replace("'", "'\\''", $data);
            // Si el JSON es muy largo, intentar formatearlo para mejor legibilidad
            $decoded = json_decode($data, true);
            if ($decoded !== null) {
                $formattedData = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                $safeData = str_replace("'", "'\\''", $formattedData);
            }
            $command .= " \\\n  -d '$safeData'";
        }

        return "\n--- COMMAND START ---\n" . $command . "\n--- COMMAND END ---\n";
    }
}
