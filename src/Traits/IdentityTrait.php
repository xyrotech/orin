<?php

namespace Xyrotech\Orin\Traits;

trait IdentityTrait
{
    public function identity(): object
    {
        return $this->response('GET', '/oauth/identity');
    }

    public function profile(string $username) : object
    {
        return $this->response('GET', "/users/{$username}");
    }

    public function edit_profile(string $username, array $parameters) : object
    {
        $this->parameters = ['json' => $parameters];

        return $this->response('POST', "/users/{$username}");
    }

    public function user_submissions(string $username) : object
    {
        return $this->response('GET', "/users/{$username}/submissions");
    }

    public function user_contributions(string $username, string $sort = null, string $sort_order = null) : object
    {
        $this->parameters = ['query' => ['sort' => $sort, 'sort_order' => $sort_order]];

        return $this->response('GET', "/users/{$username}/contributions");
    }
}
