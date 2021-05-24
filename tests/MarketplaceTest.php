<?php


namespace Xyrotech\Orin\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin\Orin;

class MarketplaceTest extends TestCase
{
    private Orin  $discog;

    public function setUp() : void
    {
        sleep(2);

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
    }
}
