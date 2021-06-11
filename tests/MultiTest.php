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
        $users = $this->discog->user_lists('kunli0');

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

        $this->assertEquals("kunli0", $identity->username);
        $this->assertEquals('200', $identity->status_code);

        // User Profile

        $profile = $this->discog->profile('kunli0');

        $this->assertEquals("Adekunle Adelakun", $profile->name);
        $this->assertEquals('200', $profile->status_code);

        // Edit Profile

        $profile = $this->discog->edit_profile('kunli0', ['name' => 'Adekunle Adelakun']);

        $this->assertEquals("kunli0", $profile->username);
        $this->assertEquals('200', $profile->status_code);

        // User Submissions

        $user = $this->discog->user_submissions('kunli0');

        $this->assertEquals(16457562, $user->submissions->releases[0]->id);
        $this->assertEquals('200', $user->status_code);

        // User Contributions

        $user = $this->discog->user_contributions('kunli0');

        $this->assertEquals(16457562, $user->contributions[0]->id);
        $this->assertEquals('200', $user->status_code);
    }

    /** @test */
    public function verify_wantlist()
    {
        $release_id = 2097562;

        // Get want list
        $user = $this->discog->wantlist('kunli0');

        $this->assertEquals(6798, $user->wants[0]->id);
        $this->assertEquals('200', $user->status_code);

        // Add to wantlist

        $add = $this->discog->add_to_wantlist('kunli0', $release_id);

        $this->assertEquals('201', $add->status_code);

        // Delete from wantlist

        $delete = $this->discog->delete_from_wantlist('kunli0', $release_id);

        $this->assertEquals('204', $delete->status_code);
    }
}
