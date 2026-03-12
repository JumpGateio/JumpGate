<?php

namespace App\Filament\Resources\UserStatuses\Pages;

use App\Filament\Resources\UserStatuses\UserStatusResource;
use Filament\Resources\Pages\ListRecords;

class ListUserStatuses extends ListRecords
{
    protected static string $resource = UserStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
