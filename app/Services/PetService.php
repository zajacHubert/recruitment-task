<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Clients\PetClient;
use App\Repositories\Contracts\PetRepositoryInterface;
use App\Services\Contracts\PetServiceInterface;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PetService implements PetServiceInterface
{
    private PetClient $petClient;
    private PetRepositoryInterface $petRepository;

    public function __construct(PetClient $petClient, PetRepositoryInterface $petRepository)
    {
        $this->petClient = $petClient;
        $this->petRepository = $petRepository;
    }

    public function showAddForm(): View
    {
        return view('pets.create');
    }

    public function edit(int $id): View
    {
        try {
            $response = $this->petRepository->getPetById($id);

            if ($response->getStatusCode() === 200) {
                $bodyContents = $response->getBody()->getContents();
                $petData = json_decode($bodyContents, true);

                return view('pets.edit', ['pet' => $petData]);
            } else {
                return view('pets.error');
            }
        } catch (RequestException $e) {
            return view('pets.error');
        }
    }

    public function create(): View
    {
        return view('pets.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string|min:3|max:50',
            'status' => 'required|in:available,sold,pending',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.min' => 'The name must be at least 3 characters.',
            'name.max' => 'The name may not be greater than 50 characters.',
            'status.required' => 'The status field is required.',
            'status.in' => 'Invalid status. Please choose from available, sold, or pending.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $path = 'pet';
        $options = [
            'json' => $data,
        ];

        try {
            $response = $this->petClient->sendRequest('POST', $path, $options);

            if ($response->getStatusCode() === 200) {
                session()->flash('success', 'Pet created successfully!');
                return redirect('/pets');
            } else {
                session()->flash('error', 'Failed to create pet. Please try again.');
                return redirect()->back();
            }
        } catch (RequestException $e) {
            session()->flash('error', 'Failed to make API request. Please try again.');
            return redirect()->back();
        }
    }

    public function update(int $id, Request $request): RedirectResponse
    {
        $data = $request->all();
        $data['id'] = $id;

        $validator = Validator::make($data, [
            'name' => 'required|string|min:3|max:50',
            'status' => 'required|in:available,sold,pending',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.min' => 'The name must be at least 3 characters.',
            'name.max' => 'The name may not be greater than 50 characters.',
            'status.required' => 'The status field is required.',
            'status.in' => 'Invalid status. Please choose from available, sold, or pending.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $path = "pet";
        $options = [
            'json' => $data,
        ];

        try {
            $response = $this->petClient->sendRequest('PUT', $path, $options);

            if ($response->getStatusCode() === 200) {
                session()->flash('success', 'Pet updated successfully!');
                return redirect('/pets');
            } else {

                session()->flash('error', 'Failed to update pet. Please try again.');
                return redirect()->back();
            }
        } catch (RequestException $e) {
            session()->flash('error', 'Failed to make API request. Please try again.');
            return redirect()->back();
        }
    }


    public function destroy(int $petId): RedirectResponse
    {
        $path = "pet/{$petId}";

        try {
            $response = $this->petClient->sendRequest('DELETE', $path);

            if ($response->getStatusCode() === 200) {
                session()->flash('success', 'Pet deleted successfully!');
            } else {
                session()->flash('error', 'Failed to delete pet. Please try again.');
            }
        } catch (RequestException $e) {
            session()->flash('error', 'Failed to make API request. Please try again.');
        }

        return redirect()->back();
    }
}
