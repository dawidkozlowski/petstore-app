<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class PetApiClient
{
    public function __construct(private HttpClientInterface $client) {}

    public function getPet(int $id): array
    {
        $response = $this->client->request('GET', "https://petstore.swagger.io/v2/pet/$id");
        return $response->toArray(false);
    }

    public function addPet(array $data): array
    {
        $response = $this->client->request('POST', "https://petstore.swagger.io/v2/pet", [
            'json' => $data
        ]);
        return $response->toArray(false);
    }

    public function updatePet(array $data): array
    {
        $response = $this->client->request('PUT', "https://petstore.swagger.io/v2/pet", [
            'json' => $data
        ]);
        return $response->toArray(false);
    }

    public function deletePet(int $id): array
    {
        $response = $this->client->request('DELETE', "https://petstore.swagger.io/v2/pet/$id");
        return $response->toArray(false);
    }
}
