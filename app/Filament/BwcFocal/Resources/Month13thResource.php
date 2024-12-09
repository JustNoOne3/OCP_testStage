<?php

namespace App\Filament\BwcFocal\Resources;

use App\Filament\Resources\Month13thResource\Pages;
use App\Filament\Resources\Month13thResource\RelationManagers;
use App\Models\Month13th;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Section;
use App\Filament\Exports\Month13thExporter;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Exports\Enums\ExportFormat;
use App\Models\Establishment;

class Month13thResource extends Resource
{
    protected static ?string $model = Month13th::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $modelLabel = '13th Month Report';

    protected static ?string $navigationLabel = '13th Month Reports';

    protected static ?string $navigationGroup = 'Reports';

    public static function form(Form $form): Form
    {
        return $form
            // ->query(function() {
            //     if(Auth::user()->authority == '20'){
            //         return FlexibleWork::query()->all();
            //     }else{
            //         return FlexibleWork::query()->where('region_id',Auth::user()->authority);
            //     }
            // })
            ->schema([
                Section::make()
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('month13th_yearCovered')
                            ->label('Year Covered by Report')
                            ->placeholder('Select a year covered by this report.')
                            ->options(function (){
                                $currentYear = now()->year;
                                $years = range(2019, $currentYear);
                                return $years;
                            })
                            ->native(false)
                            ->columnSpan(1)
                            ->required(),
                        Forms\Components\TextInput::make('month13th_numWorkers')
                            ->label('Total Number of Workers Benifited')
                            ->columnSpan(1)
                            ->required(),
                        Forms\Components\TextInput::make('month13th_amount')
                            ->label('Total Amount of Benefits Granted')
                            ->columnSpan(1)
                            ->required(),
                        Forms\Components\TextInput::make('month13th_ownRep')
                            ->label('Name of Employer\'s Representative')
                            ->columnSpan(1)
                            ->required(),
                        Forms\Components\TextInput::make('month13th_designation')
                            ->label('Designation ')
                            ->columnSpan(1)
                            ->required(),
                        Forms\Components\TextInput::make('month13th_contact')
                            ->label('Contact Number')
                            ->columnSpan(1)
                            ->required(),
                    ]),
                Section::make('Amount range and Number of Workers')
                    ->columns(2)
                    ->schema([
                        Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\TextInput::make('month13th_lessFive')
                                    ->label('< Php 5,000.00')
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0)
                                    ->required()
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_fiveTen')
                                    ->label('Php 5,001.00 - Php 10,000.00')
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0)
                                    ->required()
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_tenTwenty')
                                    ->label('Php 10,001.00 - Php 20,000.00')
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0)
                                    ->required()
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_twentyThirty')
                                    ->label(' Php 20,001.00 - Php 30,000.00 ')
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0)
                                    ->required()
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_thirtyForty')
                                    ->label(' Php 30,001.00 - Php 40,000.00 ')
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0)
                                    ->required()
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_fortyFifty')
                                    ->label('Php 40,001.00 - Php 50,000.00')
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0)
                                    ->required()
                                    ->inlineLabel(),
                            ]),
                        Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\TextInput::make('month13th_fiftySixty')
                                    ->label('Php 50,001.00 - Php 60,000.00')
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0)
                                    ->required()
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_sixtySeventy')
                                    ->label(' Php 60,001.00 - Php 70,000.00 ')
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0)
                                    ->required()
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_seventyEighty')
                                    ->label(' Php 70,001.00 - Php 80,000.00 ')
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0)
                                    ->required()
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_eightyNinety')
                                    ->label('Php 80,001.00 - Php 90,000.00')
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0)
                                    ->required()
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_ninetyHundred')
                                    ->label('Php 90,001.00 - Php 100,000.00')
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0)
                                    ->required()
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_moreHundred')
                                    ->label('> Php 100,001.00')
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0)
                                    ->required()
                                    ->inlineLabel(),
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function() {
                if(Auth::user()->authority == '20'){
                    return Month13th::query()->all();
                }else{
                    $est_array = Establishment::query()->where('region_id', Auth::user()->authority)->pluck('est_id');
                    return Month13th::query()->whereIn($est_array);
                }
            })
            ->columns([
                TextColumn::make('month13th_yearCovered')
                    ->label('Year Covered by Report'),
                TextColumn::make('month13th_numWorkers')
                    ->label('Number of Workers Benifited'),
                TextColumn::make('month13th_amount')
                    ->label('Total Amount of Benefits Granted'),
                TextColumn::make('month13th_ownRep')
                    ->label('Name of Employer\'s Representative')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('month13th_designation')
                    ->label('Designation')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('month13th_contact')
                    ->label('Contact Number')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('month13th_lessFive')
                    ->label('< Php 5,000.00'),
                TextColumn::make('month13th_fiveTen')
                    ->label('Php 5,001.00 - Php 10,000.00'),
                TextColumn::make('month13th_tenTwenty')
                    ->label('Php 10,001.00 - Php 20,000.00'),
                TextColumn::make('month13th_twentyThirty')
                    ->label('Php 20,001.00 - Php 30,000.00'),
                TextColumn::make('month13th_thirtyForty')
                    ->label('Php 30,001.00 - Php 40,000.00'),
                TextColumn::make('month13th_fortyFifty')
                    ->label('Php 40,001.00 - Php 50,000.00'),
                TextColumn::make('month13th_fiftySixty')
                    ->label('Php 50,001.00 - Php 60,000.00'),
                TextColumn::make('month13th_sixtySeventy')
                    ->label('Php 60,001.00 - Php 70,000.00'),
                TextColumn::make('month13th_seventyEighty')
                    ->label('Php 70,001.00 - Php 80,000.00'),
                TextColumn::make('month13th_eightyNinety')
                    ->label('Php 80,001.00 - Php 90,000.00'),
                TextColumn::make('month13th_ninetyHundred')
                    ->label('Php 90,001.00 - Php 100,000.00'),
                TextColumn::make('month13th_moreHundred')
                    ->label('> Php 100,001.00'),
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
            'index' => Pages\ListMonth13ths::route('/'),
            // 'create' => Pages\CreateMonth13th::route('/create'),
            // 'edit' => Pages\EditMonth13th::route('/{record}/edit'),
        ];
    }
}
