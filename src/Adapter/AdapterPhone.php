<?php

declare(strict_types=1);

namespace crawLee\Adapter;

/**
 * Class AdapterPhone
 *
 * This class is an adapter for extracting phone numbers from HTML.
 */
final class AdapterPhone extends Adapter {

	/**
	 * Extracts phone numbers from the given HTML string.
	 *
	 * @return mixed An array of unique phone numbers, with any non-digit characters removed.
	 */
	public function extract(): mixed
	{
		$pattern = '/(Tel\.?|Phone\.?):?\s*((\+?\d{1,4}[.\-\s]?)?(\(?\d{1,5}\)?[.\-\s]?)?(\d{1,5}[.\-\s]?)*\d{1,5})/';
		preg_match_all($pattern, $this->html, $matches);

		$phoneNumbers = [];

		$phoneNumberMatches = $matches[2] ?? [];
		foreach ($phoneNumberMatches as $match) {
			$phoneNumbers[] = $this->cleanPhoneNumber($match);
		}

		$uniquePhoneNumbers = array_unique($phoneNumbers);

		return array_values($uniquePhoneNumbers);
	}

	/**
	 * Clean the given phone number by removing any character that is not a digit, not a parenthesis, and not a plus sign.
	 *
	 * @param string $phoneNumber The phone number to be cleaned.
	 * @return string The cleaned phone number.
	 */
	private function cleanPhoneNumber(string $phoneNumber): string
	{
		// Remove any character that's not a digit, not a parenthesis,
		// and not a plus sign
		return preg_replace('/[^\d+()]/', '', $phoneNumber);
	}

}