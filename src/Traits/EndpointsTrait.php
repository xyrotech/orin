<?php

namespace Xyrotech\Traits;

use stdClass;

require 'CollectionTrait.php';
require 'DatabaseTrait.php';
require 'IdentityTrait.php';
require 'ListTrait.php';
require 'MarketplaceTrait.php';
require 'WantlistTrait.php';
require 'AuthenticationTrait.php';

trait EndpointsTrait
{
    protected array $parameters = [];

    use DatabaseTrait;
    use IdentityTrait;
    use MarketplaceTrait;
    use CollectionTrait;
    use ListTrait;
    use WantlistTrait;
    use AuthenticationTrait;


    /**
     * The results of the request to Discogs API
     *
     * @param string $type
     * @param string $uri
     * @return object
     */
    private function response(string $type, string $uri) : object
    {
        $response = $this->client->request($type, self::base_uri . $uri, $this->parameters);

        if (! isset($this->parameters['headers'])) {
            $data = json_decode((string) $response->getBody()) ?? new stdClass();
        } else {
            $oauth = explode('&', (string) $response->getBody());

            $data = new stdClass();

            foreach ($oauth as $item) {
                $parts = explode('=', $item);

                $key = $parts[0];

                $data->$key = $parts[1];
            }
        }


        $data->status_code = $response->getStatusCode();
        $data->rates = $this->setRates($response->getHeaders());

        return $data;
    }
}
