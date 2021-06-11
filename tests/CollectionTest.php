<?php


namespace Xyrotech\Orin\Tests;

use PHPUnit\Framework\TestCase;
use Xyrotech\Orin\Orin;

class CollectionTest extends TestCase
{
    private Orin $discog;

    public function setUp() : void
    {
        $config = include('configs/config.test.php');

        $this->discog = new Orin($config);
    }

    /** @test */
    public function verify_new_meta_delete_collection_folder()
    {
        // Creating "new" folder
        $new_folder = $this->discog->new_collection_folder('kunli0', 'new');

        $this->assertEquals("new", $new_folder->name);
        $this->assertEquals('201', $new_folder->status_code);


        $new_name = 'Rename' . time();

        // Renaming "new" folder
        $rename = $this->discog->collection_folder_meta('kunli0', $new_folder->id, $new_name);

        $this->assertEquals($new_name, $rename->name);
        $this->assertEquals('200', $rename->status_code);

        // Deleting "new" folder
        $delete = $this->discog->collection_folder_delete('kunli0', $rename->id);

        $this->assertEquals('204', $delete->status_code);
    }

    /** @test */
    public function verify_collection_folder()
    {
        $folder = $this->discog->collection_folder('kunli0', 1);

        $this->assertEquals("Uncategorized", $folder->name);
        $this->assertEquals('200', $folder->status_code);
    }

    /** @test */
    public function verify_collection_items_by_release()
    {
        $folder = $this->discog->collection_items_by_release('kunli0', 16457562);

        $this->assertEquals(540101661, $folder->releases[0]->instance_id);
        $this->assertEquals('200', $folder->status_code);
    }

    /** @test */
    public function verify_collection_items_by_folder()
    {
        $folder = $this->discog->collection_items_by_folder('kunli0', 0);

        $this->assertEquals(8836, $folder->releases[0]->id);
        $this->assertEquals('200', $folder->status_code);
    }

    /** @test */
    public function verify_add_rating_edit_delete_on_collection_folder()
    {
        $release_id = 2097562;

        $add = $this->discog->add_to_collection_folder('kunli0', 1, $release_id);

        $this->assertEquals('201', $add->status_code);

        //Change rating of release

        $rating = $this->discog->change_rating_of_release('kunli0', 1, $release_id, $add->instance_id, 5);

        $this->assertEquals('204', $rating->status_code);

        //Change release custom fields

        $edit = $this->discog->edit_fields_instance('kunli0', 'Testing', 1, $release_id, $add->instance_id, 3);

        $this->assertEquals('204', $edit->status_code);


        //Delete release

        $delete = $this->discog->delete_instance_from_folder('kunli0', 1, $release_id, $add->instance_id);

        $this->assertEquals('204', $delete->status_code);
    }

    /** @test */
    public function verify_list_custom_fields()
    {
        $custom = $this->discog->list_custom_fields('kunli0');

        $this->assertEquals("Media Condition", $custom->fields[0]->name);
        $this->assertEquals('200', $custom->status_code);
    }

    /** @test */
    public function verify_collection_value()
    {
        $collection = $this->discog->collection_value('kunli0');

        $this->assertEquals("$10.00", $collection->minimum);
        $this->assertEquals('200', $collection->status_code);
    }
}
