<?php namespace App\Search\Highlight;

use ArrayObject;


class Highlight
{
	/** @var array */
	private $fields = [];

	/**
	 * @param array $fields
	 */
	public function __construct($fields = [])
	{
		$this->fields = $fields;
	}

	public function highlight()
	{
		$result = [];

		$fields = [];
		foreach ($this->fields as $field) {
			$fields[$field] = new ArrayObject();
		}

		$result['highlight'] = [
			"fields" => $fields,
		];

		return $result;
	}

}