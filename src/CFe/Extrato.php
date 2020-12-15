<?php

namespace ArleyOliveira\CFe;

class Extrato
{
    protected $xml;

    protected $logo;

    protected $emitente;


    /**
     * Extrato constructor.
     * @param $xml
     * @param $logo
     */
    public function __construct(string $xml, string $logo = '')
    {
        $this->xml = (!is_file($xml))
            ? simplexml_load_string($xml)
            : simplexml_load_file($xml);

        $this->logo = $logo;
        $this->handle();
    }

    private function handle()
    {
        $this->emitente = $this->xml->infCFe->emit;
    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function make()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../Resource/templates');
        $twig = new \Twig\Environment($loader);

        return $twig->render('extrato.html.twig', [
            'emitente' => $this->emitente,
            'name' => 'Arley Oliveira'
        ]);
    }

    public function render()
    {
        echo $this->make();
    }


}