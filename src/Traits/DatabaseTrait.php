<?php

namespace Xyrotech\Orin\Traits;

trait DatabaseTrait
{
    public function release(int $release_id, string $curr_abbr = null) : array
    {
        $this->parameters = ['json' => ['curr_abbr' => $curr_abbr]];

        return $this->response('GET', "/releases/{$release_id}");
    }

    public function release_rating_by_user(int $release_id, string $username): array
    {
        return $this->response('GET', "/releases/{$release_id}/rating/{$username}");
    }

    public function update_release_rating_by_user(int $release_id, string $username, int $rating = null): array
    {
        $this->parameters = ['json' => ['rating' => $rating]];

        return $this->response('PUT', "/releases/{$release_id}/rating/{$username}");
    }

    public function delete_release_rating_by_user(int $release_id, string $username): array
    {
        return $this->response('DELETE', "/releases/{$release_id}/rating/{$username}");
    }

    public function community_release_rating(int $release_id): array
    {
        return $this->response('GET',  "/releases/{$release_id}/rating");
    }

    public function release_stats(int $release_id): array
    {
        return $this->response('GET',  "/releases/{$release_id}/stats");
    }

    public function master_releases(int $master_id): array
    {
        return $this->response('GET', "/masters/{$master_id}/versions");
    }

    public function master_release_versions(int $master_id, array $parameters = null): array
    {
        $this->parameters = ['q' => $parameters ];

        return $this->response('GET', "/masters/{$master_id}/versions");
    }

    public function artist(int $artist_id): array
    {
        return $this->response('GET', "/artists/{$artist_id}");
    }

    public function artist_releases(int $artist_id, array $parameters): array
    {
        $this->parameters = ['q' => $parameters];

        return $this->response('GET', "/artists/{$artist_id}/releases");
    }

    public function label(int $label_id): array
    {
        return $this->response('GET', "/labels/{$label_id}");
    }

    public function all_label_releases(int $label_id, array $parameters = null): array
    {
        $this->parameters = ['q' => $parameters];

        return $this->response('GET', "/labels/{$label_id}/releases");
    }

    public function search(string $query, array $parameters = null): array
    {
        $this->parameters = ['q' => $parameters];

        return $this->response('GET', "/database/search");
    }
}
