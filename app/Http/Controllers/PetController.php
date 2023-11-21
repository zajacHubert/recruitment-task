<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\PetRepositoryInterface;
use App\Services\Contracts\PetServiceInterface;

class PetController extends Controller
{
    private PetRepositoryInterface $petRepository;
    private PetServiceInterface $petService;

    public function __construct(PetRepositoryInterface $petRepository, PetServiceInterface $petService)
    {
        $this->petRepository = $petRepository;
        $this->petService = $petService;
    }

    public function getPetsByStatus(Request $request)
    {
        return $this->petRepository->getPetsByStatus($request);
    }

    public function show(int $id)
    {
        return $this->petRepository->show($id);
    }

    public function create()
    {
        return $this->petService->create();
    }

    public function store(Request $request)
    {
        return $this->petService->store($request);
    }

    public function edit(int $id)
    {
        return $this->petService->edit($id);
    }

    public function update(int $id, Request $request)
    {
        return $this->petService->update($id, $request);
    }

    public function destroy(int $id)
    {
        return $this->petService->destroy($id);
    }
}
