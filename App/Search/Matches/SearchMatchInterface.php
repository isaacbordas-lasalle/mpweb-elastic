<?php namespace App\Search;


interface SearchMatchInterface
{
	public function getMatch($field, $value);
}