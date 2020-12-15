<?php
require __DIR__ . '/../vendor/autoload.php';

$xml = __DIR__ . '/../docs/cfe.xml';

$obj = new \ArleyOliveira\CFe\Extrato($xml);

echo $obj->render();