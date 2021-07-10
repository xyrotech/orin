<?php


namespace Xyrotech\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin;

class DatabaseTest extends TestCase
{
    private Orin  $discog;

    public function setUp() : void
    {
        if (getenv('DISCOGS_TOKEN') !== false) {
            $config = [
                'DISCOGS_TOKEN' => getenv('DISCOGS_TOKEN'),
                'DISCOGS_CONSUMER_KEY' => null,
                'DISCOGS_CONSUMER_SECRET' => null,
                'DISCOGS_VERSION' => 'v2',
                'DISCOGS_MEDIA_TYPE' => 'discogs',
                'DISCOGS_USER_AGENT' => 'Orin/0.1 +http://orin.xyrotech.com',
                'RATE_THRESHOLD' => '6',
                'USERNAME' => 'kunli0',
            ];
        } else {
            $config = include('configs/config.php');
        }

        $this->discog = new Orin($config);
    }

    /** @test */
    public function verify_release()
    {
        $release = $this->discog->release(192988);

        $this->assertEquals("While You Were Sleeping", $release->title);
        $this->assertEquals(200, $release->status_code);
    }

    /** @test */
    public function verify_release_rating_by_user()
    {
        $release_rating = $this->discog->release_rating_by_user(16457562, $this->discog->config['USERNAME']);


        $this->assertEquals(0, $release_rating->rating);
        $this->assertEquals(200, $release_rating->status_code);

        //Update Rating

        $update_rating = $this->discog->update_release_rating_by_user(16457562, $this->discog->config['USERNAME'], 5);

        $this->assertEquals(201, $update_rating->status_code);

        //Delete Rating

        $delete_rating = $this->discog->delete_release_rating_by_user(16457562, $this->discog->config['USERNAME']);

        $this->assertEquals(204, $delete_rating->status_code);
    }

    /** @test */
    public function verify_community_release_rating()
    {
        $community_release_rating = $this->discog->community_release_rating(16457562);

        $this->assertEquals(16457562, $community_release_rating->release_id);
        $this->assertEquals('200', $community_release_rating->status_code);
    }

    /** @test */
    public function verify_release_stats()
    {
        $release_stats = $this->discog->release_stats(16457562);

        // TODO: Functionally currently broken on API side see .xls

        $this->assertEquals(false, $release_stats->is_offensive);
        $this->assertEquals('200', $release_stats->status_code);
    }

    /** @test */
    public function verify_master_release()
    {
        $master = $this->discog->master_release(2482);

        $this->assertEquals('Classics', $master->title);
        $this->assertEquals('200', $master->status_code);
    }

    /** @test */
    public function verify_master_release_versions()
    {
        $master_releases = $this->discog->master_release_versions(2482, ['sort' => 'released', 'sort_order' => 'desc']);

        $this->assertEquals(13567396, $master_releases->versions[0]->id);
        $this->assertEquals('200', $master_releases->status_code);
    }

    /** @test */
    public function verify_artist()
    {
        $artist = $this->discog->artist(45);

        $this->assertEquals("Aphex Twin", $artist->name);
        $this->assertEquals('200', $artist->status_code);
    }

    /** @test */
    public function verify_artist_releases()
    {
        $artist = $this->discog->artist_releases(45, ['sort' => 'year']);

        $this->assertJson(870, $artist->releases[0]->id);
        $this->assertEquals('200', $artist->status_code);
    }

    /** @test */
    public function verify_label()
    {
        $label = $this->discog->label(107);

        $this->assertEquals("Rephlex", $label->name);
        $this->assertEquals('200', $label->status_code);
    }

    /** @test */
    public function verify_all_label_releases()
    {
        $label = $this->discog->all_label_releases(107);

        $this->assertEquals(56955, $label->releases[0]->id);
        $this->assertEquals('200', $label->status_code);
    }

    /** @test */
    public function verify_search()
    {
        $search = $this->discog->search("While You Were Sleeping", ['artist' => "Opiate", 'type' => "master"]);

        $this->assertEquals(33299, $search->results[0]->id);
        $this->assertEquals('200', $search->status_code);
    }
}
