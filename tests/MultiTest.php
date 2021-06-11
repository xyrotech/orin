<?php


namespace Xyrotech\Orin\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin\Orin;

class MultiTest extends TestCase
{
    private Orin  $discog;

    public function setUp(): void
    {
        $config = include('configs/config.test.php');

        $this->discog = new Orin($config);
    }

    ///** @test */
    public function verify_user_lists()
    {
        $json = $this->discog->user_lists('kunli0');

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);

        $user_list = json_decode($json['response']);

        $id = $user_list->lists[0]->id;

        $list = $this->discog->list($id);

        $this->assertJson($list['response']);
        $this->assertEquals('200', $list['status']);
    }

    ///** @test */
    public function verify_identity()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $this->discog->identity();

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);

        // User Profile

        $profile = $this->discog->profile('kunli0');

        $this->assertJson($profile['response']);
        $this->assertEquals('200', $profile['status']);

        // Edit Profile

        $profile = $this->discog->edit_profile('kunli0', 'Adekunle Adelakun');

        $this->assertJson($profile['response']);
        $this->assertEquals('200', $profile['status']);

        // User Submissions

        $submissions = $this->discog->user_submissions('kunli0');

        $this->assertJson($submissions['response']);
        $this->assertEquals('200', $submissions['status']);

        // User Contributions

        $submissions = $this->discog->user_contributions('kunli0');

        $this->assertJson($submissions['response']);
        $this->assertEquals('200', $submissions['status']);
    }

   // /** @test */
    public function verify_wantlist()
    {
        $release_id = 2097562;

        // Get want list
        $json = $this->discog->wantlist('kunli0');

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);

        // Add to wantlist

        $add = $this->discog->add_to_wantlist('kunli0', $release_id);

        $this->assertJson($add['response']);
        $this->assertEquals('201', $add['status']);

        // Delete from wantlist

        $delete = $this->discog->delete_from_wantlist('kunli0', $release_id);

        $this->assertEquals('204', $delete['status']);
    }
}
