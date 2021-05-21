<?php


namespace Xyrotech\Orin\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin\Orin;

class IdentityTest extends TestCase
{
    /** @test */
    public function verify_identity()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->identity();

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);

        // User Profile

        $profile = $discog->profile('kunli0');

        $this->assertJson($profile['response']);
        $this->assertEquals('200', $profile['status']);

        // Edit Profile

        $profile = $discog->edit_profile('kunli0', 'Adekunle Adelakun');

        $this->assertJson($profile['response']);
        $this->assertEquals('200', $profile['status']);

        // User Submissions

        $submissions = $discog->user_submissions('kunli0');

        $this->assertJson($submissions['response']);
        $this->assertEquals('200', $submissions['status']);

        // User Contributions

        $submissions = $discog->user_contributions('kunli0');

        $this->assertJson($submissions['response']);
        $this->assertEquals('200', $submissions['status']);
    }
}
