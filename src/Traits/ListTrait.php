<?php

namespace Xyrotech\Orin\Traits;

use Psr\Http\Message\StreamInterface;

trait ListTrait
{
    public function user_lists(string $username): StreamInterface
    {
        $uri = self::base_uri . '/users/' . $username . '/lists';

        return $this->client->request('GET', $uri)->getBody();
    }

    public function lists(string $list_id): StreamInterface
    {
        $uri = self::base_uri . '/lists/' . $list_id;

        return $this->client->request('GET', $uri)->getBody();
    }
}
