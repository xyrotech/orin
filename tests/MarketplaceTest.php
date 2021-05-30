<?php


namespace Xyrotech\Orin\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin\Orin;

class MarketplaceTest extends TestCase
{
    private Orin  $discog;

    public function setUp() : void
    {
        $config = include('configs/config.test.php');

        $this->discog = new Orin($config);
    }

    /** @test */
    public function verify_inventory()
    {
        $inventory = $this->discog->inventory('kunli0', ['sort' => 'artist']);

        $this->assertJson($inventory['response']);
        $this->assertEquals('200', $inventory['status']);
    }

    /** @test */
    public function verify_new_edit_delete_listing()
    {
        $parameters = [
            'release_id' => 16457562,
            'condition' => 'Fair (F)',
            'price' => 99.00,

        ];

        // Create Listing

        $new_listing = $this->discog->new_listing($parameters);

        $this->assertJson($new_listing['response']);
        $this->assertEquals('201', $new_listing['status']);

        $listing = json_decode($new_listing['response']);

        $parameters = [
            'release_id' => 16457562,
            'condition' => 'Poor (P)',
            'price' => 99.00,
            'status' => 'For Sale',
        ];

        // View listing

        $view_listing = $this->discog->listing($listing->listing_id);

        $this->assertJson($view_listing['response']);
        $this->assertEquals('200', $view_listing['status']);

        // Edit Listing
        $edit_listing = $this->discog->edit_listing($listing->listing_id, $parameters);

        $this->assertEquals('204', $edit_listing['status']);

        // Delete Listing
        $delete_listing = $this->discog->delete_listing($listing->listing_id);

        $this->assertEquals('204', $delete_listing['status']);
    }

    /** @test
     * @param $parameters
     */
    public function verify_list_orders()
    {
        $list = $this->discog->list_orders();

        $this->assertJson($list['response']);
        $this->assertEquals('200', $list['status']);

        $response = json_decode($list['response']);

        $get_order = $this->discog->order($response->orders[0]->id);

        $this->assertJson($get_order['response']);
        $this->assertEquals('200', $get_order['status']);

        $status = json_decode($get_order['response'])->status == "Payment Pending" ? "Invoice Sent" : "Payment Pending";

        $edit_order = $this->discog->edit_order($response->orders[0]->id, ['status' => $status]);

        $this->assertJson($edit_order['response']);
        $this->assertEquals('200', $edit_order['status']);

        $list_order_messages = $this->discog->list_orders_messages($response->orders[0]->id);

        $this->assertJson($list_order_messages['response']);
        $this->assertEquals('200', $list_order_messages['status']);

        $new_order_message = $this->discog->new_orders_message($response->orders[0]->id, 'Testing', $status);

        $this->assertJson($new_order_message['response']);
        $this->assertEquals('201', $new_order_message['status']);
    }

    /** @test */
    public function verify_fee()
    {
        $fee = $this->discog->fee("10.00");

        $this->assertJson($fee['response']);
        $this->assertEquals('200', $fee['status']);
    }

    /** @test */
    public function verify_fee_with_currency()
    {
        $fee = $this->discog->fee_with_currency("10.00", "CAD");

        $this->assertJson($fee['response']);
        $this->assertEquals('200', $fee['status']);
    }

    /** @test */
    public function verify_price_suggestions()
    {
        $price_suggestions = $this->discog->price_suggestions(16457562);

        $this->assertJson($price_suggestions['response']);
        $this->assertEquals('200', $price_suggestions['status']);
    }


    /** @test */
    public function verify_release_statistics()
    {
        $release_stats = $this->discog->release_statistics(16457562);

        $this->assertJson($release_stats['response']);
        $this->assertEquals('200', $release_stats['status']);
    }
}
