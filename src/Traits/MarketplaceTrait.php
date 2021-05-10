<?php

trait MarketplaceTrait
{
    public function inventory(string $username)
    {
        $this->uri = $this->base_uri . '/users/' . $username . '/inventory';

        return $this;
    }

    public function listing(int $listing_id)
    {
        $this->uri = $this->base_uri . '/marketplace/listings/' . $listing_id;

        return $this;
    }

    public function list($listing)
    {
        $this->uri = $this->base_uri . '/marketplace/listings/';
        $this->parameters = ['query' => $listing];

        return $this;
    }

    public function order(int $order_id)
    {
        $this->uri = $this->base_uri . '/marketplace/orders/' . $order_id;

        return $this;
    }

    public function list_orders()
    {
        $this->uri = $this->base_uri . '/marketplace/orders';

        return $this;
    }

    public function list_orders_messages(string $order_id)
    {
        $this->uri = $this->base_uri . '/marketplace/orders/' . $order_id . '/messages';

        return $this;
    }

    /**
     *
     * Has to be in 'XX.yy' form where X and y are numeric values
     * API states price is optional, however when price is null endpoint can't be found
     * @param string $price
     * @return $this
     */
    public function fee(string $price)
    {
        $this->uri = $this->base_uri . '/marketplace/fee/' . $price;

        return $this;
    }

    /**
     *
     * API response value changes, however currency remains at USD
     * @param $price
     * @param string $currency
     * @return $this
     */
    public function fee_with_currency(string $price, string $currency)
    {
        $this->uri = $this->base_uri . '/marketplace/fee/' . $price . '/' . $currency;

        return $this;
    }

    public function price_suggestions(int $release_id)
    {
        $this->uri = $this->base_uri . '/marketplace/price_suggestions/' . $release_id;

        return $this;
    }
}
