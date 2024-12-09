<?php

namespace App\Filament\Focal\Resources;

use App\Filament\Resources\FlexibleWorkResource\Pages;
use App\Filament\Resources\FlexibleWorkResource\RelationManagers;
use App\Models\FlexibleWork;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;

class FlexibleWorkResource extends Resource
{
    protected static ?string $model = FlexibleWork::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    protected static ?string $modelLabel = 'FWA / FWS Reports';

    protected static ?string $navigationLabel = 'FWA / FWS Reports';

    protected static ?string $navigationGroup = 'Reports';

    protected static ?int $navigationGroupSort = 1;

    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('fwa_startDate'),
                Forms\Components\DatePicker::make('fwa_endDate'),
                Forms\Components\TextInput::make('fwa_type')
                    ->maxLength(255),
                Forms\Components\TextInput::make('fwa_typeSpecify')
                    ->maxLength(255),
                Forms\Components\TextInput::make('fwa_reason')
                    ->maxLength(255),
                Forms\Components\TextInput::make('fwa_reasonSpecify')
                    ->maxLength(255),
                Forms\Components\TextInput::make('fwa_affectedWorkers'),
                Forms\Components\TextInput::make('fwa_agreement')
                    ->maxLength(255),
                Forms\Components\TextInput::make('fwa_owner')
                    ->maxLength(255),
                Forms\Components\TextInput::make('fwa_designation')
                    ->maxLength(255),
                Forms\Components\TextInput::make('fwa_contact')
                    ->maxLength(255),
                Forms\Components\TextInput::make('fwa_estabId')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function() {
                if(Auth::user()->authority == '20'){
                    return FlexibleWork::query()->all();
                }else{
                    $est_array = Establishment::query()->where('region_id', Auth::user()->authority)->pluck('est_id');
                    return FlexibleWork::query()->whereIn('fwa_estabId', $est_array);
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('fwa_startDate')
                    ->date()
                    ->label('Start Date')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('fwa_endDate')
                    ->date()
                    ->label('End Date')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('fwa_type')
                    ->label('Type of FWA / AWS')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('fwa_typeSpecify')
                    ->label('Other Type of FWA / AWS')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('fwa_reason')
                    ->label('Reason')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('fwa_reasonSpecify')
                    ->label('Specific Reason')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('fwa_owner')
                    ->label('Name of Owner')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fwa_designation')
                    ->label('Designation')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('fwa_contact')
                    ->label('Contact Number')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(Month13thExporter::class)
                    ->label('Export to Excel')
                    ->formats([
                        ExportFormat::Xlsx,
                    ])
                    ->fileName(date('Y-m-d') . '- 13th Month Report'),
            ])
            ->emptyStateHeading('Empty')
            ->emptyStateDescription('There is no Report Data yet')
            ->emptyStateIcon('heroicon-o-bookmark');
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
            'index' => Pages\ListFlexibleWorks::route('/'),
            // 'create' => Pages\CreateFlexibleWork::route('/create'),
            // 'edit' => Pages\EditFlexibleWork::route('/{record}/edit'),
        ];
    }
}
