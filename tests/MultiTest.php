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

    /** @test */
    public function verify_user_lists()
    {
        $users = $this->discog->user_lists($this->discog->config['USERNAME']);

        $this->assertEquals("Testing", $users->lists[0]->name);
        $this->assertEquals('200', $users->status_code);


        $id = $users->lists[0]->id;

        $list = $this->discog->list($id);

        $this->assertEquals("Testing", $list->name);
        $this->assertEquals('200', $list->status_code);
    }

    /** @test */
    public function verify_identity()
    {
        $identity = $this->discog->identity();

        $this->assertEquals($this->discog->config['USERNAME'], $identity->username);
        $this->assertEquals('200', $identity->status_code);

        // User Profile

        $profile = $this->discog->profile($this->discog->config['USERNAME']);

        $this->assertEquals($this->discog->config['TEST_NAME'], $profile->name);
        $this->assertEquals('200', $profile->status_code);

        // Edit Profile

        $profile = $this->discog->edit_profile($this->discog->config['USERNAME'], ['name' => $this->discog->config['TEST_NAME']]);

        $this->assertEquals($this->discog->config['USERNAME'], $profile->username);
        $this->assertEquals('200', $profile->status_code);

        // User Submissions

        $user = $this->discog->user_submissions($this->discog->config['USERNAME']);

        $this->assertEquals(16457562, $user->submissions->releases[0]->id);
        $this->assertEquals('200', $user->status_code);

        // User Contributions

        $user = $this->discog->user_contributions($this->discog->config['USERNAME']);

        $this->assertEquals(16457562, $user->contributions[0]->id);
        $this->assertEquals('200', $user->status_code);
    }

    /** @test */
    public function verify_wantlist()
    {
        $releases = [
            2097562, 85968, 23266, 197277,
            68256, 9864, 154165, 478135,
            68364, 1879862, 340357, 239247,
            237600, 1769821, 30194, 87874,
        ];

        $release_id = array_rand(array_flip($releases), 1);

        // Get want list
        $user = $this->discog->wantlist($this->discog->config['USERNAME']);

        $this->assertEquals(6798, $user->wants[0]->id);
        $this->assertEquals('200', $user->status_code);

        // Add to wantlist

        $add = $this->discog->add_to_wantlist($this->discog->config['USERNAME'], $release_id);

        $this->assertEquals('201', $add->status_code);

        // Delete from wantlist

        $delete = $this->discog->delete_from_wantlist($this->discog->config['USERNAME'], $release_id);

        $this->assertEquals('204', $delete->status_code);
    }
}
