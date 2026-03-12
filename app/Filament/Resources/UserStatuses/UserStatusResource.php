<?php

namespace App\Filament\Resources\UserStatuses;

use App\Filament\Resources\UserStatuses\Pages\CreateUserStatus;
use App\Filament\Resources\UserStatuses\Pages\EditUserStatus;
use App\Filament\Resources\UserStatuses\Pages\ListUserStatuses;
use App\Filament\Resources\UserStatuses\Schemas\UserStatusForm;
use App\Filament\Resources\UserStatuses\Tables\UserStatusesTable;
use App\Services\Users\Models\User\Status;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class UserStatusResource extends Resource
{
    protected static ?string $model = Status::class;

    protected static string|UnitEnum|null $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'label';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return UserStatusForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserStatusesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserStatuses::route('/'),
            'edit'  => EditUserStatus::route('/{record}/edit'),
        ];
    }
}
