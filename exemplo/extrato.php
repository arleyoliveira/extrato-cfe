<?php
require __DIR__ . '/../vendor/autoload.php';

$xml = __DIR__ . '/../docs/cfe.xml';

$logo = __DIR__ . '/../docs/logo.jpg';


$infoConsultaAplicativo = "Consulte o QR Code pelo aplicativo \"De olho na nota\", disponível na AppStore(Apple) e PlayStore(Android)";

$obj = new \ArleyOliveira\CFe\Extrato($xml, $logo, $infoConsultaAplicativo);

echo $obj->showPDF();

