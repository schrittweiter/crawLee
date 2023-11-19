<?php

/** Strict types */
declare(strict_types=1);

include_once '../src/crawLee.php';

$websites = ['https://www.spiegel.de/impressum'];
$crawLee = new crawLee\crawLee(['adapter' => ['VAT','HRB','Phone','Social','Email','Address']]);

$results = []; foreach($websites as $website) {
	$results[$website] = $crawLee->parse($website);
}

print_r($results);