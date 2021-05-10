<?php

trait CollectionTrait
{
    public function collection(string $username)
    {
        $this->uri = $this->base_uri . '/users/' . $username . '/collection/folders';

        return $this;
    }

    public function collection_folder(string $username, int $folder_id)
    {
        $this->uri = $this->base_uri . '/users/' . $username . '/collection/folders/' . $folder_id;

        return $this;
    }

    public function collection_items_by_release(string $username, int $release_id)
    {
        $this->uri = $this->base_uri . '/users/' . $username . '/collection/releases/' . $release_id;

        return $this;
    }

    public function collection_items_by_folder(string $username, int $folder_id)
    {
        $this->uri = $this->base_uri . '/users/' . $username . '/collection/folders/' . $folder_id . '/releases';

        return $this;
    }

    public function add_collection_to_folder(string $username, int $folder_id, int $release_id)
    {
        $this->uri = $this->base_uri . '/users/' . $username . '/collection/folders/' . $folder_id . '/releases/' . $release_id;

        return $this;
    }

    public function change_rating_of_release(string $username, int $folder_id, int $release_id, int $instance_id)
    {
        $this->uri = $this->base_uri . '/users/' . $username . '/collection/folders/' . $folder_id . '/releases/' .
                     $release_id . '/instances/' . $instance_id;

        return $this;
    }

    public function list_custom_fields(string $username)
    {
        $this->uri = $this->base_uri . '/users/' . $username . '/collection/fields';

        return $this;
    }

    public function edit_fields_instance(string $username, string $value, int $folder_id, int $release_id, int $instance_id, int $field_id)
    {
        $this->uri = $this->base_uri . '/users/' . $username . '/collection/folders/' . $folder_id . '/releases/' .
                     $release_id . '/instances/' . $instance_id . '/fields/' . $field_id;

        $this->parameters = ['query' => [$value]];

        return $this;
    }

    public function collection_value(string $username)
    {
        $this->uri = $this->base_uri . '/users/' . $username . '/collection/value';

        return $this;
    }
}
