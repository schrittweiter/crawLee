<?php

include_once '../src/crawLee.php';

$website = new crawLee\crawLee();

$website
	->setConfig(['sets' => ['VAT','HRB','Phone','Social','Email','Address']])
	->setUrl('https://www.spiegel.de/impressum')
	->html()
	->extract();