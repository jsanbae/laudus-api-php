<?php

namespace Jsanbae\LaudusAPIPHP\SettingsList;

use Jsanbae\LaudusAPIPHP\SettingsList\FilterList;
use Jsanbae\LaudusAPIPHP\SettingsList\OrderByList;
use Jsanbae\LaudusAPIPHP\SettingsList\OptionsList;

class SettingsList
{

    private $fields;
    private $filters;
    private $orderBy;
    private $options;

    public function __construct()
    {
        $this->fields = [];
        $this->filters = [];
        $this->orderBy = [];
        $this->options = [];
    }

    public function addFilter(FilterList $_filter)
    {
        if (!in_array($_filter->getField(), $this->fields)) throw new \Exception("Can't filter by Field that not found in fields list");

        $this->filters[] = $_filter;

        return $this;
    }

    public function setFields(array $_fields)
    {
        $this->fields = $_fields;

        return $this;
    }

    public function addOrderBy(OrderByList $_orderBy)
    {
        if (!in_array($_orderBy->getField(), $this->fields)) throw new \Exception("Can't order by Field that not found in fields list");

        $this->orderBy[] = $_orderBy;

        return $this;
    }
    
    public function setOptions(OptionsList $_options)
    {
        $this->options = $_options;
        
        return $this;
    }

    public function toArray():array
    {
        return [
            'fields' => $this->fields,
            'filterBy' => array_reduce($this->filters, function($filters, $filter) {
                $filters[] = $filter->toArray();
                return $filters;
            }, []),
            'orderby' => array_reduce($this->orderBy, function($filters, $filter) {
                $filters[] = $filter->toArray();
                return $filters;
            }, []),
            'options' => $this->options->toArray()
        ];
    }
}
