<?php

declare(strict_types=1);

namespace crawLee\Adapter;

/**
 * Base class for data extraction
 */
final class AdapterPhone extends Adapter {

	public function extract(): mixed
	{
		// Examples: Tel. +49 123 4567890 or Phone: 0123-4567890 or Tel: (0123) 456-7890, etc.
		$pattern = '/(Tel\.?|Phone\.?):?\s*((\+?\d{1,4}[.\-\s]?)?(\(?\d{1,5}\)?[.\-\s]?)?(\d{1,5}[.\-\s]?)*\d{1,5})/';
		preg_match_all($pattern, $this->html, $matches);

		$phoneNumbers = [];

		if (isset($matches[2])) {
			foreach ($matches[2] as $match) {
				// Remove any character that's not a digit, not a parenthesis, and not a plus sign
				$cleanedNumber = preg_replace('/[^\d\+\(\)]/', '', $match);
				$phoneNumbers[] = $cleanedNumber;
			}
		}

		// Remove duplicates
		$uniquePhoneNumber = array_unique($phoneNumbers);

		return array_values($uniquePhoneNumber);
	}

}