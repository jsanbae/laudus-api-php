<?php

namespace Jsanbae\LaudusAPIPHP\SettingsList;

class OptionsList
{
    private $offset = 0;
    private $limit = 10;

    public function __construct($_offset = 0, $_limit = 10)
    {
        $this->offset = $_offset;
        $this->limit = $_limit;
    }
    
    public function getOffset():int
    {
        return $this->offset;
    }

    public function getLimit():int
    {
        return $this->limit;
    }

    public function toArray():array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit
        ];
    }
}
