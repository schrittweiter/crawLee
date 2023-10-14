<?php

namespace schrittweiter\crawLee;



/**
 * VCard PHP Class to generate .vcard files and save them to a file or output as a download.
 */
class crawLee {

	private $htmlContent;
	/**
	 * @var mixed|string
	 */
	private mixed $url;

	public function __construct($url = '') {

		$this->url = $url;
		$this->grabHtml($url);
	}

	/**
	 * get html from transmitted page
	 *
	 * @param string $url
	 * @return void
	 */
	public function grabHtml(string $url = ''): void
	{

		if(empty($url)) {
			$url = $this->url;
		}

		$this->htmlContent = file_get_contents($url);
	}

	public function extractVAT() {
		// The pattern expects a prefix of two letters (e.g., "DE") followed by up to 15 digits, allowing for spaces in between.

		$pattern = '/([A-Z]{2}\s*)\d+(\s*\d*)*/';
		if (preg_match($pattern, $this->htmlContent, $matches)) {
			// Remove all spaces from the match for consistency
			return str_replace(' ', '', $matches[0]);
		}
		return null;
	}

	/**
	 * extract hrb data from html content
	 * formats like the following are considered: HRB12345, HRB 12345, HRB 1 2 3 4 5
	 *
	 * @return string|null
	 */
	public function extractHRB(): ?string
	{
		if (preg_match('/HRB\s*(\d+(\s*\d*)*)/', $this->htmlContent, $matches)) {
			// Remove all spaces from the number for consistency
			return 'HRB'.str_replace(' ', '', $matches[1]);
		}
		return null;
	}

	/**
	 * extract all phone numbers and convert them to a matching format and remove any duplicates
	 *
	 * @return array
	 */
	public function extractPhoneNumbers(): array
	{
		// Examples: Tel. +49 123 4567890 or Phone: 0123-4567890 or Tel: (0123) 456-7890, etc.
		$pattern = '/(Tel\.?|Phone\.?):?\s*((\+?\d{1,4}[.\-\s]?)?(\(?\d{1,5}\)?[.\-\s]?)?(\d{1,5}[.\-\s]?)*\d{1,5})/';
		preg_match_all($pattern, $this->htmlContent, $matches);

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

	/**
	 * extract all email addresses and remove any duplicates
	 *
	 * @return array|string[]
	 */
	public function extractEmailAddresses() {
		$pattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/';
		preg_match_all($pattern, $this->htmlContent, $matches);

		$emails = array_map(function(string $match) { return strtolower(trim($match)); },$matches[0] ?? []);

		// Remove duplicates
		$uniqueEmails = array_unique($emails);

		return array_values($uniqueEmails);
	}

	public function extractSocialMediaProfiles() {
		$profiles = [];
		$platforms = ['facebook', 'twitter', 'linkedin', 'instagram'];
		foreach ($platforms as $platform) {
			if (preg_match('/https?:\/\/(www\.)?' . $platform . '.com\/[a-zA-Z0-9._-]+/', $this->htmlContent, $matches)) {
				$profiles[$platform] = $matches[0];
			}
		}
		return $profiles;
	}

	public function extractAddress() {
		// This is just a simple representation. Actual address extraction can be much more complex.
		if (preg_match('/\d{1,5} [\w\s]+, [\w\s]+, \w{2} \d{5}/', $this->htmlContent, $matches)) {
			return $matches[0];
		}
		return null;
	}

}