<?php

trait ListTrait
{
    public function user_lists(string $username)
    {
        $this->uri = $this->base_uri = '/users/' . $username . '/lists';
        return $this;
    }

    public function lists(string $list_id)
    {
        $this->uri = $this->base_uri = '/lists/' . $list_id;
        return $this;
    }
}