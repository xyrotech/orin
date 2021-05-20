<?php


namespace Xyrotech\Orin\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin\Orin;

class OrinTest extends TestCase
{

    /** @test */
    public function base_uri_is_correct()
    {
        $config = include('configs/config.test.noauth.php');

        $discog = new Orin($config);

        $this->assertEquals('https://api.discogs.com', $discog->client->getConfig('base_uri'));
    }

    /** @test */
    public function verify_client_using_no_auth()
    {
        $config = include('configs/config.test.noauth.php');

        $discog = new Orin($config);

        $this->assertEquals($discog->limit, 25);
        $this->assertEquals(25, $discog->getRates()['limit']);
    }

    /** @test */
    public function verify_client_using_token_auth()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $this->assertEquals($discog->limit, 60);
        $this->assertEquals(60, $discog->getRates()['limit']);
    }

    /** @test */
    public function verify_client_using_key_secret_auth()
    {
        $config = include('configs/config.test.half.php');

        $discog = new Orin($config);

        $this->assertEquals($discog->limit, 60);
    }

    /** @test */
    public function verify_database_release_trait()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->release(192988);

        $this->assertJson($json);
    }

    /** @test */
    public function verify_rates()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $this->assertIsArray($discog->getRates());
    }

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
    public function verify_add_to_collection_folder()
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
