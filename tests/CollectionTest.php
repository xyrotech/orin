<?php


namespace Xyrotech\Orin\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin\Orin;

class CollectionTest extends TestCase
{

    /** @test */
    public function verify_new_meta_delete_collection_folder()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        // Creating "new" folder
        $new = $discog->new_collection_folder('kunli0', 'new');

        $this->assertJson($new['response']);
        $this->assertEquals('201', $new['status']);

        $folder = json_decode($new['response']);

        // Renaming "new" folder
        $rename = $discog->collection_folder_meta('kunli0', $folder->id, 'Rename' . time());

        $this->assertJson($rename['response']);
        $this->assertEquals('200', $rename['status']);

        // Deleting "new" folder
        $delete = $discog->collection_folder_delete('kunli0', $folder->id);

        $this->assertEquals('204', $delete['status']);
    }

    /** @test */
    public function verify_collection_folder()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->collection_folder('kunli0', 1);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_collection_items_by_release()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->collection_items_by_release('kunli0', 16457562);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_collection_items_by_folder()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->collection_items_by_folder('kunli0', 0);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_add_rating_edit_delete_on_collection_folder()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $release_id = 2097562;

        $json = $discog->add_to_collection_folder('kunli0', 1, $release_id);

        $this->assertJson($json['response']);
        $this->assertEquals('201', $json['status']);

        $instance = json_decode($json['response']);

        //Change rating of release

        $rating = $discog->change_rating_of_release('kunli0', 1, $release_id, $instance->instance_id, 5);

        $this->assertEquals('204', $rating['status']);

        //Change release custom fields

        $edit = $discog->edit_fields_instance('kunli0', 'Testing', 1, $release_id, $instance->instance_id, 3);

        $this->assertEquals('204', $edit['status']);


        //Delete release

        $delete = $discog->delete_instance_from_folder('kunli0', 1, $release_id, $instance->instance_id);

        $this->assertEquals('204', $delete['status']);
    }

    /** @test */
    public function verify_list_custom_fields()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->list_custom_fields('kunli0');

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_collection_value()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->collection_value('kunli0');

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }
}
