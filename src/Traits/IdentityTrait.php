<?php

namespace Xyrotech\Orin\Traits;

trait IdentityTrait
{
    public function identity(): IdentityTrait
    {
        $this->uri = $this->base_uri . '/oauth/identity';

        return $this;
    }

    public function profile(string $username): IdentityTrait
    {
        $this->uri = $this->base_uri . '/users/' . $username;

        return $this;
    }

    public function user_submissions(string $username): IdentityTrait
    {
        $this->uri = $this->base_uri . '/users/' . $username . '/submissions';

        return $this;
    }

    public function user_contributions(string $username): IdentityTrait
    {
        $this->uri = $this->base_uri . '/users/' . $username . '/contributions';

        return $this;
    }
}
