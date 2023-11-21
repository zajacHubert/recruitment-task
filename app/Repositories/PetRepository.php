<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Clients\PetClient;
use App\Repositories\Contracts\PetRepositoryInterface;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Psr\Http\Message\ResponseInterface;
use Illuminate\View\View as LaravelView;

class PetRepository implements PetRepositoryInterface
{
    private $petClient;

    public function __construct(PetClient $petClient)
    {
        $this->petClient = $petClient;
    }

    public function getPetsByStatus(Request $request): LaravelView
    {
        $status = $request->status ?? 'available';

        try {
            $response = $this->petClient->sendRequest('GET', 'pet/findByStatus', ['query' => ['status' => $status]]);

            if ($response->getStatusCode() === 200) {
                $bodyContents = $response->getBody()->getContents();
                $pets = json_decode($bodyContents, true);

                return view('pets.pets', ['pets' => $pets]);
            } else {
                return view('pets.error');
            }
        } catch (RequestException $e) {
            return view('pets.error');
        }
    }

    public function getPetById(int $id): ResponseInterface
    {
        $url = "pet/{$id}";

        try {
            $response = $this->petClient->sendRequest('GET', $url);
            return $response;
        } catch (RequestException $e) {
            throw $e;
        }
    }

    public function show(int $id): LaravelView
    {
        try {
            $petResponse = $this->getPetById($id);

            if ($petResponse->getStatusCode() === 200) {
                $bodyContents = $petResponse->getBody()->getContents();
                $pet = json_decode($bodyContents, true);

                return View::make('pets.show', ['pet' => $pet]);
            } else {
                return View::make('pets.error');
            }
        } catch (RequestException $e) {
            return View::make('pets.error');
        }
    }
}
