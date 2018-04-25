<?php


namespace App\Search;


class SearchMultiQuery implements SearchInterface
{
	/** @var string */
	private $search_text;
	/** @var array */
	private $fields = [];

	/**
	 * SearchMultiQuery constructor.
	 * @param string $search_text
	 * @param array $fields
	 */
	public function __construct($search_text, array $fields)
	{
		$this->search_text = $search_text;
		$this->fields      = $fields;
	}


	public function getFilter()
	{
		if (empty($this->search_text)) {
			return ["match_all" => new \ArrayObject()];
		}

		return [
			"multi_match" => [
				"query"       => $this->search_text,
				"type"        => "best_fields",
				"fields"      => $this->fields,
				"tie_breaker" => 0.3,
				"fuzziness"   => "AUTO",
			],
		];
	}
}