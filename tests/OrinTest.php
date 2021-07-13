<?php


namespace Xyrotech\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin;

class OrinTest extends TestCase
{

    /** @test */
    public function base_uri_is_correct()
    {
        $discog = new Orin();

        $config = include('config/orin.php');

        $this->assertEquals('v2', $config['DISCOGS_VERSION']);

        $this->assertEquals('https://api.discogs.com', $discog->client->getConfig('base_uri'));
    }

    /** @test */
    public function verify_client_using_token_auth()
    {
        // Used for github automation testing
        if (getenv('DISCOGS_TOKEN') !== false) {
            $config = [
                'DISCOGS_TOKEN' => getenv('DISCOGS_TOKEN'),
                'DISCOGS_CONSUMER_KEY' => null,
                'DISCOGS_CONSUMER_SECRET' => null,
                'DISCOGS_VERSION' => 'v2',
                'DISCOGS_MEDIA_TYPE' => 'discogs',
                'DISCOGS_USER_AGENT' => getenv('DISCOGS_USER_AGENT'),
                'RATE_THRESHOLD' => '6',
                'USERNAME' => 'kunli0',
            ];
        } else {
            $config = include('configs/config.php');
        }

        $this->discog = new Orin($config);

        $discog = new Orin($config);

        $this->assertEquals($discog->limit, 60);
    }

    /** @test */
    public function verify_client_using_no_auth()
    {
        $discog = new Orin();

        $this->assertEquals($discog->limit, 25);
    }


    /** @test */
    public function verify_client_using_key_secret_auth()
    {
        $config = [
            'DISCOGS_TOKEN' => null,
            'DISCOGS_CONSUMER_KEY' => 'YOUR_CONSUMER_KEY',
            'DISCOGS_CONSUMER_SECRET' => 'YOUR_CONSUMER_SECRET',
            'DISCOGS_VERSION' => 'v2',
            'DISCOGS_MEDIA_TYPE' => 'discogs',
            'DISCOGS_USER_AGENT' => getenv('DISCOGS_USER_AGENT'),
            'RATE_THRESHOLD' => '6',
            'USERNAME' => 'kunli0',
        ];


        $this->discog = new Orin($config);

        $discog = new Orin($config);

        $this->assertEquals($discog->limit, 60);
    }

    /** @test */
    public function verify_rates()
    {
        // Used for github automation testing
        if (getenv('DISCOGS_TOKEN') !== false) {
            $config = [
                'DISCOGS_TOKEN' => getenv('DISCOGS_TOKEN'),
                'DISCOGS_CONSUMER_KEY' => null,
                'DISCOGS_CONSUMER_SECRET' => null,
                'DISCOGS_VERSION' => 'v2',
                'DISCOGS_MEDIA_TYPE' => 'discogs',
                'DISCOGS_USER_AGENT' => getenv('DISCOGS_USER_AGENT'),
                'RATE_THRESHOLD' => '6',
                'USERNAME' => 'kunli0',
            ];
        } else {
            $config = include('configs/config.php');
        }

        $discog = new Orin($config);

        $this->assertIsArray($discog->rates);

        $headers = [];

        $headers['X-Discogs-Ratelimit-Used'][0] = 5;
        $headers['X-Discogs-Ratelimit-Remaining'][0] = 5;
        $headers['X-Discogs-Ratelimit'][0] = 60;

        $this->assertIsArray($discog->setRates($headers));
    }
}
