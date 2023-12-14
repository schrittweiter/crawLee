<?php

/** Strict types */
declare(strict_types=1);

namespace crawLee\Adapter;

/**
 * AdapterEmail class represents an adapter for extracting email addresses from HTML content.
 * This class extends the Adapter class.
 */
final class AdapterEmail extends Adapter {

	/**
	 * Extracts and formats email addresses.
	 *
	 * @return mixed Returns an array of unique and formatted email addresses.
	 */
	public function extract(): mixed
	{
		$rawEmails = $this->findEmailAddresses();
		$formattedEmails = $this->formatEmailAddresses($rawEmails);

		$uniqueEmails = array_unique($formattedEmails);

		return array_values($uniqueEmails);
	}

	/**
	 * Finds email addresses in the HTML content.
	 *
	 * @return array Returns an array of email addresses found in the HTML content.
	 */
	private function findEmailAddresses(): array
	{
		$pattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/';
		preg_match_all($pattern, $this->html, $matches);

		return $matches[0] ?? [];
	}

	/**
	 * Formats an array of email addresses.
	 *
	 * @param array $emailAddressList An array of email addresses to be formatted.
	 * @return array Returns an array of formatted email addresses.
	 */
	private function formatEmailAddresses(array $emailAddressList): array
	{
		return array_map(function (string $match) {
			return strtolower(trim($match));
		}, $emailAddressList);
	}

}