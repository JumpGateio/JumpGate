<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Details')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('email'),
                        TextEntry::make('details.display_name')->label('Display Name')
                            ->columnSpan(2),
                        TextEntry::make('details.first_name')->label('First Name'),
                        TextEntry::make('details.middle_name')->label('Middle Name'),
                        TextEntry::make('details.last_name')->label('Last Name'),
                    ]),
                Section::make('Timestamps')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('created_at')->dateTime(),
                        TextEntry::make('updated_at')->dateTime(),
                        TextEntry::make('deleted_at')->dateTime(),
                    ]),
            ]);
    }
}
