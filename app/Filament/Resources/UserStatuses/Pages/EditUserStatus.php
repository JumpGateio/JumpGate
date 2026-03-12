<?php

namespace App\Filament\Resources\UserStatuses\Pages;

use App\Filament\Resources\UserStatuses\UserStatusResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserStatus extends EditRecord
{
    protected static string $resource = UserStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
