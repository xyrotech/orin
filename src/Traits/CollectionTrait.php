<?php

namespace Xyrotech\Orin\Traits;

trait CollectionTrait
{
    /**
     * Create a new folder in a user’s collection.
     *
     * @param string $username
     * @param string $name
     * @return object
     */
    public function new_collection_folder(string $username, string $name) : object
    {
        $this->parameters = ['json' => ['name' => $name]];

        return $this->response('POST', "/users/$username/collection/folders");
    }

    /**
     * Retrieve metadata about a folder in a user’s collection.
     *
     * @param string $username
     * @param int $folder_id
     * @return object
     */
    public function collection_folder(string $username, int $folder_id) : object
    {
        return $this->response('GET', "/users/$username/collection/folders/$folder_id");
    }

    /**
     * Edit a folder’s metadata.
     *
     * @param string $username
     * @param int $folder_id
     * @param string $name
     * @return object
     */
    public function collection_folder_edit(string $username, int $folder_id, string $name) : object
    {
        $this->parameters = ['json' => ['name' => $name]];

        return $this->response('POST', "/users/$username/collection/folders/$folder_id");
    }

    /**
     * Delete a folder from a user’s collection.
     *
     * @param string $username
     * @param int $folder_id
     * @return object
     */
    public function collection_folder_delete(string $username, int $folder_id) : object
    {
        return $this->response('DELETE', "/users/$username/collection/folders/$folder_id");
    }


    /**
     * View the user’s collection folders which contain a specified release.
     *
     * @param string $username
     * @param int $release_id
     * @return object
     */
    public function collection_items_by_release(string $username, int $release_id) : object
    {
        return $this->response('GET', "/users/$username/collection/releases/$release_id");
    }

    /**
     * Returns the list of item in a folder in a user’s collection.
     *
     * @param string $username
     * @param int $folder_id
     * @return object
     */
    public function collection_items_by_folder(string $username, int $folder_id) : object
    {
        return $this->response('GET', "/users/$username/collection/folders/$folder_id/releases");
    }


    /**
     * Add a release to a folder in a user’s collection.
     *
     * @param string $username
     * @param int $folder_id
     * @param int $release_id
     * @return object
     */
    public function add_to_collection_folder(string $username, int $folder_id, int $release_id) : object
    {
        return $this->response('POST', "/users/$username/collection/folders/$folder_id/releases/$release_id");
    }

    /**
     * Change the rating on a release and/or move the instance to another folder.
     *
     * @param string $username
     * @param int $folder_id
     * @param int $release_id
     * @param int $instance_id
     * @param string $rating
     * @return object
     */
    public function change_rating_of_release(string $username, int $folder_id, int $release_id, int $instance_id, string $rating) : object
    {
        $this->parameters = ['json' => ['rating' => $rating]];

        return $this->response('POST', "/users/$username/collection/folders/$folder_id/releases/$release_id/instances/$instance_id");
    }

    /**
     * Remove an instance of a release from a user’s collection folder.
     *
     * @param string $username
     * @param int $folder_id
     * @param int $release_id
     * @param int $instance_id
     * @return object
     */
    public function delete_instance_from_folder(string $username, int $folder_id, int $release_id, int $instance_id) : object
    {
        return $this->response('DELETE', "/users/$username/collection/folders/$folder_id/releases/$release_id/instances/$instance_id");
    }

    /**
     * Retrieve a list of user-defined collection notes fields.
     *
     * @param string $username
     * @return object
     */
    public function list_custom_fields(string $username) : object
    {
        return $this->response('GET',  "/users/$username/collection/fields");
    }

    /**
     * Change the value of a notes field on a particular instance.
     *
     * @param string $username
     * @param string $value
     * @param int $folder_id
     * @param int $release_id
     * @param int $instance_id
     * @param int $field_id
     * @return object
     */
    public function edit_fields_instance(string $username, string $value, int $folder_id, int $release_id, int $instance_id, int $field_id) : object
    {
        $this->parameters = ['json' => ['value' => $value]];

        return $this->response('POST', "/users/$username/collection/folders/$folder_id/releases/$release_id/instances/$instance_id/fields/$field_id");
    }

    /**
     * Returns the minimum, median, and maximum value of a user’s collection.
     *
     * @param string $username
     * @return object
     */
    public function collection_value(string $username) : object
    {
        return $this->response('GET', "/users/$username/collection/value");
    }
}
