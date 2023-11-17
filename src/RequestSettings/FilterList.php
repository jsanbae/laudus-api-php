<?php

namespace Jsanbae\LaudusAPIPHP\RequestSettings;

class FilterList
{
    private $field;
    private $operator;
    private $value;

    public function __construct(string $_field, string $_operator, $_value)
    {
        $this->field = $_field;
        $this->operator = $_operator;
        $this->value = $_value;
    }

    public function getField():string
    {
        return $this->field;
    }

    public function getOperator():string
    {
        return $this->operator;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function toArray():array
    {
        return [
            'field' => $this->field,
            'operator' => $this->operator,
            'value' => $this->value
        ];
    }
}
