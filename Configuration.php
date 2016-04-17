<?php

class Configuration
{
    private $params=array();
    public function __construct($params)
    {
        $this->params=$params;
    }

    function getParam($param)
    {
        return $this->params[$param];
    }
}

