<?php

trait WantlistTrait
{
    public function wantlist(string $username): WantlistTrait
    {
        $this->uri = $this->base_uri = '/users/' . $username . '/wants';

        return $this;
    }

    public function add_to_wantlist(string $username, int $release_id): WantlistTrait
    {
        $this->uri = $this->base_uri = '//users/' . $username . '/wants/' . $release_id;

        return $this;
    }
}
