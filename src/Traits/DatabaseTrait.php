<?php

namespace Xyrotech\Orin\Traits;

trait DatabaseTrait
{
    public function release(int $release_id) : string
    {
        $uri = self::base_uri . '/releases/' . $release_id;

        return $this->request('GET', $uri)->getBody();
    }

    public function release_rating_by_user(int $release_id, string $username): static
    {
        $this->uri = $this->base_uri . '/releases/' . $release_id . '/rating/' . $username;

        return $this;
    }

    public function community_release_rating(int $release_id): static
    {
        $this->uri = $this->base_uri . '/releases/' . $release_id . '/rating';

        return $this;
    }

    public function master_releases(int $master_id): static
    {
        $this->uri = $this->base_uri . '/masters/' . $master_id . '/versions';

        return $this;
    }

    public function master_release_versions(int $master_id): static
    {
        $this->uri = $this->base_uri . '/masters/' . $master_id . '/versions';

        return $this;
    }

    public function artist($artist_id): static
    {
        $this->uri = $this->base_uri . '/artists/' . $artist_id;

        return $this;
    }

    public function artist_releases(int $artist_id): static
    {
        $this->uri = $this->base_uri . '/artists/' . $artist_id . '/releases';

        return $this;
    }

    public function label(int $label_id): static
    {
        $this->uri = $this->base_uri . '/label/' . $label_id;

        return $this;
    }

    public function all_label_releases(int $label_id): static
    {
        $this->uri = $this->base_uri . '/labels/' . $label_id . '/releases';

        return $this;
    }

    public function search($query): static
    {
        $this->uri = $this->base_uri . '/database/search';

        $this->parameters = ['query' => ['q' => $query]];

        return $this;
    }
}
