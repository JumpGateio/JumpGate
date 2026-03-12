<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basics')
                    ->columns(6)
                    ->schema([
                        TextInput::make('email')
                            ->columnSpan(4),
                        Select::make('status_id')
                            ->relationship('status', 'label')
                            ->columnSpan(2),
                    ]),
                Section::make('RBAC')
                    ->columns(1)
                    ->schema([
                        Select::make('roles')
                            ->multiple()
                            ->relationship(titleAttribute: 'display_name')
                            ->preload(),
                    ]),
                Section::make('Details')
                    ->relationship('details')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('first_name')->label('First Name'),
                        TextInput::make('middle_name')->label('Middle Name'),
                        TextInput::make('last_name')->label('Last Name'),
                        TextInput::make('display_name')->label('Display Name'),
                    ]),
            ]);
    }
}
