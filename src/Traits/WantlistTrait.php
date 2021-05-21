<?php

namespace Xyrotech\Orin\Traits;

trait WantlistTrait
{
    public function wantlist(string $username) : array
    {
        return $this->response('GET', "/users/{$username}/wants");
    }

    public function add_to_wantlist(string $username, int $release_id, string $notes = null, int $rating = null) : array
    {
        $this->parameters = ['json' => ['notes' => $notes, 'rating' => $rating]];

        return $this->response('PUT', "/users/{$username}/wants/{$release_id}");
    }

    public function delete_from_wantlist(string $username, int $release_id, string $notes = null, int $rating = null)
    {
        $this->parameters = ['json' => ['notes' => $notes, 'rating' => $rating]];

        return $this->response('DELETE', "/users/{$username}/wants/{$release_id}");
    }
}
