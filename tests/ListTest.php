<?php


namespace Xyrotech\Orin\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin\Orin;

class ListTest extends TestCase
{
    /** @test */
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
}
