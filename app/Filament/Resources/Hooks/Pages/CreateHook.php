<?php

namespace App\Filament\Resources\Hooks\Pages;

use App\Filament\Resources\Hooks\HookResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHook extends CreateRecord
{
    protected static string $resource = HookResource::class;
}
