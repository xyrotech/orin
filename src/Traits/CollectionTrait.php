<?php

namespace Xyrotech\Orin\Traits;

use phpDocumentor\Reflection\Types\Array_;
use Psr\Http\Message\StreamInterface;

trait CollectionTrait
{
    public function collection(string $username): array
    {
        return $this->response('GET', '/users/' . $username . '/collection/folders');
    }

    public function new_collection_folder(string $username, string $name): array
    {
        $this->parameters = ['json' => ['name' => $name]];

        return $this->response('POST', '/users/' . $username . '/collection/folders');
    }

    public function collection_folder(string $username, int $folder_id): array
    {
        return $this->response('GET', '/users/' . $username . '/collection/folders/' . $folder_id);
    }

    public function collection_folder_meta(string $username, int $folder_id, string $name): array
    {
        $this->parameters = ['json' => ['name' => $name]];

        return $this->response('POST', '/users/' . $username . '/collection/folders/' . $folder_id);
    }

    public function collection_folder_delete(string $username, int $folder_id): array
    {
        return $this->response('DELETE', '/users/' . $username . '/collection/folders/' . $folder_id);
    }


    public function collection_items_by_release(string $username, int $release_id): array
    {
        return $this->response('GET', '/users/' . $username . '/collection/releases/' . $release_id);
    }

    public function collection_items_by_folder(string $username, int $folder_id): array
    {
        return $this->response('GET', '/users/' . $username . '/collection/folders/' . $folder_id . '/releases');
    }


    public function add_collection_to_folder(string $username, int $folder_id, int $release_id): array
    {
        return $this->response('POST', '/users/' . $username . '/collection/folders/' . $folder_id . '/releases/' . $release_id);
    }

    public function change_rating_of_release(string $username, int $folder_id, int $release_id, int $instance_id, string $rating): array
    {
        $this->parameters = ['json' => ['rating' => $rating]];

        return $this->response('POST', '/users/' . $username . '/collection/folders/' . $folder_id . '/releases/' . $release_id . '/instances/' . $instance_id);
    }

    public function list_custom_fields(string $username): array
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/fields';

        return $this->response('GET', $uri)->getBody();
    }

    public function edit_fields_instance(string $username, string $value, int $folder_id, int $release_id, int $instance_id, int $field_id): array
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/folders/' . $folder_id . '/releases/' .
                     $release_id . '/instances/' . $instance_id . '/fields/' . $field_id;

        $this->parameters = ['query' => [$value]];

        return $this->response('GET', $uri)->getBody();
    }

    public function collection_value(string $username): array
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/value';

        return $this->response('GET', $uri)->getBody();
    }


}
