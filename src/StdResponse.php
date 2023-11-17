<?php

namespace Jsanbae\LaudusAPIPHP;

class StdResponse
{
    private $response;
    private $statusCode;

    public function __construct(array $_response, int $_statusCode)
    {
        $this->response = $_response;
        $this->statusCode = $_statusCode;
    }

    public function __invoke():array
    {
        return $this->setResponse();
    }

    private function setResponse():array
    {
        if (in_array($this->statusCode, [200, 206])) $response = $this->successResponse();
        if ($this->statusCode !== 200) $response = $this->errorResponse();
        if ($this->statusCode >= 500) $response = $this->serverErrorResponse();

        return $response;
    }

    private function responseTemplate():array
    {   
        return [
            "status" => '',
            "statusCode" => $this->statusCode,
            "message" => '',
            "data" => [],
            "error" => [],
            "extra" => '',
            'timestamp' => new \DateTimeImmutable()
        ];
    }

    private function successResponse():array
    {
        if ($this->statusCode === 200) $message = 'OK';
        if ($this->statusCode === 206) $message = 'Partial Content';

        $responseTemplate = $this->responseTemplate();
        $responseTemplate['data'] = $this->response;
        $responseTemplate['message'] = $message;
        $responseTemplate['status'] = 'success';

        return $responseTemplate;
    }

    private function errorResponse():array
    {
        $message = 'Unknown Error';
        if ($this->statusCode === 204) $message = 'No Content';
        if ($this->statusCode === 401) $message = 'Unauthorized';
        if ($this->statusCode === 400) $message = 'Bad Request';

        $responseTemplate = $this->responseTemplate();
        $responseTemplate['status'] = 'error';
        $responseTemplate['message'] = (count($this->response)) ? $this->response['message'] : $message;
        $responseTemplate['error'] = $this->response;

        return $responseTemplate;
    }
    
    private function serverErrorResponse():array
    {
        $responseTemplate = $this->responseTemplate();
        $responseTemplate['status'] = 'error';
        $responseTemplate['message'] = 'API Server Error';
        $responseTemplate['error'] = $this->response;

        return $responseTemplate;
    }
}
