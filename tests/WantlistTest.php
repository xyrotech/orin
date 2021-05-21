<?php


namespace Xyrotech\Orin\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin\Orin;

class WantlistTest extends TestCase
{
    /** @test */
    public function verify_wantlist()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $release_id = 2097562;

        // Get want list
        $json = $discog->wantlist('kunli0');

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);

        // Add to wantlist

        $add = $discog->add_to_wantlist('kunli0', $release_id);

        $this->assertJson($add['response']);
        $this->assertEquals('201', $add['status']);

        // Delete from wantlist

        $delete = $discog->delete_from_wantlist('kunli0', $release_id);

        $this->assertEquals('204', $delete['status']);
    }
}
