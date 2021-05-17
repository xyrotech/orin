<?php

namespace Xyrotech\Orin\Traits;

use Psr\Http\Message\StreamInterface;

trait IdentityTrait
{
    public function identity(): StreamInterface
    {
        $uri = self::base_uri . '/oauth/identity';

        return $this->client->request('GET', $uri)->getBody();
    }

    public function profile(string $username): StreamInterface
    {
        $uri = self::base_uri . '/users/' . $username;

        return $this->client->request('GET', $uri)->getBody();
    }

    public function user_submissions(string $username): StreamInterface
    {
        $uri = self::base_uri . '/users/' . $username . '/submissions';

        return $this->client->request('GET', $uri)->getBody();
    }

    public function user_contributions(string $username): StreamInterface
    {
        $uri = self::base_uri . '/users/' . $username . '/contributions';

        return $this->client->request('GET', $uri)->getBody();
    }
}
