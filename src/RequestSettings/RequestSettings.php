<?php

namespace Jsanbae\LaudusAPIPHP\RequestSettings;

interface RequestSettings
{
    public function paginate(int $_offset, int $_limit):RequestSettings;
    public function toArray():array;
}
