<?php

namespace Xyrotech\Orin\Traits;

require 'CollectionTrait.php';
require 'DatabaseTrait.php';
require 'IdentityTrait.php';
require 'ListTrait.php';
require 'MarketplaceTrait.php';
require 'WantlistTrait.php';

trait EndpointsTrait
{
    protected array $parameters = [];

    use DatabaseTrait;
    use IdentityTrait;
    use MarketplaceTrait;
    use CollectionTrait;
    use ListTrait;
    use WantlistTrait;

    private function response(string $type, string $uri) : array
    {
        $response = $this->client->request($type, self::base_uri . $uri, $this->parameters);

        return [
            'response' => $response->getBody(),
            'status' => $response->getStatusCode(),
            'rates' => $this->setRates($response->getHeaders()),
        ];
    }
}
