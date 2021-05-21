<?php

namespace Xyrotech\Orin\Traits;

trait IdentityTrait
{
    public function identity(): array
    {
        return $this->response('GET', '/oauth/identity');
    }

    public function profile(string $username) : array
    {
        return $this->response('GET', "/users/{$username}");
    }

    public function edit_profile(string $username, string $name = null, string $home_page = null, string $location = null, string $profile = null, string $curr_abbr = null) : array
    {
        $this->parameters = ['json' => ['name' => $name, 'home_page' => $home_page, 'location' => $location, 'profile' => $profile, 'curr_abbr' => $curr_abbr]];

        return $this->response('POST', "/users/{$username}");
    }

    public function user_submissions(string $username) : array
    {
        return $this->response('GET', "/users/{$username}/submissions");
    }

    public function user_contributions(string $username, string $sort = null, string $sort_order = null) : array
    {
        $this->parameters = ['query' => ['sort' => $sort, 'sort_order' => $sort_order]];

        return $this->response('GET', "/users/{$username}/contributions");
    }
}
