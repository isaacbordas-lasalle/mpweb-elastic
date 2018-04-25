<?php namespace App\Search\Types;

use App\Search\Search;

class SearchBankAccounts extends Search
{

	protected function getIndex()
	{
		return 'bank';
	}

	protected function getType()
	{
		return 'account';
	}
}