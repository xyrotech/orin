<?php


namespace Xyrotech\Orin\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin\Orin;

class DatabaseTest extends TestCase
{
    private Orin  $discog;

    public function setUp() : void
    {
        sleep(5);

        $config = include('configs/config.test.php');

        $this->discog = new Orin($config);
    }

    /** @test */
    public function verify_database_release_trait()
    {
        $json = $this->discog->release(192988);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_release_rating_by_user()
    {
        $release_rating = $this->discog->release_rating_by_user(16457562, 'kunli0');

        // die(var_dump(json_decode($release_rating['response'])));
        $this->assertJson($release_rating['response']);
        $this->assertEquals('200', $release_rating['status']);

        //Update Rating

        $update_rating = $this->discog->update_release_rating_by_user(16457562, 'kunli0', 5);

        $this->assertEquals('201', $update_rating['status']);

        //Delete Rating

        $delete_rating = $this->discog->delete_release_rating_by_user(16457562, 'kunli0');

        $this->assertEquals('204', $delete_rating['status']);
    }

    /** @test */
    public function verify_community_release_rating()
    {
        $json = $this->discog->community_release_rating(16457562);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_release_stats()
    {
        $json = $this->discog->release_stats(16457562);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_master_release()
    {
        $json = $this->discog->master_releases(2482);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_master_release_versions()
    {
        $json = $this->discog->master_release_versions(2482, ['sort' => 'released']);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_artist()
    {
        $json = $this->discog->artist(45);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_artist_releases()
    {
        $json = $this->discog->artist_releases(45, ['sort' => 'year']);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_label()
    {
        $json = $this->discog->label(107);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_all_label_releases()
    {
        $json = $this->discog->all_label_releases(107);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_search()
    {
        $json = $this->discog->search('test');

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }
}
