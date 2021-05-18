<?php

namespace Xyrotech\Orin\Traits;

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


    public function collection_items_by_release(string $username, int $release_id): StreamInterface
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/releases/' . $release_id;

        return $this->client->request('GET', $uri)->getBody();
    }

    public function collection_items_by_folder(string $username, int $folder_id): StreamInterface
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/folders/' . $folder_id . '/releases';

        return $this->client->request('GET', $uri)->getBody();
    }

    public function add_collection_to_folder(string $username, int $folder_id, int $release_id): StreamInterface
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/folders/' . $folder_id . '/releases/' . $release_id;

        return $this->client->request('GET', $uri)->getBody();
    }

    public function change_rating_of_release(string $username, int $folder_id, int $release_id, int $instance_id): StreamInterface
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/folders/' . $folder_id . '/releases/' .
                     $release_id . '/instances/' . $instance_id;

        return $this->client->request('GET', $uri)->getBody();
    }

    public function list_custom_fields(string $username): StreamInterface
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/fields';

        return $this->client->request('GET', $uri)->getBody();
    }

    public function edit_fields_instance(string $username, string $value, int $folder_id, int $release_id, int $instance_id, int $field_id): StreamInterface
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/folders/' . $folder_id . '/releases/' .
                     $release_id . '/instances/' . $instance_id . '/fields/' . $field_id;

        $this->parameters = ['query' => [$value]];

        return $this->client->request('GET', $uri)->getBody();
    }

    public function collection_value(string $username): StreamInterface
    {
        $uri = self::base_uri . '/users/' . $username . '/collection/value';

        return $this->client->request('GET', $uri)->getBody();
    }

    private function response(string $type, string $uri) : array
    {
        $response = $this->client->request($type, self::base_uri . $uri, $this->parameters);

        return ['response' => $response->getBody(), 'status' => $response->getStatusCode()];
    }
}
