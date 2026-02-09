<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\LunchSlotResource\Pages\CreateLunchSlot;
use App\Filament\Resources\LunchSlotResource\Pages\EditLunchSlot;
use App\Filament\Resources\LunchSlotResource\Pages\ListLunchSlots;
use App\Models\LunchSlot;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class LunchSlotResource extends Resource
{
    protected static ?string $model = LunchSlot::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        TimePicker::make('time')
                            ->required(),
                        TextInput::make('available')
                            ->required()
                            ->numeric()
                            ->default(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('time'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('available')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
            'index'  => ListLunchSlots::route('/'),
            'create' => CreateLunchSlot::route('/create'),
            'edit'   => EditLunchSlot::route('/{record}/edit'),
        ];
    }
}
