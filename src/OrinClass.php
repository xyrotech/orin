<?php
/**
 * Created by PhpStorm.
 * User: kadelakun
 * Date: 9/18/2018
 * Time: 1:53 PM
 */
namespace Xyrotech\Orin;

use EndpointsTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\InvalidArgumentException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiterMiddleware;

require 'Traits/EndpointsTrait.php';

class OrinClass
{
    use EndpointsTrait;

    private const USER_AGENT = "Orin/0.1 +http://orin.xyrotech.com";
    private const NON_AUTH = 25;
    private const AUTH = 60;

    // Discog API Variables
    private $token;
    private $consumer_key;
    private $consumer_secret;
    private $version;
    private $media_type;

    // Guzzle Variables
    private $client;
    private $stack;
    private $headers;


    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new OrinClass();
        }

        return self::$instance;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    /**
     * Creates CURL client and attaches necessary headers
     */
    private function __construct()
    {
        $this->setEnv();
        $this->setMiddleware();
        $this->setHeaders();

        try {
            $this->client = new Client([
                'base_uri' => $this->uri,
                'headers' => $this->headers,
                'handler' => $this->stack,
            ]);
        } catch (InvalidArgumentException $e) {
            return $e->getMessage();
        }
    }

    /**
     *  Setup Environment Variables
     */
    private function setEnv()
    {
        $config = include('config.test.php');

        $this->token = $config['DISCOGS_TOKEN'];
        $this->consumer_key = $config['DISCOGS_CONSUMER_KEY'];
        $this->consumer_secret = $config['DISCOGS_CONSUMER_SECRET'];
        $this->version = $config['DISCOGS_VERSION'];
        $this->media_type = $config['DISCOGS_MEDIA_TYPE'];
    }

    /**
     *  Setup Throttle Middleware
     */
    private function setMiddleware()
    {
        // @throws Exp
//        $rules = new RequestLimitRuleset([
//            $this->base_uri => [[
//                    'max_requests' => $this->usingAuth() ? self::AUTH : self::NON_AUTH,
//                    'request_interval' => 60
//            ]]
//        ]);
//
//        $this->stack = new HandlerStack();
//        $this->stack->setHandler(new CurlHandler());
//
//        $throttle = new ThrottleMiddleware($rules);
//
//        // Invoke the middleware
//        $this->stack->push($throttle());

        $this->stack = HandlerStack::create();
        $this->stack->push(RateLimiterMiddleware::perMinute(60));
    }

    /**
     * Determines if Authentication will be used during the request
     * @return bool
     */
    private function usingAuth()
    {
        return isset($this->token) || (isset($this->consumer_key) && isset($this->consumer_secret));
    }

    /**
     * Returns authorization headers based Token or Consumer Key/Secret
     *
     * @return null|string
     */
    private function getAuthHeader()
    {
        $authorization = isset($this->token)
            ? "Discogs token=" . $this->token
            : "Discogs key=" . $this->consumer_key . ", secret=" . $this->consumer_secret;

        return $this->usingAuth() ? $authorization : null;
    }

    /**
     * Attaches optional parameters on endpoint request
     *
     * @param array $parameters
     * @return $this
     * @internal param array $options
     */
    public function parameters(array $parameters)
    {
        if (! isset($this->parameters['query'])) {
            $this->parameters['query'] = [];
        }

        $this->parameters['query'] += $parameters;

        return $this;
    }

    /**
     * Gets Accept header for DISCOGS API future proofing
     * @return string
     */
    private function getAcceptHeader()
    {
        $accept = (isset($this->version) && isset($this->media_type))
            ? 'application/vnd.discogs.' . $this->version . '.' . $this->media_type . '+json'
            : 'application/vnd.discogs.v2.discogs+json';

        return $accept;
    }

    /**
     * Sets headers for HTTP request
     */
    private function setHeaders()
    {
        $this->headers = [
            'User-Agent' => self::USER_AGENT,
            'Authorization' => $this->getAuthHeader(),
            'Accept' => $this->getAcceptHeader(),
        ];
    }


    /**
     * Sends GET HTTP request to endpoint
     * @return string
     */
    public function get()
    {
        $request = new Request('GET', $this->uri);

        try {
            $response = $this->client->send($request, $this->parameters);
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            return $e->getMessage();
        }

        return json_decode($response->getBody());
    }

    /**
     * Return first results set from search query
     * @return string
     */
    public function first()
    {
        $contents = $this->get();

        if (isset($contents->results[0])) {
            // Sets URI to first results resource url which is either of the following: label, artist, release, master
            $this->uri = $contents->results[0]->resource_url;

            // Get data for first result
            return $this->get();
        } else {
            return null;
        }
    }

    /**
     * Sends PUT HTTP request to endpoint
     * @return ResponseInterface
     */
    public function put(array $parameters)
    {
        $request = new Request('PUT', $this->uri);

        try {
            $response = $this->client->send($request, $parameters);
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            return $e->getMessage();
        }

        return $response;
    }

    /**
     * Sends POST HTTP request to endpoint
     * @return ResponseInterface|string
     */
    public function post(array $parameters)
    {
        $request = new Request('POST', $this->uri);

        try {
            $response = $this->client->send($request, $parameters);
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            return $e->getMessage();
        }

        return $response;
    }

    /**
     * Sends DELETE HTTP request to endpoint
     * @return ResponseInterface|string
     */
    public function delete()
    {
        $request = new Request('DELETE', $this->uri);

        try {
            $response = $this->client->send($request);
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            return $e->getMessage();
        }

        return $response;
    }
}
