<?php

namespace Jsanbae\LaudusAPIPHP\RequestSettings;

use Jsanbae\LaudusAPIPHP\RequestSettings\RequestSettings;

use DateTimeImmutable;

class SettingsMayorList implements RequestSettings
{
    private $accountNumberFrom;
    private $accountNumberTo;
    private $dateFrom;
    private $dateTo;
    private $costCenterId;
    private $bookId;
    private $offset = 0;
    private $limit = 999999;

    public function __construct(int $_accountNumberFrom, $_accountNumberTo = null, DateTimeImmutable $_dateFrom = null, DateTimeImmutable $_dateTo = null, $_costCenterId = null, $_bookId = null)
    {
        $this->accountNumberFrom = $_accountNumberFrom;
        $this->accountNumberTo = $_accountNumberTo;
        $this->dateFrom = $_dateFrom;
        $this->dateTo = $_dateTo;
        $this->costCenterId = $_costCenterId;
        $this->bookId = $_bookId;
    }

    public function getAccountNumberFrom():int
    {
        return $this->accountNumberFrom;
    }

    public function getAccountNumberTo():int
    {
        return $this->accountNumberTo;
    }

    public function getDateFrom():DateTimeImmutable
    {
        return $this->dateFrom;
    }

    public function getDateTo():DateTimeImmutable
    {
        return $this->dateTo;
    }

    public function getCostCenterId()
    {
        return $this->costCenterId;
    }

    public function getBookId()
    {
        return $this->bookId;
    }

    public function getOffset():int
    {
        return $this->offset;
    }

    public function getLimit():int
    {
        return $this->limit;
    }

    public function paginate(int $_offset, int $_limit):self
    {
        $this->offset = $_offset;
        $this->limit = $_limit;

        return $this;
    }

    public function toArray():array
    {
        $options = [
            'accountNumberFrom' => $this->accountNumberFrom,
            'accountNumberTo' => $this->accountNumberTo,
            'dateFrom' => $this->dateFrom,
            'dateTo' => $this->dateTo,
            'costCenterId' => $this->costCenterId,
            'bookId' => $this->bookId,
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];

        return $options;
    }
}
