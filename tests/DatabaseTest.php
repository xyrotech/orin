<?php


namespace Xyrotech\Orin\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin\Orin;

class DatabaseTest extends TestCase
{

    /** @test */
    public function verify_database_release_trait()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->release(192988);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_release_rating_by_user()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $release_rating = $discog->release_rating_by_user(16457562, 'kunli0');

        // die(var_dump(json_decode($release_rating['response'])));
        $this->assertJson($release_rating['response']);
        $this->assertEquals('200', $release_rating['status']);

        //Update Rating

        $update_rating = $discog->update_release_rating_by_user(16457562, 'kunli0', 5);

        $this->assertEquals('201', $update_rating['status']);

        //Delete Rating

        $delete_rating = $discog->delete_release_rating_by_user(16457562, 'kunli0');

        $this->assertEquals('204', $delete_rating['status']);
    }

    /** @test */
    public function verify_community_release_rating()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->community_release_rating(16457562);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_release_stats()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->release_stats(16457562);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_master_release()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->master_releases(2482);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_master_release_versions()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->master_release_versions(2482, ['sort' => 'released']);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_artist()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->artist(45);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_artist_releases()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->artist_releases(45, ['sort' => 'year']);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_label()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->label(107);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_all_label_releases()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->all_label_releases(107);

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }

    /** @test */
    public function verify_search()
    {
        $config = include('configs/config.test.php');

        $discog = new Orin($config);

        $json = $discog->search('test');

        $this->assertJson($json['response']);
        $this->assertEquals('200', $json['status']);
    }
}
