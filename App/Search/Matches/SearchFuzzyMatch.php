<?php namespace App\Search;


class SearchFuzzyMatch implements SearchMatchInterface
{
	public function getMatch($field, $value)
	{
		return [
			$field => [
				'query'     => $value,
				"fuzziness" => "AUTO",
				"operator"  => "and",
			],
		];
	}
}