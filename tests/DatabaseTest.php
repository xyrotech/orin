<?php


namespace Xyrotech\Orin\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin\Orin;

class DatabaseTest extends TestCase
{
    private Orin  $discog;

    public function setUp() : void
    {
        $config = include('configs/config.test.php');

        $this->discog = new Orin($config);
    }

    /** @test */
    public function verify_database_release()
    {
        $release = $this->discog->release(192988);

        $this->assertEquals("While You Were Sleeping", $release->title);
        $this->assertEquals(200, $release->status);
    }

    /** @test */
    public function verify_release_rating_by_user()
    {
        $release_rating = $this->discog->release_rating_by_user(16457562, 'kunli0');


        $this->assertEquals(0, $release_rating->rating);
        $this->assertEquals(200, $release_rating->status);

        //Update Rating

        $update_rating = $this->discog->update_release_rating_by_user(16457562, 'kunli0', 5);

        $this->assertEquals(201, $update_rating->status);

        //Delete Rating

        $delete_rating = $this->discog->delete_release_rating_by_user(16457562, 'kunli0');

        $this->assertEquals(204, $delete_rating->status);
    }

    /** @test */
    public function verify_community_release_rating()
    {
        $community_release_rating = $this->discog->community_release_rating(16457562);

        $this->assertEquals(16457562, $community_release_rating->release_id);
        $this->assertEquals('200', $community_release_rating->status);
    }

    /** @test */
    public function verify_release_stats()
    {
        $release_stats = $this->discog->release_stats(16457562);

        // TODO: Functionally currently broken on API side see .xls

        $this->assertEquals(false, $release_stats->is_offensive);
        $this->assertEquals('200', $release_stats->status);
    }

   /** @test */
    public function verify_master_release()
    {
        $master = $this->discog->master_release(2482);

        $this->assertEquals('Classics', $master->title);
        $this->assertEquals('200', $master->status);
    }

    /** @test */
    public function verify_master_release_versions()
    {
        $master_releases = $this->discog->master_release_versions(2482, ['sort' => 'released', 'sort_order' => 'asc']);

        $this->assertEquals(188144, $master_releases->versions[0]->id);
        $this->assertEquals('200', $master_releases->status);
    }

    /** @test */
    public function verify_artist()
    {
        $artist = $this->discog->artist(45);

        $this->assertEquals("Aphex Twin", $artist->name);
        $this->assertEquals('200', $artist->status);
    }

    /** @test */
    public function verify_artist_releases()
    {
        $artist = $this->discog->artist_releases(45, ['sort' => 'year']);

        $this->assertJson(870, $artist->releases[0]->id);
        $this->assertEquals('200', $artist->status);
    }

    /** @test */
    public function verify_label()
    {
        $label = $this->discog->label(107);

        $this->assertEquals("Rephlex", $label->name);
        $this->assertEquals('200', $label->status);
    }

    /** @test */
    public function verify_all_label_releases()
    {
        $label = $this->discog->all_label_releases(107);

        $this->assertEquals(101788, $label->releases[0]->id);
        $this->assertEquals('200', $label->status);
    }

    /** @test */
    public function verify_search()
    {
        $search = $this->discog->search("While You Were Sleeping", ['artist' => "Opiate"]);

        $this->assertEquals(259279, $search->results[0]->id);
        $this->assertEquals('200', $search->status);
    }
}
