<?php

namespace App\Filament\Resources\UserStatuses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserStatusForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('label')
                    ->required(),
                TextInput::make('name')
                    ->readOnly()
                    ->disabled(),
            ]);
    }
}
