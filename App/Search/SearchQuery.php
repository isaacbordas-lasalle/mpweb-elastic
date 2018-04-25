<?php namespace App\Search;


class SearchQuery implements SearchInterface
{
	/** @var array */
	private $must = [];

	/** @var SearchMatchInterface */
	private $matchType;

	/**
	 * SearchQuery constructor.
	 * @param SearchMatchInterface $matchType
	 */
	public function __construct($matchType)
	{
		$this->matchType = $matchType;
	}


	/**
	 * @param string $name
	 */
	public function byName($name)
	{
		if (!empty($name)) {
			$this->must[] = ['match' => $this->matchType->getMatch('firstname', $name)];
		}

		return $this;
	}

	/**
	 * @param string $surname
	 */
	public function bySurname($surname)
	{
		if (!empty($surname)) {
			$this->must[] = ['match' => $this->matchType->getMatch('lastname', $surname)];
		}

		return $this;
	}

	public function getFilter()
	{
		return [
			'bool' => [
				'must' => $this->must,
			],
		];
	}
}