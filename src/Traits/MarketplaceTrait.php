<?php

namespace Xyrotech\Traits;

trait MarketplaceTrait
{
    /**
     * Get a seller’s inventory
     *
     * @param string $username
     * @param array|null $parameters
     * @return object
     */
    public function inventory(string $username, array $parameters = null) : object
    {
        $this->parameters = ['query' => $parameters ];

        return $this->response('GET', "/users/$username/inventory");
    }

    /**
     * View the data associated with a listing.
     *
     * @param int $listing_id
     * @param string|null $curr_abbr
     * @return object
     */
    public function listing(int $listing_id, string $curr_abbr = null) : object
    {
        $this->parameters = ['query' => ['curr_abbr' => $curr_abbr] ];

        return $this->response('GET', "/marketplace/listings/$listing_id");
    }

    /**
     * Edit the data associated with a listing.
     *
     * @param int $listing_id
     * @param array|null $parameters
     * @return object
     */
    public function edit_listing(int $listing_id, array $parameters = null) : object
    {
        $this->parameters = ['json' => $parameters];

        return $this->response('POST', "/marketplace/listings/$listing_id");
    }

    /**
     * Create a Marketplace listing.
     *
     * @param array $parameters
     * @return object
     */
    public function new_listing(array $parameters) : object
    {
        $this->parameters = ['json' => $parameters];

        return $this->response('POST', "/marketplace/listings");
    }

    /**
     * Permanently remove a listing from the Marketplace.
     *
     * @param int $listing_id
     * @return object
     */
    public function delete_listing(int $listing_id) : object
    {
        return $this->response('DELETE', "/marketplace/listings/$listing_id");
    }

    /**
     * View the data associated with an order.
     *
     * @param string $order_id
     * @return object
     */
    public function order(string $order_id) : object
    {
        return $this->response('GET', "/marketplace/orders/$order_id");
    }

    /**
     * Edit the data associated with an order.
     *
     * @param string $order_id
     * @param array|null $parameters
     * @return object
     */
    public function edit_order(string $order_id, array $parameters = null) : object
    {
        $this->parameters = ['json' => $parameters];

        return $this->response('POST', "/marketplace/orders/$order_id");
    }

    /**
     * Returns a list of the authenticated user’s orders.
     *
     * @param array|null $parameters
     * @return object
     */
    public function list_orders(array $parameters = null) : object
    {
        $this->parameters = ['query' => $parameters ];

        return $this->response('GET', '/marketplace/orders');
    }

    /**
     * Returns a list of the order’s messages with the most recent first.
     *
     * @param string $order_id
     * @return object
     */
    public function list_orders_messages(string $order_id) : object
    {
        return $this->response('GET', "/marketplace/orders/$order_id/messages");
    }

    /**
     * Adds a new message to the order’s message log.
     *
     * @param string $order_id
     * @param string|null $message
     * @param string|null $status
     * @return object
     */
    public function new_order_message(string $order_id, string $message = null, string $status = null) : object
    {
        $this->parameters = ['json' => ['message' => $message, 'status' => $status]];

        return $this->response('POST', "/marketplace/orders/$order_id/messages");
    }

    /**
     * The Fee resource allows you to quickly calculate the fee for selling an item on the Marketplace.
     *
     * @param string $price
     * @return mixed
     */
    public function fee(string $price) : object
    {
        return $this->response('GET', "/marketplace/fee/$price");
    }

    /**
     * The Fee resource allows you to quickly calculate the fee for selling
     * an item on the Marketplace given a particular currency.
     *
     * @param string $price
     * @param string $currency
     * @return object
     */
    public function fee_with_currency(string $price, string $currency = null) : object
    {
        return $this->response('GET', "/marketplace/fee/$price/$currency");
    }

    /**
     * Retrieve price suggestions for the provided Release ID.
     *
     * @param int $release_id
     * @return object
     */
    public function price_suggestions(int $release_id) : object
    {
        return $this->response('GET', "/marketplace/price_suggestions/$release_id");
    }

    /**
     * Retrieve marketplace statistics for the provided Release ID.
     *
     * @param int $release_id
     * @param string|null $curr_abbr
     * @return object
     */
    public function release_statistics(int $release_id, string $curr_abbr = null) : object
    {
        $this->parameters = ['query' => ['curr_abbr' => $curr_abbr] ];

        return $this->response('GET', "/marketplace/stats/$release_id");
    }
}
