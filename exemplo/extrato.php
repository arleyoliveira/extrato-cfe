<?php
require __DIR__ . '/../vendor/autoload.php';

$xml = __DIR__ . '/../docs/cfe.xml';

$logo = __DIR__ . '/../docs/logo.jpg';

$obj = new \ArleyOliveira\CFe\Extrato($xml, $logo);

echo $obj->render();