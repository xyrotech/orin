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
    public function verify_collection()
    {
        $config = include('configs/config.test.noauth.php');

        $discog = new Orin($config);

        $json = $discog->collection('kunli0');

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
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
}
