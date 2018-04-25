<?php namespace App\Search;

use App\Search\Highlight\Highlight;
use Elasticsearch\Client;


abstract class Search
{
    /** @var Client */
    private $client;
    /** @var SearchInterface */
    private $filterQuery;

    /** @var Highlight */
    private $highlighter;

    private $from;

    private $size;

    protected abstract function getIndex();

    protected abstract function getType();

    /**
     * Search constructor.
     * @param Client $client
     * @param SearchInterface $filterQuery
     * @param $from
     * @param $size
     */
    public function __construct(Client $client, SearchInterface $filterQuery)
    {
        $this->client      = $client;
        $this->filterQuery = $filterQuery;
    }

    public function setHighlighter(Highlight $highlighter)
    {
        $this->highlighter = $highlighter;
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getQuery()
    {
        $params = [
            'index' => $this->getIndex(),
            'type'  => $this->getType(),
            'body'  => [
                'query' => $this->filterQuery->getFilter(),
            ],
            'from' => $this->getFrom(),
            'size' => $this->getSize(),
        ];
        if (isset($this->highlighter)) {
            $params['body'] = array_merge($params['body'], $this->highlighter->highlight());
        }

        return $params;
    }

    public function search()
    {
        $query = $this->getQuery();
        return $this->client->search($query);
    }
}