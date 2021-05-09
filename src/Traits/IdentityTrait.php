<?php

Trait IdentityTrait
{
    public function identity()
    {
        $this->uri = $this->base_uri . '/oauth/identity';
        return $this;
    }

    public function profile(string $username)
    {
        $this->uri = $this->base_uri . '/users/' . $username;
        return $this;
    }

    public function user_submissions(string $username)
    {
        $this->uri = $this->base_uri . '/users/' . $username . '/submissions';
        return $this;
    }

    public function user_contributions(string $username)
    {
        $this->uri = $this->base_uri . '/users/' . $username . '/contributions';
        return $this;
    }
}