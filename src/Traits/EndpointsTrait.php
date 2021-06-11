<?php

namespace Xyrotech\Orin\Traits;

use stdClass;

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

    private function response(string $type, string $uri) : object
    {
        $response = $this->client->request($type, self::base_uri . $uri, $this->parameters);

        $data = json_decode((string) $response->getBody()) ?? new stdClass();
        $data->status_code = $response->getStatusCode();
        $data->rates = $this->setRates($response->getHeaders());

        return $data;
    }
}
