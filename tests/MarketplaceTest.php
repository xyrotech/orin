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

        $this->assertEquals(1486528570, $inventory->listings[0]->id);
        $this->assertEquals('200', $inventory->status_code);
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

        $this->assertEquals('201', $new_listing->status_code);


        // View listing

        $view_listing = $this->discog->listing($new_listing->listing_id);

        $this->assertEquals("Fair (F)", $view_listing->condition);
        $this->assertEquals('200', $view_listing->status_code);

        // Edit Listing
        $parameters = [
            'release_id' => 16457562,
            'condition' => 'Poor (P)',
            'price' => 89.00,
            'status' => 'For Sale',
        ];

        $edit_listing = $this->discog->edit_listing($new_listing->listing_id, $parameters);

        $this->assertEquals('204', $edit_listing->status_code);

        // Delete Listing
        $delete_listing = $this->discog->delete_listing($new_listing->listing_id);

        $this->assertEquals('204', $delete_listing->status_code);
    }

    /** @test */
    public function verify_list_orders()
    {
        $list = $this->discog->list_orders();

        $this->assertEquals("2968486-1", $list->orders[0]->id);
        $this->assertEquals('200', $list->status_code);


        $get_order = $this->discog->order($list->orders[0]->id);

        $this->assertEquals(2968486, $get_order->seller->id);
        $this->assertEquals('200', $get_order->status_code);

        $new_status = ($get_order->status == "Payment Pending") ? "Invoice Sent" : "Payment Pending";

        $edit_order = $this->discog->edit_order($get_order->id, ['status' => $new_status]);

        $this->assertEquals('200', $edit_order->status_code);

        $list_order_messages = $this->discog->list_orders_messages($get_order->id);

        $this->assertEquals("status", $list_order_messages->messages[0]->type);
        $this->assertEquals('200', $list_order_messages->status_code);

        $new_order_message = $this->discog->new_orders_message($get_order->id, 'Testing', $get_order->status);

        $this->assertEquals('201', $new_order_message->status_code);
    }

    /** @test */
    public function verify_fee()
    {
        $fee = $this->discog->fee("10.00");

        $this->assertEquals(0.8, $fee->value);
        $this->assertEquals('200', $fee->status_code);
    }

    /** @test */
    public function verify_fee_with_currency()
    {
        $fee = $this->discog->fee_with_currency("10.00", "CAD");

        $this->assertEquals(0.66, $fee->value);
        $this->assertEquals('200', $fee->status_code);
    }

    /** @test */
    public function verify_price_suggestions()
    {
        $price_suggestions = $this->discog->price_suggestions(16457562);

        $this->assertEquals('200', $price_suggestions->status_code);
    }


    /** @test */
    public function verify_release_statistics()
    {
        $release_stats = $this->discog->release_statistics(16457562);

        $this->assertEquals('200', $release_stats->status_code);
    }
}
