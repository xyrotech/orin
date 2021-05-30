<?php


namespace Xyrotech\Orin\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin\Orin;

class OrinTest extends TestCase
{
    public function test_config()
    {
        $config = include('src/config.test.php');

        $this->assertArrayHasKey('DISCOGS_TOKEN', $config);
        $this->assertArrayHasKey('DISCOGS_CONSUMER_KEY', $config);
        $this->assertArrayHasKey('DISCOGS_CONSUMER_SECRET', $config);
        $this->assertArrayHasKey('DISCOGS_VERSION', $config);
        $this->assertArrayHasKey('DISCOGS_MEDIA_TYPE', $config);
        $this->assertArrayHasKey('DISCOGS_AUTH_TYPE', $config);
    }

    /** @test */
    public function base_uri_is_correct()
    {
        $config = include('configs/config.test.noauth.php');

        $discog = new Orin($config);

        $this->assertEquals('https://api.discogs.com', $discog->client->getConfig('base_uri'));
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
    public function verify_client_using_no_auth()
    {
        $config = include('configs/config.test.noauth.php');

        $discog = new Orin($config);

        $this->assertEquals($discog->limit, 25);
        $this->assertEquals(25, $discog->getRates()['limit']);
    }


    /** @test */
    public function verify_client_using_key_secret_auth()
    {
        $config = include('configs/config.test.half.php');

        $discog = new Orin($config);

        $this->assertEquals($discog->limit, 60);
    }

    /** @test */
    public function verify_rates()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $this->assertIsArray($discog->getRates());
    }
}
