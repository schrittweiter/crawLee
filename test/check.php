<?php

include_once '../src/crawLee.php';

$website = new schrittweiter\crawLee\crawLee('https://www.spiegel.de/impressum');

echo '<pre>';
var_dump($website->extractVAT());
echo '</pre>';