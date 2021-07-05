<?php


namespace Xyrotech\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin;

class AuthenticationTest extends TestCase
{

    /** @test */
    public function verify_request_token()
    {
        if (getenv('DISCOGS_TOKEN') !== false) {
            $config = [
                'DISCOGS_TOKEN' => getenv('DISCOGS_TOKEN'),
                'DISCOGS_CONSUMER_KEY' => getenv('DISCOGS_CONSUMER_KEY'),
                'DISCOGS_CONSUMER_SECRET' => getenv('DISCOGS_CONSUMER_SECRET'),
                'DISCOGS_VERSION' => 'v2',
                'DISCOGS_MEDIA_TYPE' => 'discogs',
                'DISCOGS_USER_AGENT' => 'Orin/0.1 +http://orin.xyrotech.com',
                'OAUTH_CALLBACK' => getenv('OAUTH_CALLBACK'),
                'RATE_THRESHOLD' => '6',
                'USERNAME' => 'kunli0',
            ];
        } else {
            $config = include('configs/config.php');
        }

        $discog = new Orin($config);

        $oauth = $discog->request_token();

        $this->assertEquals('200', $oauth->status_code);
    }
}
