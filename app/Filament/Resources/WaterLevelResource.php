<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WaterLevelResource\Pages;
use App\Filament\Resources\WaterLevelResource\RelationManagers;
use App\Models\WaterLevel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class WaterLevelResource extends Resource
{
    protected static ?string $model = WaterLevel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Ketinggian Air';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('height')
                    ->label('Ketinggian Air (cm)')
                    ->numeric()
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'normal' => 'Normal',
                        'warning' => 'Warning',
                        'critical' => 'Critical',
                    ])
                    ->default('normal')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('height')->label('Ketinggian Air (cm)')->sortable(),
                TextColumn::make('status')->label('Status')->badge(),
                TextColumn::make('created_at')->label('Dibuat pada')->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'normal' => 'Normal',
                        'warning' => 'Warning',
                        'critical' => 'Critical',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListWaterLevels::route('/'),
            'create' => Pages\CreateWaterLevel::route('/create'),
            'edit' => Pages\EditWaterLevel::route('/{record}/edit'),
        ];
    }
}
