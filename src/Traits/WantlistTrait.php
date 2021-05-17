<?php

namespace Xyrotech\Orin\Traits;

use Psr\Http\Message\StreamInterface;

trait WantlistTrait
{
    public function wantlist(string $username): StreamInterface
    {
        $uri = self::base_uri . '/users/' . $username . '/wants';

        return $this->client->request('GET', $uri)->getBody();
    }

    public function add_to_wantlist(string $username, int $release_id): StreamInterface
    {
        $uri = self::base_uri . '/users/' . $username . '/wants/' . $release_id;

        return $this->client->request('GET', $uri)->getBody();
    }
}
