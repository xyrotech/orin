<?php

namespace Xyrotech\Orin\Traits;

trait WantlistTrait
{
    /**
     * The Wantlist resource allows you to view and manage a user’s wantlist.
     *
     * @param string $username
     * @return object
     */
    public function wantlist(string $username) : object
    {
        return $this->response('GET', "/users/$username/wants");
    }

    /**
     * Add a release to a user’s wantlist.
     *
     * @param string $username
     * @param int $release_id
     * @param string|null $notes
     * @param int|null $rating
     * @return object
     */
    public function add_to_wantlist(string $username, int $release_id, string $notes = null, int $rating = null) : object
    {
        $this->parameters = ['json' => ['notes' => $notes, 'rating' => $rating]];

        return $this->response('PUT', "/users/$username/wants/$release_id");
    }

    /**
     * Delete a release from a user’s wantlist.
     *
     * @param string $username
     * @param int $release_id
     * @param string|null $notes
     * @param int|null $rating
     * @return object
     */
    public function delete_from_wantlist(string $username, int $release_id, string $notes = null, int $rating = null) : object
    {
        $this->parameters = ['json' => ['notes' => $notes, 'rating' => $rating]];

        return $this->response('DELETE', "/users/$username/wants/$release_id");
    }
}
