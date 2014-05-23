<?php namespace Trea\Contentful;

use GuzzleHttp\Client;

class Contentful
{

    /**
     * Version of this API wrapper
     */
    const VERSION = "0.1";

    /**
     * Stores the BASE URL of the Contentful API
     * (Not likely to be different than default, but possbile
     * on enterprise plans)
     * @var string
     */
    protected $base;

    /**
     * Default Space Key to Query (overridable)
     * @var string
     */
    protected $space;

    /**
     * Contentful API key
     * @var string
     */
    protected $key;

    /**
     * Instance of a caching mechanism (which for now is tied
     * to Laravel's caching, but I plan to use PSR caching
     * and add adapters, or find another good method of
     * multi-platform caching)
     * @var Illuminate\Cache\CacheManager
     */
    protected $cache;

    /**
     * Stores the Guzzle client instance
     * @var GuzzleHttp\Client
     */
    protected $client;


    public function __construct($base, $space, $key, $cache)
    {
        $this->base = $base;
        $this->space = $space;
        $this->key = $key;
        $this->cache = $cache;

        $this->client = new Client([
            'base_url' => $this->base,
            'defaults' => [
                'headers' => [
                    'User-Agent' => "PHP Trea\Contentful v" . self::VERSION
                ],
                'query' => [
                    'access_token' => $this->key
                ]
            ]

        ]);
    }

    /**
     * Get entries of a given type
     * @param  string $type Content entry type (optional)
     * @return Trea\Contentful\Query
     */
    public function entries($type = null, $space = null)
    {
        if ($space == null) {
            $space = $this->space;
        }

        return new Query($this->client, $space, $type);
    }
}
