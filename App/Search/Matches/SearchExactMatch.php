<?php namespace App\Search;


class SearchExactMatch implements SearchMatchInterface
{
	public function getMatch($field, $value)
	{
		return [$field => $value];
	}
}