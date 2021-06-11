<?php


namespace Xyrotech\Orin;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiterMiddleware;
use Xyrotech\Orin\Traits\EndpointsTrait;

require 'Traits/EndpointsTrait.php';

class Orin
{
    use EndpointsTrait;

    const AUTH = 60;
    const NON_AUTH = 25;

    public int $limit;
    public array $headers = [];
    private array $config;
    public array $rates = [];

    private HandlerStack $stack;
    private const base_uri = 'https://api.discogs.com';

    public Client $client;

    /**
     * Orin constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;

        $this->setHeaders();

        $this->stack = HandlerStack::create();
        $this->limit = $this->usingAuth() ? self::AUTH : self::NON_AUTH;
        $this->stack->push(RateLimiterMiddleware::perMinute($this->limit));

        $config['handler'] = $this->stack;
        $config['headers'] = $this->headers;
        $config['base_uri'] = self::base_uri;
        $config['Content-Type'] = 'application/json';

        $this->client = new Client($config);
    }

    /**
     * Determines if Authentication will be used during the request
     * @return bool
     */
    private function usingAuth(): bool
    {
        return $this->config['DISCOGS_TOKEN'] ?? null || ($this->config['DISCOGS_CONSUMER_KEY'] ?? null) && ($this->config['DISCOGS_CONSUMER_SECRET'] ?? null);
    }

    /**
     * Sets headers for HTTP request
     *
     * @return void
     */
    private function setHeaders(): void
    {
        if ($this->getAuthHeader() != null) {
            $this->headers['Authorization'] = $this->getAuthHeader();
        }

        if ($this->config['DISCOGS_USER_AGENT'] != null) {
            $this->headers['User-Agent'] = $this->config['DISCOGS_USER_AGENT'];
        }

        if ($this->getAcceptHeader() != null) {
            $this->headers['Accept'] = $this->getAcceptHeader();
        }
    }

    /**
     * Gets Accept header for DISCOGS API future proofing
     * @return string
     */
    private function getAcceptHeader(): string
    {
        $accept = ($this->config['DISCOGS_VERSION'] ?? null && $this->config['DISCOGS_MEDIA_TYPE'] != null)
            ? 'application/vnd.discogs.' . $this->config['DISCOGS_VERSION'] . '.' . $this->config['DISCOGS_MEDIA_TYPE'] . '+json'
            : 'application/vnd.discogs.v2.discogs+json';

        return $accept;
    }

    /**
     * Returns authorization headers based Token or Consumer Key/Secret
     *
     * @return null|string
     */
    private function getAuthHeader(): ?string
    {
        if (isset($this->config['DISCOGS_TOKEN']) && $this->config['DISCOGS_TOKEN'] != null) {
            return "Discogs token=" . $this->config['DISCOGS_TOKEN'];
        }

        if ((isset($this->config['DISCOGS_CONSUMER_KEY']) && $this->config['DISCOGS_CONSUMER_KEY'] != null) && (isset($this->config['DISCOGS_CONSUMER_SECRET']) && $this->config['DISCOGS_CONSUMER_SECRET'] != null)) {
            return "Discogs key=" . $this->config['DISCOGS_CONSUMER_KEY'] . ", secret=" . $this->config['DISCOGS_CONSUMER_SECRET'];
        }

        return null;
    }

    /**
     * After each request this function updates discog rates locally
     *
     * @param array $headers
     * @return array
     */
    public function setRates(array $headers): array
    {
        $this->rates['used'] = $headers['X-Discogs-Ratelimit-Used'][0];
        $this->rates['remaining'] = $headers['X-Discogs-Ratelimit-Remaining'][0];
        $this->rates['limit'] = $headers['X-Discogs-Ratelimit'][0];

        // The magic number 6 comes from +1 the greatest number of request per test which is 5.
        if ($this->rates['remaining'] <= 6) {
            sleep(60);
        }

        return $this->rates;
    }
}
