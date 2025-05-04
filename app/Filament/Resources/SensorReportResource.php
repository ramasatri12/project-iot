<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SensorReportResource\Pages;
use App\Filament\Resources\SensorReportResource\RelationManagers;
use App\Models\SensorReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SensorReportResource extends Resource
{
    protected static ?string $model = SensorReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Report Sensor';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('tinggi_air')
                    ->label('Ketinggian Air (cm)')
                    ->numeric()
                    ->required(),
                TextInput::make('ph')
                ->label('pH Air')
                ->numeric()
                ->required(),
                TextInput::make('debit')
                ->label('Debit Air (cm)')
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
                TextColumn::make('tinggi_air')->label('Ketinggian Air (cm)')->sortable(),
                TextColumn::make('ph')->label('pH Air (cm)')->sortable(),
                TextColumn::make('debit')->label('Debit Air (cm)')->sortable(),
                TextColumn::make('created_at')->label('Dibuat pada')->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'normal' => 'Normal',
                        'warning' => 'Warning',
                        'critical'  => 'Critical',
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
            'index' => Pages\ListSensorReports::route('/'),
        ];
    }
}
