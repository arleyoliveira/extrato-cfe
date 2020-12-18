<?php
require __DIR__ . '/../vendor/autoload.php';

use ArleyOliveira\CFe\Extrato;

$xml = __DIR__ . '/cfe.xml';

$logo = __DIR__ . '/logo.jpg';

$infoConsultaAplicativo = "Consulte o QR Code pelo aplicativo \"De olho na nota\", disponível na AppStore(Apple) e PlayStore(Android)";

$extrato = new Extrato($xml, $logo, $infoConsultaAplicativo);

$pdf = $extrato->pdf();

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="extrato.pdf"');
echo $pdf;

