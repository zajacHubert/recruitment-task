<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

interface PetServiceInterface
{
    public function showAddForm(): View;
    public function create(): View;
    public function edit(int $id): View;
    public function store(Request $request): RedirectResponse;
    public function update(int $id, Request $request): RedirectResponse;
    public function destroy(int $id): RedirectResponse;
}
