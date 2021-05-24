<?php


namespace Xyrotech\Orin\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin\Orin;

class MultiTest extends TestCase
{
    public function setUp(): void
    {
        sleep(5);
    }


    public function verify_user_lists()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->user_lists('kunli0');

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);

        $user_list = json_decode($json['response']);

        $id = $user_list->lists[0]->id;

        $list = $discog->list($id);

        $this->assertJson($list['response']);
        $this->assertEquals('200', $list['status']);
    }


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
