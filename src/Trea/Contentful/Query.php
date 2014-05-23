<?php namespace Trea\Contentful;

class Query
{

    /**
     * Stores the Guzzle client instance
     * @var GuzzleHttp\Client
     */
    protected $client;
    
    /**
     * Space to query
     * @var string
     */
    protected $space;
    
    /**
     * Content type to query
     * @var string
     */
    protected $type;

    /**
     * Array of fields to query upon
     * @var array
     */
    protected $fields;

    public function __construct(\GuzzleHttp\Client $client, $space = null, $type = null)
    {
        $this->client = $client;
        $this->space = $space;
        $this->type = $type;
    }

    /**
     * Get entries of a particular type
     * @param  string $type Type of content entries
     * @return self
     */
    public function ofType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Chainable field queries
     * @param  string $field    Field Name
     * @param  string $operator '=', '!='
     * @param  string $value    What the field value should (or should not) be
     * @return self
     */
    public function where($field, $operator, $value)
    {
        $this->fields[$this->transformWhere($field, $operator)] = $value;
        return $this;
    }

    /**
     * Transform the operator to an API compatible query value
     * @param  string $operator Operator used in field query
     * @param  string $value    Value of the field query
     * @return string
     */
    private function transformWhere($key, $operator)
    {
        return ($operator == '!=') ? $key . '[ne]' : $key;
    }

    private function buildQuery()
    {
        if ($this->type) {
            $this->fields['content_type'] = $this->type;
        }

        return (count($this->fields) > 0) ? $this->fields : [];
    }

    private function buildUrl()
    {
        return '/spaces/' . $this->space . '/entries';
    }

    public function get()
    {
        // dd($this->buildQuery());
        if ($this->buildQuery() == null) {
            return $this->client->get($this->buildUrl())->json();
        }
        return $this->client->get($this->buildUrl(), ['query' => $this->buildQuery()])->json();
    }
}
