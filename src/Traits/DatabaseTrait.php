<?php

namespace Xyrotech\Orin\Traits;

use Psr\Http\Message\StreamInterface;

trait DatabaseTrait
{
    public function release(int $release_id) : StreamInterface
    {
        $uri = self::base_uri . '/releases/' . $release_id;

        return $this->client->request('GET', $uri)->getBody();
    }

    public function release_rating_by_user(int $release_id, string $username): StreamInterface
    {
        $uri = self::base_uri . '/releases/' . $release_id . '/rating/' . $username;

        return $this->client->request('GET', $uri)->getBody();
    }

    public function community_release_rating(int $release_id): StreamInterface
    {
        $uri = self::base_uri . '/releases/' . $release_id . '/rating';

        return $this->client->request('GET', $uri)->getBody();
    }

    public function master_releases(int $master_id): StreamInterface
    {
        $uri = self::base_uri . '/masters/' . $master_id . '/versions';

        return $this->client->request('GET', $uri)->getBody();
    }

    public function master_release_versions(int $master_id): StreamInterface
    {
        $uri = self::base_uri . '/masters/' . $master_id . '/versions';

        return $this->client->request('GET', $uri)->getBody();
    }

    public function artist(int $artist_id): StreamInterface
    {
        $uri = self::base_uri . '/artists/' . $artist_id;

        return $this->client->request('GET', $uri)->getBody();
    }

    public function artist_releases(int $artist_id): StreamInterface
    {
        $uri = self::base_uri . '/artists/' . $artist_id . '/releases';

        return $this->client->request('GET', $uri)->getBody();
    }

    public function label(int $label_id): StreamInterface
    {
        $uri = self::base_uri . '/label/' . $label_id;

        return $this->client->request('GET', $uri)->getBody();
    }

    public function all_label_releases(int $label_id): StreamInterface
    {
        $uri = self::base_uri . '/labels/' . $label_id . '/releases';

        return $this->client->request('GET', $uri)->getBody();
    }

    public function search(string $query): StreamInterface
    {
        $uri = self::base_uri . '/database/search';

        $this->parameters = ['query' => ['q' => $query]];

        return $this->client->request('GET', $uri)->getBody();
    }
}
