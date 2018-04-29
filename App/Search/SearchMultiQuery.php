<?php

namespace App\Search;

class SearchMultiQuery implements SearchInterface
{
    /** @var array */
    private $query;
	/** @var string */
	private $search_text;
    /** @var int */
    private $search_balance_from;
    /** @var int */
    private $search_balance_to;
    /** @var string */
    private $city;
    /** @var string */
    private $state;
	/** @var array */
	private $fields = [];

	/**
	 * SearchMultiQuery constructor.
	 * @param string $search_text
	 * @param int $search_balance_from
	 * @param int $search_balance_to
	 * @param string $city
	 * @param string $state
	 * @param array $fields
	 */
	public function __construct($search_text, $search_balance_from = null, $search_balance_to = null, $city = null, $state = null, array $fields)
	{
		$this->query = null;
		$this->search_text = $search_text;
		$this->search_balance_from = $search_balance_from;
		$this->search_balance_to = $search_balance_to;
		$this->city = $city;
		$this->state = $state;
		$this->fields = $fields;
	}

	public function getFilter()
    {
        if (empty($this->search_text) && (empty($this->search_balance_from) && empty($this->search_balance_to))) {
            $this->query = ["match_all" => new \ArrayObject()];
        }

        if (!empty($this->search_text) && (empty($this->search_balance_from) && empty($this->search_balance_to))) {
            $this->query = $this->OnlyTextSearch();
        }

        if (!empty($this->search_text) && (!empty($this->search_balance_from) && empty($this->search_balance_to))) {
            $this->query = $this->TextBalanceFromSearch();
        }

        if (!empty($this->search_text) && (empty($this->search_balance_from) && !empty($this->search_balance_to))) {
            $this->query = $this->TextBalanceToSearch();
        }

        if (!empty($this->search_text) && (!empty($this->search_balance_from) && !empty($this->search_balance_to))) {
            $this->query = $this->TextFullBalanceSearch();
        }

        if (empty($this->search_text) && (!empty($this->search_balance_from) && empty($this->search_balance_to))) {
            $this->query = $this->OnlyBalanceFromSearch();
        }

        if (empty($this->search_text) && (empty($this->search_balance_from) && !empty($this->search_balance_to))) {
            $this->query = $this->OnlyBalanceToSearch();
        }

        if (empty($this->search_text) && (!empty($this->search_balance_from) && !empty($this->search_balance_to))) {
            $this->query = $this->FullBalanceSearch();
        }

        if (!empty($this->city)) {
            $city = $this->FilterByCity();
            $this->query['bool']['filter'][]['match']['city'] = $city;
        }

        if (!empty($this->state)) {
            $state = $this->FilterByState();
            $this->query['bool']['filter'][]['match']['state'] = $state;
        }

        return $this->query;
	}

    private function OnlyTextSearch()
    {
        $int_query = [
            "multi_match" => [
                "query" => $this->search_text,
                "type" => "best_fields",
                "fields" => $this->fields,
                "tie_breaker" => 0.3,
                "fuzziness" => "AUTO",
            ],
        ];

        $this->query['bool']['must'] = $int_query;
        return $this->query;
    }

    private function TextBalanceFromSearch()
    {
        $int_query = [
           "multi_match" => [
                "query" => $this->search_text,
                "type" => "best_fields",
                "fields" => $this->fields,
                "tie_breaker" => 0.3,
                "fuzziness" => "AUTO",
            ]
        ];

        $filter_query = [
            "range" => [
                "balance" => [
                    "gte" => $this->search_balance_from
                ]
            ]
        ];

        $this->query['bool']['must'] = $int_query;
        $this->query['bool']['filter'][] = $filter_query;

        return $this->query;
    }

    private function TextBalanceToSearch()
    {
        $int_query = [
            "multi_match" => [
                "query" => $this->search_text,
                "type" => "best_fields",
                "fields" => $this->fields,
                "tie_breaker" => 0.3,
                "fuzziness" => "AUTO",
            ]
        ];

        $filter_query = [
            "range" => [
                "balance" => [
                    "lte" => $this->search_balance_to
                ]
            ]
        ];

        $this->query['bool']['must'] = $int_query;
        $this->query['bool']['filter'][] = $filter_query;

        return $this->query;
    }

    private function TextFullBalanceSearch()
    {
        $int_query = [
            "multi_match" => [
                "query" => $this->search_text,
                "type" => "best_fields",
                "fields" => $this->fields,
                "tie_breaker" => 0.3,
                "fuzziness" => "AUTO",
            ]
        ];

        $filter_query = [
            "range" => [
                "balance" => [
                    "gte" => $this->search_balance_from,
                    "lte" => $this->search_balance_to
                ]
            ]
        ];

        $this->query['bool']['must'] = $int_query;
        $this->query['bool']['filter'][] = $filter_query;

        return $this->query;
    }

    private function OnlyBalanceFromSearch()
    {
        $int_query = ["match_all" => new \ArrayObject()];

        $filter_query = [
            "range" => [
                "balance" => [
                    "gte" => $this->search_balance_from
                ]
            ]
        ];

        $this->query['bool']['must'] = $int_query;
        $this->query['bool']['filter'][] = $filter_query;

        return $this->query;
    }

    private function OnlyBalanceToSearch()
    {
        $int_query = ["match_all" => new \ArrayObject()];

        $filter_query = [
            "range" => [
                "balance" => [
                    "lte" => $this->search_balance_to
                ]
            ]
        ];

        $this->query['bool']['must'] = $int_query;
        $this->query['bool']['filter'][] = $filter_query;

        return $this->query;
    }

    private function FullBalanceSearch()
    {
        $int_query = ["match_all" => new \ArrayObject()];

        $filter_query = [
            "range" => [
                "balance" => [
                    "gte" => $this->search_balance_from,
                    "lte" => $this->search_balance_to
                ]
            ]
        ];

        $this->query['bool']['must'] = $int_query;
        $this->query['bool']['filter'][] = $filter_query;

        return $this->query;
    }

    private function FilterByCity()
    {
        return [
            "query" => $this->city
        ];
    }

    private function FilterByState()
    {
        return [
            "query" => $this->state
        ];
    }

}