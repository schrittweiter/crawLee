<?php

/** Strict types */
declare(strict_types=1);

namespace crawLee\Adapter;

/**
 * Class AdapterHRB
 *
 * This class extends the Adapter class and provides the functionality to extract the HRB number from an HTML string.
 */
final class AdapterHRB extends Adapter {

	/**
	 * Extracts the HRB number from the HTML.
	 *
	 * @return string|null The HRB number if found in the HTML, otherwise null.
	 */
	public function extract(): ?string
	{
		$hrbNumberMatches = $this->getHRBNumberMatches($this->html);
		return $this->normalizeHRBNumber($hrbNumberMatches);
	}

	/**
	 * Extracts the HRB number from the given HTML.
	 *
	 * @param string $html The HTML from which to extract the HRB number.
	 * @return array|null An array containing the HRB number if found, otherwise null.
	 */
	private function getHRBNumberMatches(string $html): ?array
	{
		if (preg_match('/HRB\s*(\d+(\s*\d*)*)/', $html, $matches)) {
			return $matches;
		}
		return null;
	}

	/**
	 * Normalizes the HRB number.
	 *
	 * @param array|null $hrbNumberMatches The HRB number to be normalized.
	 * @return string|null The normalized HRB number if hrbNumberMatches is not null, otherwise null.
	 */
	private function normalizeHRBNumber(?array $hrbNumberMatches): ?string
	{
		if ($hrbNumberMatches && isset($hrbNumberMatches[1])) {
			return 'HRB' . str_replace(' ', '', $hrbNumberMatches[1]);
		}
		return null;
	}
}