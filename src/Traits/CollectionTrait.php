<?php

namespace Xyrotech\Orin\Traits;

trait CollectionTrait
{
    public function collection(string $username): string
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/folders';

        return $this->request('GET', $uri)->getBody();
    }

    public function collection_folder(string $username, int $folder_id): string
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/folders/' . $folder_id;

        return $this->request('GET', $uri)->getBody();
    }

    public function collection_items_by_release(string $username, int $release_id): CollectionTrait
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/releases/' . $release_id;

        return $this->request('GET', $uri)->getBody();
    }

    public function collection_items_by_folder(string $username, int $folder_id): CollectionTrait
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/folders/' . $folder_id . '/releases';

        return $this->request('GET', $uri)->getBody();
    }

    public function add_collection_to_folder(string $username, int $folder_id, int $release_id): CollectionTrait
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/folders/' . $folder_id . '/releases/' . $release_id;

        return $this->request('GET', $uri)->getBody();
    }

    public function change_rating_of_release(string $username, int $folder_id, int $release_id, int $instance_id): CollectionTrait
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/folders/' . $folder_id . '/releases/' .
                     $release_id . '/instances/' . $instance_id;

        return $this->request('GET', $uri)->getBody();
    }

    public function list_custom_fields(string $username): CollectionTrait
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/fields';

        return $this->request('GET', $uri)->getBody();
    }

    public function edit_fields_instance(string $username, string $value, int $folder_id, int $release_id, int $instance_id, int $field_id): CollectionTrait
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/folders/' . $folder_id . '/releases/' .
                     $release_id . '/instances/' . $instance_id . '/fields/' . $field_id;

        $this->parameters = ['query' => [$value]];

        return $this->request('GET', $uri)->getBody();
    }

    public function collection_value(string $username): CollectionTrait
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/value';

        return $this->request('GET', $uri)->getBody();
    }
}
