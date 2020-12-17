<?php

namespace ArleyOliveira\Common;

use ArleyOliveira\Utils\Types;
use ArleyOliveira\Utils\Mask;

class Twig
{

    protected $twig;

    /**
     * Twig constructor.
     */
    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../Resource/templates');
        $this->twig = new \Twig\Environment($loader);
        $this->registerFilters();
    }

    public function registerFilters()
    {
        $filter = new \Twig\TwigFilter('qrcode', function ($string) {
            $barcode = new \Com\Tecnick\Barcode\Barcode();
            $bobj = $barcode->getBarcodeObj(
                'QRCODE,H',                     // barcode type and additional comma-separated parameters
                $string,          // data string to encode
                -2,                             // bar width (use absolute or negative value as multiplication factor)
                -2,                             // bar height (use absolute or negative value as multiplication factor)
                'black',                        // foreground color
                array(-2, -2, -2, -2)           // padding (use absolute or negative values as multiplication factors)
            )->setBackgroundColor('white'); // background color
            return $bobj->getHtmlDiv();
        });
        $this->twig->addFilter($filter);


         $filter = new \Twig\TwigFilter('barcode128', function ($string) {
             $barcode = new \Com\Tecnick\Barcode\Barcode();
             $bobj = $barcode->getBarcodeObj(
                 'C128C',                     // barcode type and additional comma-separated parameters
                 $string,          // data string to encode
                 -1,                             // bar width (use absolute or negative value as multiplication factor)
                 -30,                             // bar height (use absolute or negative value as multiplication factor)
                 'black',                        // foreground color
                 array(0, 0, 0, 0)           // padding (use absolute or negative values as multiplication factors)
             )->setBackgroundColor('white'); // background color
             return $bobj->getHtmlDiv();
         });
        $this->twig->addFilter($filter);

        $filter = new \Twig\TwigFilter('pagamento', function ($pagamento) {
            $pagamentos = Types::PAGAMENTOS;
            return $pagamentos[(int)$pagamento];
        });
        $this->twig->addFilter($filter);


        $filter = new \Twig\TwigFilter('chave_mask', function ($chave) {
            return Mask::mask($chave, "####-####-####-####-####-####-####-####-####-####-####");
        });
        $this->twig->addFilter($filter);


    }

    /**
     * @param $name
     * @param array $context
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render($name, array $context)
    {
        return $this->twig->render('extrato.html.twig', $context);
    }
}