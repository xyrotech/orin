<?php

namespace Xyrotech\Orin\Traits;

trait MarketplaceTrait
{
    public function inventory(string $username, object $parameters = null): object
    {
        $this->parameters = ['q' => $parameters ];

        return $this->response('GET', "/users/{$username}/inventory");
    }

    public function listing(int $listing_id, string $curr_abbr = null): object
    {
        $this->parameters = ['q' => ['curr_abbr' => $curr_abbr] ];

        return $this->response('GET', "/marketplace/listings/{$listing_id}");
    }

    public function edit_listing(int $listing_id, object $parameters = null): object
    {
        $this->parameters = ['json' => $parameters];

        return $this->response('POST', "/marketplace/listings/{$listing_id}");
    }

    public function new_listing(object $parameters): object
    {
        $this->parameters = ['json' => $parameters];

        return $this->response('POST', "/marketplace/listings");
    }

    public function delete_listing(int $listing_id): object
    {
        return $this->response('DELETE', "/marketplace/listings/{$listing_id}");
    }

    public function order(string $order_id): object
    {
        return $this->response('GET', "/marketplace/orders/{$order_id}");
    }

    public function edit_order(string $order_id, object $parameters = null): object
    {
        $this->parameters = ['json' => $parameters];

        return $this->response('POST', "/marketplace/orders/{$order_id}");
    }

    public function list_orders(object $parameters = null): object
    {
        $this->parameters = ['q' => $parameters ];

        return $this->response('GET', '/marketplace/orders');
    }

    public function list_orders_messages(string $order_id): object
    {
        return $this->response('GET', "/marketplace/orders/{$order_id}/messages");
    }

    public function new_orders_message(string $order_id, string $message = null, string $status = null): object
    {
        $this->parameters = ['json' => ['message' => $message, 'status' => $status]];

        return $this->response('POST', "/marketplace/orders/{$order_id}/messages");
    }

    /**
     *
     * Has to be in 'XX.yy' form where X and y are numeric values
     * API states price is optional, however when price is null endpoint can't be found
     * @param string $price
     * @return mixed
     */
    public function fee(string $price): object
    {
        return $this->response('GET', "/marketplace/fee/{$price}");
    }

    /**
     *
     * API response value changes, however currency remains at USD
     * @param string $price
     * @param string $currency
     * @return object
     */
    public function fee_with_currency(string $price, string $currency): object
    {
        return $this->response('GET', "/marketplace/fee/{$price}/{$currency}");
    }

    public function price_suggestions(int $release_id): object
    {
        return $this->response('GET', "/marketplace/price_suggestions/{$release_id}");
    }

    public function release_statistics(int $release_id, string $curr_abbr = null): object
    {
        $this->parameters = ['q' => ['curr_abbr' => $curr_abbr] ];

        return $this->response('GET', "/marketplace/stats/{$release_id}");
    }
}
