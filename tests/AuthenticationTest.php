<?php


namespace Xyrotech\Orin\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin\Orin;

class AuthenticationTest extends TestCase
{

    /** @test */
    public function verify_request_token()
    {
        $config = include('configs/config.php');
        $discog = new Orin($config);

        $oauth = $discog->request_token();

        $this->assertEquals('200', $oauth->status_code);
    }
}
