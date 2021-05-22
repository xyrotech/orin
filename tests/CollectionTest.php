<?php


namespace Xyrotech\Orin\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin\Orin;

class CollectionTest extends TestCase
{
    private Orin $discog;

    public function setUp() : void
    {
        sleep(5);

        $config = include('configs/config.test.php');

        $this->discog = new Orin($config);
    }

    /** @test */
    public function verify_new_meta_delete_collection_folder()
    {
        // Creating "new" folder
        $new = $this->discog->new_collection_folder('kunli0', 'new');

        $this->assertJson($new['response']);
        $this->assertEquals('201', $new['status']);

        $folder = json_decode($new['response']);

        // Renaming "new" folder
        $rename = $this->discog->collection_folder_meta('kunli0', $folder->id, 'Rename' . time());

        $this->assertJson($rename['response']);
        $this->assertEquals('200', $rename['status']);

        // Deleting "new" folder
        $delete = $this->discog->collection_folder_delete('kunli0', $folder->id);

        $this->assertEquals('204', $delete['status']);
    }

    /** @test */
    public function verify_collection_folder()
    {
        $json = $this->discog->collection_folder('kunli0', 1);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_collection_items_by_release()
    {
        $json = $this->discog->collection_items_by_release('kunli0', 16457562);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_collection_items_by_folder()
    {
        $json = $this->discog->collection_items_by_folder('kunli0', 0);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_add_rating_edit_delete_on_collection_folder()
    {
        $release_id = 2097562;

        $json = $this->discog->add_to_collection_folder('kunli0', 1, $release_id);

        $this->assertJson($json['response']);
        $this->assertEquals('201', $json['status']);

        $instance = json_decode($json['response']);

        //Change rating of release

        $rating = $this->discog->change_rating_of_release('kunli0', 1, $release_id, $instance->instance_id, 5);

        $this->assertEquals('204', $rating['status']);

        //Change release custom fields

        $edit = $this->discog->edit_fields_instance('kunli0', 'Testing', 1, $release_id, $instance->instance_id, 3);

        $this->assertEquals('204', $edit['status']);


        //Delete release

        $delete = $this->discog->delete_instance_from_folder('kunli0', 1, $release_id, $instance->instance_id);

        $this->assertEquals('204', $delete['status']);
    }

    /** @test */
    public function verify_list_custom_fields()
    {
        $json = $this->discog->list_custom_fields('kunli0');

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_collection_value()
    {
        $json = $this->discog->collection_value('kunli0');

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }
}
