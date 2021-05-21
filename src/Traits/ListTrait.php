<?php

namespace Xyrotech\Orin\Traits;

trait ListTrait
{
    public function user_lists(string $username) : array
    {
        return $this->response('GET', "/users/{$username}/lists");
    }

    public function list(string $list_id) : array
    {
        return $this->response('GET', "/lists/{$list_id}");
    }
}
