<?php


namespace Xyrotech\Orin\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin\Orin;

class CollectionTest extends TestCase
{
    private Orin $discog;

    public function setUp() : void
    {
        if (getenv('DISCOG_TOKEN')) {
            $config = [
                'DISCOGS_TOKEN' => getenv('DISCOG_TOKEN'),
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
    public function verify_new_meta_delete_collection_folder()
    {
        // Creating "new" folder
        $new_folder = $this->discog->new_collection_folder($this->discog->config['USERNAME'], 'new');

        $this->assertEquals("new", $new_folder->name);
        $this->assertEquals('201', $new_folder->status_code);


        $new_name = 'Rename' . time();

        // Renaming "new" folder
        $rename = $this->discog->edit_collection_folder($this->discog->config['USERNAME'], $new_folder->id, $new_name);

        $this->assertEquals($new_name, $rename->name);
        $this->assertEquals('200', $rename->status_code);

        // Deleting "new" folder
        $delete = $this->discog->delete_collection_folder($this->discog->config['USERNAME'], $rename->id);

        $this->assertEquals('204', $delete->status_code);
    }

    /** @test */
    public function verify_collection_folder()
    {
        $folder = $this->discog->collection_folder($this->discog->config['USERNAME'], 1);

        $this->assertEquals("Uncategorized", $folder->name);
        $this->assertEquals('200', $folder->status_code);
    }

    /** @test */
    public function verify_collection_items_by_release()
    {
        $folder = $this->discog->collection_items_by_release($this->discog->config['USERNAME'], 16457562);

        $this->assertEquals(734075722, $folder->releases[0]->instance_id);
        $this->assertEquals('200', $folder->status_code);
    }

    /** @test */
    public function verify_collection_items_by_folder()
    {
        $folder = $this->discog->collection_items_by_folder($this->discog->config['USERNAME'], 0);

        $this->assertcontains($folder->releases[0]->id, [8836, 2097562]);
        $this->assertEquals('200', $folder->status_code);
    }

    /** @test */
    public function verify_add_rating_edit_delete_on_collection_folder()
    {
        $release_id = 2097562;

        $add = $this->discog->add_to_collection_folder($this->discog->config['USERNAME'], 1, $release_id);

        $this->assertEquals('201', $add->status_code);

        //Change rating of release

        $rating = $this->discog->change_rating_of_release($this->discog->config['USERNAME'], 1, $release_id, $add->instance_id, ['rating' => 5]);

        $this->assertEquals('204', $rating->status_code);

        //Change release custom fields

        $edit = $this->discog->edit_fields_instance($this->discog->config['USERNAME'], 'Testing', 1, $release_id, $add->instance_id, 3);

        $this->assertEquals('204', $edit->status_code);

        //Delete release

        $delete = $this->discog->delete_instance_from_folder($this->discog->config['USERNAME'], 1, $release_id, $add->instance_id);

        $this->assertEquals('204', $delete->status_code);
    }

    /** @test */
    public function verify_list_custom_fields()
    {
        $custom = $this->discog->list_custom_fields($this->discog->config['USERNAME']);

        $this->assertEquals("Media Condition", $custom->fields[0]->name);
        $this->assertEquals('200', $custom->status_code);
    }

    /** @test */
    public function verify_collection_value()
    {
        $collection = $this->discog->collection_value($this->discog->config['USERNAME']);

        $this->assertEquals('200', $collection->status_code);
    }
}
