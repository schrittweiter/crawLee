<?php

declare(strict_types=1);

namespace crawLee\Adapter;

/**
 * Base class for data extraction
 */
final class AdapterEmail extends Adapter {

	public function extract()
	{
		$pattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/';
		preg_match_all($pattern, $this->html, $matches);

		$emails = array_map(function(string $match) { return strtolower(trim($match)); },$matches[0] ?? []);

		// Remove duplicates
		$uniqueEmails = array_unique($emails);

		return array_values($uniqueEmails);
	}

}