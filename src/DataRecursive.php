<?php

namespace Jsanbae\LaudusAPIPHP;

use Jsanbae\LaudusAPIPHP\RequestSettings\RequestSettings;
use Closure;

class DataRecursive
{
    const MAX_DUMP = 50000;
    private $list_callback;
    private $request_settings;

    public function __construct(Closure $_list_callback, RequestSettings $_request_settings)
    {
        $this->list_callback = $_list_callback;
        $this->request_settings = $_request_settings;
    }

    public function __invoke()
    {
        $first = true;
        $rango_inicial = 0;
        $final_response = [];

        do {
            $this->request_settings->paginate($rango_inicial, 999999);
            $api_response = ($this->list_callback)($this->request_settings);

            if ($first) $final_response = $api_response;

            if (empty($api_response['data'])) throw new \Exception("Can't retrieve Data from API");

            $data_size = count($api_response['data']);

            $final_response['data'] = array_merge($final_response['data'], $api_response['data']);

            $rango_inicial += self::MAX_DUMP + 1;

            $first = false;

        } while ($data_size == self::MAX_DUMP);

        return $final_response;
    }

}
