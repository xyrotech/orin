<?php

namespace Xyrotech\Orin\Traits;

use Psr\Http\Message\StreamInterface;

trait MarketplaceTrait
{
    public function inventory(string $username): StreamInterface
    {
        $uri = self::base_uri . '/users/' . $username . '/inventory';

        return $this->client->request('GET', $uri)->getBody();
    }

    public function listing(int $listing_id): StreamInterface
    {
        $uri = self::base_uri . '/marketplace/listings/' . $listing_id;

        return $this->client->request('GET', $uri)->getBody();
    }

    public function list(string $listing): StreamInterface
    {
        $uri = self::base_uri . '/marketplace/listings/';
        $this->parameters = ['query' => $listing];

        return $this->client->request('GET', $uri)->getBody();
    }

    public function order(int $order_id): StreamInterface
    {
        $uri = self::base_uri . '/marketplace/orders/' . $order_id;

        return $this->client->request('GET', $uri)->getBody();
    }

    public function list_orders(): StreamInterface
    {
        $uri = self::base_uri . '/marketplace/orders';

        return $this->client->request('GET', $uri)->getBody();
    }

    public function list_orders_messages(string $order_id): StreamInterface
    {
        $uri = self::base_uri . '/marketplace/orders/' . $order_id . '/messages';

        return $this->client->request('GET', $uri)->getBody();
    }

    /**
     *
     * Has to be in 'XX.yy' form where X and y are numeric values
     * API states price is optional, however when price is null endpoint can't be found
     * @param string $price
     * @return mixed
     */
    public function fee(string $price): StreamInterface
    {
        $uri = self::base_uri . '/marketplace/fee/' . $price;

        return $this->client->request('GET', $uri)->getBody();
    }

    /**
     *
     * API response value changes, however currency remains at USD
     * @param string $price
     * @param string $currency
     * @return StreamInterface
     */
    public function fee_with_currency(string $price, string $currency): StreamInterface
    {
        $uri = self::base_uri . '/marketplace/fee/' . $price . '/' . $currency;

        return $this->client->request('GET', $uri)->getBody();
    }

    public function price_suggestions(int $release_id): StreamInterface
    {
        $uri = self::base_uri . '/marketplace/price_suggestions/' . $release_id;

        return $this->client->request('GET', $uri)->getBody();
    }
}
