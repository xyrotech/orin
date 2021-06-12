<?php

namespace Xyrotech\Orin\Traits;

trait ListTrait
{
    /**
     * The List resource allows you to view a User’s Lists.
     *
     * @param string $username
     * @return object
     */
    public function user_lists(string $username) : object
    {
        return $this->response('GET', "/users/$username/lists");
    }

    /**
     * Returns items from a specified List.
     *
     * @param string $list_id
     * @return object
     */
    public function list(string $list_id) : object
    {
        return $this->response('GET', "/lists/$list_id");
    }
}
