<?php

namespace Jsanbae\LaudusAPIPHP\SettingsList;

class OrderByList
{
    private $field;
    private $direction;

    public function __construct(string $_field, string $_direction)
    {
        $this->field = $_field;
        $this->direction = $_direction;
    }

    public function getField():string
    {
        return $this->field;
    }

    public function getDirection():string
    {
        return $this->direction;
    }

    public function toArray():array
    {
        return [
            'field' => $this->field,
            'direction' => $this->direction
        ];
    }
}
