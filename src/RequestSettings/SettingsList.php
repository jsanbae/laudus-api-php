<?php

namespace Jsanbae\LaudusAPIPHP\RequestSettings;

use Jsanbae\LaudusAPIPHP\RequestSettings\FilterList;
use Jsanbae\LaudusAPIPHP\RequestSettings\OrderByList;
use Jsanbae\LaudusAPIPHP\RequestSettings\OptionsList;
use Jsanbae\LaudusAPIPHP\RequestSettings\RequestSettings;

class SettingsList implements RequestSettings
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

    public function addFilter(FilterList $_filter):self
    {
        if (!in_array($_filter->getField(), $this->fields)) throw new \Exception("Can't filter by Field that not found in fields list");

        $this->filters[] = $_filter;

        return $this;
    }

    public function setFields(array $_fields):self
    {
        $this->fields = $_fields;

        return $this;
    }

    public function addOrderBy(OrderByList $_orderBy):self
    {
        if (!in_array($_orderBy->getField(), $this->fields)) throw new \Exception("Can't order by Field that not found in fields list");

        $this->orderBy[] = $_orderBy;

        return $this;
    }

    public function paginate(int $_offset, int $_limit):self
    {
        $this->options = new OptionsList($_offset, $_limit);

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
            'options' => (empty($this->options)) ? [] : $this->options->toArray()
        ];
    }
}
