<?php

/** Strict types */
declare(strict_types=1);

namespace crawLee\Adapter;

/**
 * Class AdapterSocial
 *
 * This class extends the Adapter class and provides a method to extract social media profiles from HTML content.
 */
final class AdapterSocial extends Adapter {

	/**
	 * Regular expression patterns for social media URLs.
	 *
	 * The keys represent the social media platforms and the values represent the regular expressions for matching their URLs.
	 * Each regular expression is case-insensitive and allows URLs with or without "www".
	 * The regular expressions are designed to match the entire URL and not just a partial match within the URL.
	 *
	 * @var string[]
	 */
	private const SOCIAL_PATTERNS = [
		'facebook' => '/https?:\/\/(www\.)?facebook.com\/[a-zA-Z0-9._-]+/',
		'twitter' => '/https?:\/\/(www\.)?twitter.com\/[a-zA-Z0-9._-]+/',
		'linkedin' => '/https?:\/\/(www\.)?linkedin.com\/[a-zA-Z0-9._-]+/',
		'instagram' => '/https?:\/\/(www\.)?instagram.com\/[a-zA-Z0-9._-]+/',
	];

	/**
	 * Extract social media profiles from HTML content.
	 *
	 * This method searches for specific social media patterns in the HTML content and
	 * returns an array of matched profiles for each platform.
	 *
	 * @return array An associative array where the keys represent the platform and the
	 *               values are arrays of matched profiles.
	 */
	public function extract(): mixed
	{
		$profiles = [];
		foreach (self::SOCIAL_PATTERNS as $platform => $pattern) {
			if (preg_match_all($pattern, $this->html, $matches)) {
				$profiles[$platform] = $matches[0];
			}
		}
		return $profiles;
	}
}