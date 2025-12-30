<?php

namespace Jsanbae\LaudusAPIPHP;

use Jsanbae\LaudusAPIPHP\RequestSettings\RequestSettings;

abstract class APIBase
{
    protected $token;
    protected $fields = [];

    public function __construct(string $_token)
    {
        $this->token = $_token;
    }

    abstract protected function getEndpoint(): string;
    
    abstract protected function listEndpoint(): string;

    abstract protected function createEndpoint(): string;
    
    abstract protected function deleteEndpoint(): string;

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
        try {
            $settings = json_encode($_settings->toArray());
            
            $headers = [
                "Accept: application/json",
                "Content-Type: application/json",
                "Content-Length: " . strlen($settings),
                "Authorization: Bearer " . $this->token
            ];

            $request = curl_init($this->listEndpoint()); 
            curl_setopt($request, CURLOPT_VERBOSE, true);
            $verbose = fopen('php://temp', 'w+');
            curl_setopt($request, CURLOPT_STDERR, $verbose);
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($request, CURLOPT_POSTFIELDS, $settings);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($request, CURLOPT_HTTPHEADER, $headers);

            $curlCommand = $this->generateCurlCommand($this->listEndpoint(), "POST", $headers, $settings);
            fwrite(STDERR, "API Base - Comando LIST cURL:\n" . $curlCommand);

            //make request
            $response = curl_exec($request);
            //respond status code
            $responseStatusCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
            curl_close($request);
            $response_decoded = (array) json_decode($response);

            // rewind($verbose);
            // $verboseLog = stream_get_contents($verbose);
            // fwrite(STDERR, "API Base - Log de depuración:\n" . htmlspecialchars($verboseLog));

            return (new StdResponse($response_decoded, $responseStatusCode))();
            
        } catch (\Throwable $t) {
            throw new \Exception("Error API Connection: " . $t->getMessage() . "\n");
        }
    }

    /**
     * Get a resource from the API
     * 
     * @param string $_resource_id
     * @return array
     */
    public function get(string $_resource_id): array
    {
        try {
            $request = curl_init($this->getEndpoint() . $_resource_id);
            $headers = [
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: Bearer " . $this->token
            ];

            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($request, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($request, CURLOPT_HTTPHEADER, $headers);

            $curlCommand = $this->generateCurlCommand($this->getEndpoint() . $_resource_id, "GET", $headers);
            fwrite(STDERR, "API Base - Comando GET cURL:\n" . $curlCommand);

            //make request
            $response = curl_exec($request);    
            //respond status code
            $responseStatusCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
            curl_close($request);

            $response_decoded = (array) json_decode($response);

            return (new StdResponse($response_decoded, $responseStatusCode))();
                
        } catch (\Throwable $t) {
            throw new \Exception("Error API Connection: " . $t->getMessage() . "\n");
        }
    }

    /**
     * Create a resource in the API
     * 
     * @param array $_body
     * @return array
     */
    public function create(array $_body): array
    {
        try {
            $body = json_encode($_body);

            $headers = [
                "Accept: application/json",
                "Content-Type: application/json",
                "Content-Length: " . strlen($body),
                "Authorization: Bearer " . $this->token
            ];

            $request = curl_init($this->createEndpoint()); 
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($request, CURLOPT_POSTFIELDS, $body);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($request, CURLOPT_HTTPHEADER, $headers);

            $curlCommand = $this->generateCurlCommand($this->createEndpoint(), "POST", $headers, $body);
            fwrite(STDERR, "API Base - Comando CREATE cURL:\n" . $curlCommand);

            //make request
            $response = curl_exec($request);
            //respond status code
            $responseStatusCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
            curl_close($request);
            $response_decoded = (array) json_decode($response);
            return (new StdResponse($response_decoded, $responseStatusCode))();
            
        } catch (\Throwable $t) {
            throw new \Exception("Error API Connection: " . $t->getMessage() . "\n");
        }
    }

    /**
     * Delete a resource from the API
     * 
     * @param string $_resource_id
     * @return array
     */
    public function delete(string $_resource_id): array
    {
        try {
            $request = curl_init($this->deleteEndpoint() . $_resource_id);
            $headers = [
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: Bearer " . $this->token
            ];

            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($request, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($request, CURLOPT_HTTPHEADER, $headers);

            $curlCommand = $this->generateCurlCommand($this->deleteEndpoint() . $_resource_id, "DELETE", $headers);
            fwrite(STDERR, "API Base - Comando DELETE cURL:\n" . $curlCommand);

            //make request
            $response = curl_exec($request);    
            //respond status code
            $responseStatusCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
            curl_close($request);

            $response_decoded = (array) json_decode($response);

            return (new StdResponse($response_decoded, $responseStatusCode))();
                
        } catch (\Throwable $t) {
            throw new \Exception("Error API Connection: " . $t->getMessage() . "\n");
        }
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
