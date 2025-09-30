<?php
namespace App\Service;

use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\Exception\ServerException;
use Symfony\Component\HttpClient\Exception\TimeoutException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PetApiClient
{
    public function __construct(private HttpClientInterface $client) {}

    /**
     * Get a pet by ID
     *
     * @param int $id The pet ID
     * @return array The pet data
     * @throws \Exception If the API request fails
     */
    public function getPet(int $id): array
    {
        try {
            $response = $this->client->request('GET', "https://petstore.swagger.io/v2/pet/$id", [
                'timeout' => 5.0
            ]);
            return $response->toArray(false);
        } catch (ClientException $e) {
            throw new \Exception("Pet not found or client error: " . $e->getMessage());
        } catch (ServerException $e) {
            throw new \Exception("Server error while fetching pet: " . $e->getMessage());
        } catch (TimeoutException $e) {
            throw new \Exception("Request timed out while fetching pet: " . $e->getMessage());
        } catch (TransportExceptionInterface $e) {
            throw new \Exception("Network error while fetching pet: " . $e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception("Error fetching pet: " . $e->getMessage());
        }
    }

    /**
     * Add a new pet
     *
     * @param array $data The pet data
     * @return array The API response
     * @throws \Exception If the API request fails
     */
    public function addPet(array $data): array
    {
        try {
            $response = $this->client->request('POST', "https://petstore.swagger.io/v2/pet", [
                'json' => $data,
                'timeout' => 5.0
            ]);
            return $response->toArray(false);
        } catch (ClientException $e) {
            throw new \Exception("Client error while adding pet: " . $e->getMessage());
        } catch (ServerException $e) {
            throw new \Exception("Server error while adding pet: " . $e->getMessage());
        } catch (TimeoutException $e) {
            throw new \Exception("Request timed out while adding pet: " . $e->getMessage());
        } catch (TransportExceptionInterface $e) {
            throw new \Exception("Network error while adding pet: " . $e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception("Error adding pet: " . $e->getMessage());
        }
    }

    /**
     * Update an existing pet
     *
     * @param array $data The pet data
     * @return array The API response
     * @throws \Exception If the API request fails
     */
    public function updatePet(array $data): array
    {
        try {
            $response = $this->client->request('PUT', "https://petstore.swagger.io/v2/pet", [
                'json' => $data,
                'timeout' => 5.0
            ]);
            return $response->toArray(false);
        } catch (ClientException $e) {
            throw new \Exception("Client error while updating pet: " . $e->getMessage());
        } catch (ServerException $e) {
            throw new \Exception("Server error while updating pet: " . $e->getMessage());
        } catch (TimeoutException $e) {
            throw new \Exception("Request timed out while updating pet: " . $e->getMessage());
        } catch (TransportExceptionInterface $e) {
            throw new \Exception("Network error while updating pet: " . $e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception("Error updating pet: " . $e->getMessage());
        }
    }

    /**
     * Delete a pet
     *
     * @param int $id The pet ID
     * @return array The API response
     * @throws \Exception If the API request fails
     */
    public function deletePet(int $id): array
    {
        try {
            $response = $this->client->request('DELETE', "https://petstore.swagger.io/v2/pet/$id", [
                'timeout' => 5.0
            ]);
            return $response->toArray(false);
        } catch (ClientException $e) {
            throw new \Exception("Client error while deleting pet: " . $e->getMessage());
        } catch (ServerException $e) {
            throw new \Exception("Server error while deleting pet: " . $e->getMessage());
        } catch (TimeoutException $e) {
            throw new \Exception("Request timed out while deleting pet: " . $e->getMessage());
        } catch (TransportExceptionInterface $e) {
            throw new \Exception("Network error while deleting pet: " . $e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception("Error deleting pet: " . $e->getMessage());
        }
    }
}
