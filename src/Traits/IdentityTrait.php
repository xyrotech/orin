<?php

namespace Xyrotech\Orin\Traits;

trait IdentityTrait
{
    /**
     * Retrieve basic information about the authenticated user.
     *
     * @return object
     */
    public function identity() : object
    {
        return $this->response('GET', '/oauth/identity');
    }

    /**
     * Retrieve a user by username.
     *
     * @param string $username
     * @return object
     */
    public function profile(string $username) : object
    {
        return $this->response('GET', "/users/$username");
    }

    /**
     * Edit a user’s profile data.
     *
     * @param string $username
     * @param array $parameters
     * @return object
     */
    public function edit_profile(string $username, array $parameters = null) : object
    {
        $this->parameters = ['json' => $parameters];

        return $this->response('POST', "/users/$username");
    }

    /**
     * Retrieve a user’s submissions by username.
     *
     * @param string $username
     * @return object
     */
    public function user_submissions(string $username) : object
    {
        return $this->response('GET', "/users/$username/submissions");
    }

    /**
     * The Contributions resource represents releases, labels, and artists submitted by a user.
     *
     * @param string $username
     * @param string|null $sort
     * @param string|null $sort_order
     * @return object
     */
    public function user_contributions(string $username, string $sort = null, string $sort_order = null) : object
    {
        $this->parameters = ['query' => ['sort' => $sort, 'sort_order' => $sort_order]];

        return $this->response('GET', "/users/$username/contributions");
    }
}
