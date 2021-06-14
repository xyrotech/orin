<?php

namespace Xyrotech\Orin\Traits;

trait DatabaseTrait
{
    /**
     * Get a release
     *
     * @param int $release_id
     * @param string|null $curr_abbr
     * @return object
     */
    public function release(int $release_id, string $curr_abbr = null) : object
    {
        $this->parameters = ['query' => ['curr_abbr' => $curr_abbr]];

        return $this->response('GET', "/releases/$release_id");
    }

    /**
     * Retrieves the release’s rating for a given user.
     *
     * @param int $release_id
     * @param string $username
     * @return object
     */
    public function release_rating_by_user(int $release_id, string $username) : object
    {
        return $this->response('GET', "/releases/$release_id/rating/$username");
    }

    /**
     * Updates the release’s rating for a given user.
     *
     * @param int $release_id
     * @param string $username
     * @param int $rating
     * @return object
     */
    public function update_release_rating_by_user(int $release_id, string $username, int $rating) : object
    {
        $this->parameters = ['json' => ['rating' => $rating]];

        return $this->response('PUT', "/releases/$release_id/rating/$username");
    }

    /**
     * Deletes the release’s rating for a given user.
     *
     * @param int $release_id
     * @param string $username
     * @return object
     */
    public function delete_release_rating_by_user(int $release_id, string $username) : object
    {
        return $this->response('DELETE', "/releases/$release_id/rating/$username");
    }

    /**
     * Retrieves the community release rating average and count.
     *
     * @param int $release_id
     * @return object
     */
    public function community_release_rating(int $release_id) : object
    {
        return $this->response('GET',  "/releases/$release_id/rating");
    }

    /**
     * Retrieves the release’s “have” and “want” counts.
     *
     * @param int $release_id
     * @return object
     */
    public function release_stats(int $release_id) : object
    {
        return $this->response('GET',  "/releases/$release_id/stats");
    }

    /**
     * The Master resource represents a set of similar Releases.
     *
     * @param int $master_id
     * @return object
     */
    public function master_release(int $master_id) : object
    {
        return $this->response('GET', "/masters/$master_id");
    }

    /**
     * Retrieves a list of all Releases that are versions of this master.
     *
     * @param int $master_id
     * @param array|null $parameters
     * @return object
     */
    public function master_release_versions(int $master_id, array $parameters = null) : object
    {
        $this->parameters = ['query' => $parameters ];

        return $this->response('GET', "/masters/$master_id/versions");
    }

    /**
     * Get an artist
     *
     * @param int $artist_id
     * @return object
     */
    public function artist(int $artist_id) : object
    {
        return $this->response('GET', "/artists/$artist_id");
    }

    /**
     * Get an artist’s releases
     *
     * @param int $artist_id
     * @param array|null $parameters
     * @return object
     */
    public function artist_releases(int $artist_id, array $parameters = null) : object
    {
        $this->parameters = ['query' => $parameters];

        return $this->response('GET', "/artists/$artist_id/releases");
    }

    /**
     * Get a label
     *
     * @param int $label_id
     * @return object
     */
    public function label(int $label_id) : object
    {
        return $this->response('GET', "/labels/$label_id");
    }

    /**
     * Returns a list of Releases associated with the label.
     *
     * @param int $label_id
     * @param array|null $parameters
     * @return object
     */
    public function all_label_releases(int $label_id, array $parameters = null) : object
    {
        $this->parameters = ['query' => $parameters];

        return $this->response('GET', "/labels/$label_id/releases");
    }

    /**
     * Issue a search query
     *
     * @param string $query
     * @param array|null $parameters
     * @return object
     */
    public function search(string $query, array $parameters = null) : object
    {
        $this->parameters = ['query' => ['q' => $query] + $parameters];

        return $this->response('GET', "/database/search");
    }
}
