<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LiReportResource\Pages;
use App\Filament\Resources\LiReportResource\RelationManagers;
use App\Models\LiReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LiReportResource extends Resource
{
    protected static ?string $model = LiReport::class;

    protected static ?string $navigationGroup = 'Forms';

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $modelLabel = 'Labor Inspection Form';

    protected static ?string $pluralModelLabel = 'Labor Inspection Forms';

    protected static ?string $navigationLabel = 'Labor Inspection (LI) Forms';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('li_reportName')
                    ->maxLength(255)
                    ->label('Name of Report'),
                Forms\Components\FileUpload::make('li_reportUpload')
                    ->label('Soft Copy of Form'),
                Forms\Components\TextInput::make('li_category')
                    ->maxLength(255)
                    ->label('Report/Form Category'),
                Forms\Components\Select::make('li_region')
                    ->label('Originating Region')
                    ->searchable()
                    ->native(false)
                    ->options([
                        1300000000 => 'National Capital Region (NCR)',
                        1400000000 => 'Cordillera Administrative Region (CAR)',
                        100000000 => 'Region I (Ilocos Region)',
                        200000000 => 'Region II (Cagayan Valley)',
                        300000000 => 'Region III (Central Luzon)',
                        400000000 => 'Region IV-A (CALABARZON)',
                        1700000000 => 'MIMAROPA Region',
                        500000000 => 'Region V (Bicol Region)',
                        600000000 => 'Region VI (Western Visayas)',
                        1800000000 => 'Negros Island Region (NIR)',
                        700000000 => 'Region VII (Central Visayas)',
                        800000000 => 'Region VIII (Eastern Visayas)',
                        900000000 => 'Region IX (Zamboanga Peninsula)',
                        1000000000 => 'Region X (Northern Mindanao)',
                        1100000000 => 'Region XI (Davao Region)',
                        1200000000 => 'Region XII (SOCCSKSARGEN)',
                        1600000000 => 'Region XIII (Caraga)',
                        1900000000 => 'Bangsamoro Autonomous Region in Muslim Mindanao (BARMM)',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('li_reportName')
                    ->searchable()
                    ->label('Name of Report'),
                Tables\Columns\TextColumn::make('li_reportUpload')
                    ->searchable()
                    ->label('Form'),
                Tables\Columns\TextColumn::make('li_category')
                    ->searchable()
                    ->label('Category'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created at')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Updated at')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListLiReports::route('/'),
            'create' => Pages\CreateLiReport::route('/create'),
            'view' => Pages\ViewLiReport::route('/{record}'),
            'edit' => Pages\EditLiReport::route('/{record}/edit'),
        ];
    }
}
