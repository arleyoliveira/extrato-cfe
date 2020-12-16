<?php


namespace ArleyOliveira\CFe;

use Dompdf\Dompdf;

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


        if ($logo) {
            $type = pathinfo($logo, PATHINFO_EXTENSION);
            $data = file_get_contents($logo);
            $this->logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    }


    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function make()
    {

        $attr = '@attributes';
        $std = new \stdClass();
        $std->logo = $this->logo;
        $std->emitente = $this->xml->infCFe->emit;

        $std->emitente->CNPJ = vsprintf("%s%s.%s%s%s.%s%s%s/%s%s%s%s-%s%s", str_split($std->emitente->CNPJ));
        $std->emitente->enderEmit->CEP = vsprintf("%s%s%s%s%s-%s%s%s", str_split($std->emitente->enderEmit->CEP));

        $std->ide = $this->xml->infCFe->ide;

        $std->chave = substr((string)$this->xml->infCFe->attributes()["Id"], 3);


        $produtos = [];
        if (count($this->xml->infCFe->det) > 1) {
            foreach ($this->xml->infCFe->det as $prod) {
                unset($prod->$attr);
                $produtos[] = $prod;
            }
        } else {
            unset($this->xml->infCFe->det->$attr);
            $produtos[] = $this->xml->infCFe->det;
        }

        $std->produtos = $produtos;

        //var_dump($std->produtos); die;

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../Resource/templates');
        $twig = new \Twig\Environment($loader);

        $filter = new \Twig\TwigFilter('barcode', function ($string) {
            $barcode = new \Com\Tecnick\Barcode\Barcode();
            $bobj = $barcode->getBarcodeObj(
                'QRCODE,H',                     // barcode type and additional comma-separated parameters
                $string,          // data string to encode
                -4,                             // bar width (use absolute or negative value as multiplication factor)
                -4,                             // bar height (use absolute or negative value as multiplication factor)
                'black',                        // foreground color
                array(-2, -2, -2, -2)           // padding (use absolute or negative values as multiplication factors)
            )->setBackgroundColor('white'); // background color
            return $bobj->getHtmlDiv();
        });

        $twig->addFilter($filter);

        return $twig->render('extrato.html.twig', (array)$std);
    }

    public function render()
    {
        $conteudo = $this->make();

        echo $conteudo;
        die;

        // instantiate and use the dompdf class
        /*        $dompdf = new Dompdf();
                $dompdf->loadHtml($conteudo);
        
                // (Optional) Setup the paper size and orientation
                $dompdf->setPaper([0, 0, 235.00, 841.89], 'portrait');
        
        
                // Render the HTML as PDF
                $dompdf->render();
        
                // Output the generated PDF to Browser
                $dompdf->stream();*/

    }


}