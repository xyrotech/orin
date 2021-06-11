<?php

namespace Xyrotech\Orin\Traits;

trait CollectionTrait
{
    public function new_collection_folder(string $username, string $name): object
    {
        $this->parameters = ['json' => ['name' => $name]];

        return $this->response('POST', "/users/{$username}/collection/folders");
    }

    public function collection_folder(string $username, int $folder_id): object
    {
        return $this->response('GET', "/users/{$username}/collection/folders/{$folder_id}");
    }

    public function collection_folder_meta(string $username, int $folder_id, string $name): object
    {
        $this->parameters = ['json' => ['name' => $name]];

        return $this->response('POST', "/users/{$username}/collection/folders/{$folder_id}");
    }

    public function collection_folder_delete(string $username, int $folder_id): object
    {
        return $this->response('DELETE', "/users/{$username}/collection/folders/{$folder_id}");
    }


    public function collection_items_by_release(string $username, int $release_id): object
    {
        return $this->response('GET', "/users/{$username}/collection/releases/{$release_id}");
    }

    public function collection_items_by_folder(string $username, int $folder_id): object
    {
        return $this->response('GET', "/users/{$username}/collection/folders/{$folder_id}/releases");
    }


    public function add_to_collection_folder(string $username, int $folder_id, int $release_id): object
    {
        return $this->response('POST', "/users/{$username}/collection/folders/{$folder_id}/releases/{$release_id}");
    }

    public function change_rating_of_release(string $username, int $folder_id, int $release_id, int $instance_id, string $rating): object
    {
        $this->parameters = ['json' => ['rating' => $rating]];

        return $this->response('POST', "/users/{$username}/collection/folders/{$folder_id}/releases/{$release_id}/instances/{$instance_id}");
    }

    public function delete_instance_from_folder(string $username, int $folder_id, int $release_id, int $instance_id): object
    {
        return $this->response('DELETE', "/users/{$username}/collection/folders/{$folder_id}/releases/{$release_id}/instances/{$instance_id}");
    }

    public function list_custom_fields(string $username): object
    {
        return $this->response('GET',  "/users/{$username}/collection/fields");
    }

    public function edit_fields_instance(string $username, string $value, int $folder_id, int $release_id, int $instance_id, int $field_id): object
    {
        $this->parameters = ['json' => ['value' => $value]];

        return $this->response('POST', "/users/{$username}/collection/folders/{$folder_id}/releases/{$release_id}/instances/{$instance_id}/fields/{$field_id}");
    }

    public function collection_value(string $username): object
    {
        return $this->response('GET', "/users/{$username}/collection/value");
    }
}
