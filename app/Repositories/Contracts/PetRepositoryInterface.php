<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Psr\Http\Message\ResponseInterface;

interface PetRepositoryInterface
{
    public function getPetsByStatus(Request $request): View;
    public function show(int $id): View;
    public function getPetById(int $id): ResponseInterface;
}
