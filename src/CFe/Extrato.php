<?php

namespace ArleyOliveira\CFe;

class Extrato
{
    protected $xml;

    protected $logo;

    protected $conteudo;

    /**
     * Extrato constructor.
     * @param $xml
     * @param $logo
     */
    public function __construct($xml, $logo = null)
    {
        $this->xml = (!is_file($xml))
            ? simplexml_load_string($xml)
            : simplexml_load_file($xml);

        $this->logo = $logo;
    }


    private function montar() {

    }


    public function render() {

    }


}