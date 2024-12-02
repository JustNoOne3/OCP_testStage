<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Month13thResource\Pages;
use App\Filament\Resources\Month13thResource\RelationManagers;
use App\Models\Month13th;
use App\Models\Establishment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Tabs;
use App\Filament\Exports\Month13thExporter;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Exports\Enums\ExportFormat;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;
use Filament\Forms\Set;
use Closure;
use Filament\Forms\Components\Livewire;
use App\Livewire\EmployeeTable;
use App\Livewire\EmployeeReviewTable;
use App\Models\TempEmp;
use App\Models\Employees;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Wizard;

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
                    return Month13th::query()->where('created_at', '!=', null);
                }else{
                    $est_array = Establishment::query()->where('region_id', Auth::user()->authority)->pluck('est_id');
                    return Month13th::query()->whereIn('month13th_estabId', $est_array);
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
                    ->label('< Php 5,000.00')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('month13th_fiveTen')
                    ->label('Php 5,001.00 - Php 10,000.00')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('month13th_tenTwenty')
                    ->label('Php 10,001.00 - Php 20,000.00')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('month13th_twentyThirty')
                    ->label('Php 20,001.00 - Php 30,000.00')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('month13th_thirtyForty')
                    ->label('Php 30,001.00 - Php 40,000.00')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('month13th_fortyFifty')
                    ->label('Php 40,001.00 - Php 50,000.00')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('month13th_fiftySixty')
                    ->label('Php 50,001.00 - Php 60,000.00')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('month13th_sixtySeventy')
                    ->label('Php 60,001.00 - Php 70,000.00')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('month13th_seventyEighty')
                    ->label('Php 70,001.00 - Php 80,000.00')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('month13th_eightyNinety')
                    ->label('Php 80,001.00 - Php 90,000.00')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('month13th_ninetyHundred')
                    ->label('Php 90,001.00 - Php 100,000.00')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('month13th_moreHundred')
                    ->label('> Php 100,001.00')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('view-month13th')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->modalSubmitActionLabel('Done')
                    ->modalCancelAction(false)
                    ->disabledForm()
                    ->fillForm(
                        function (Month13th $record): array {
                            return [
                                'month13th_yearCovered' => $record->month13th_yearCovered ,
                                'month13th_numWorkers' => $record->month13th_numWorkers ,
                                'month13th_amount' => $record->month13th_amount ,
                                'month13th_ownRep' => $record->month13th_ownRep ,
                                'month13th_designation' => $record->month13th_designation ,
                                'month13th_contact' => $record->month13th_contact ,
                                'month13th_lessFive' => $record->month13th_lessFive ,
                                'month13th_fiveTen' => $record->month13th_fiveTen ,
                                'month13th_tenTwenty' => $record->month13th_tenTwenty ,
                                'month13th_twentyThirty' => $record->month13th_twentyThirty ,
                                'month13th_thirtyForty' => $record->month13th_thirtyForty ,
                                'month13th_fortyFifty' => $record->month13th_fortyFifty ,
                                'month13th_fiftySixty' => $record->month13th_fiftySixty ,
                                'month13th_sixtySeventy' => $record->month13th_sixtySeventy ,
                                'month13th_seventyEighty' => $record->month13th_seventyEighty ,
                                'month13th_eightyNinety' => $record->month13th_eightyNinety ,
                                'month13th_ninetyHundred' => $record->month13th_ninetyHundred ,
                                'month13th_moreHundred' => $record->month13th_moreHundred ,
                            ];
                        }
                    )
                    ->form([
                        Section::make()
                            ->columns(3)
                            ->schema([
                                Forms\Components\TextInput::make('month13th_ownRep')
                                    ->readOnly(),
                                Forms\Components\TextInput::make('month13th_designation')
                                    ->readOnly(),
                                Forms\Components\TextInput::make('month13th_contact')
                                    ->readOnly(),
                            ]),
                        Section::make('Report Details')
                            ->columns(3)
                            ->schema([
                                Forms\Components\TextInput::make('month13th_yearCovered')
                                    ->readOnly(),
                                Forms\Components\TextInput::make('month13th_numWorkers')
                                    ->integer()
                                    ->readOnly(),
                                Forms\Components\TextInput::make('month13th_amount')
                                    ->integer()
                                    ->readOnly(),
                                
                            ]),
                        Section::make('Affect Workers')
                                        ->columns(2)
                                        ->schema([
                                            Section::make()
                                                ->columnSpan(1)
                                                ->schema([
                                                    Forms\Components\TextInput::make('month13th_lessFive')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('< Php 5,000.00'),
                                                    Forms\Components\TextInput::make('month13th_fiveTen')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 5,001.00 - Php 10,000.00'),
                                                    Forms\Components\TextInput::make('month13th_tenTwenty')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 10,001.00 - Php 20,000.00'),
                                                    Forms\Components\TextInput::make('month13th_twentyThirty')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 20,001.00 - Php 30,000.00'),
                                                    Forms\Components\TextInput::make('month13th_thirtyForty')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 30,001.00 - Php 40,000.00'),
                                                    Forms\Components\TextInput::make('month13th_fortyFifty')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 40,001.00 - Php 50,000.00'),
                                                ]),
                                            Section::make()
                                                ->columnSpan(1)
                                                ->schema([
                                                    Forms\Components\TextInput::make('month13th_fiftySixty')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 50,001.00 - Php 60,000.00'),
                                                    Forms\Components\TextInput::make('month13th_sixtySeventy')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 60,001.00 - Php 70,000.00'),
                                                    Forms\Components\TextInput::make('month13th_seventyEighty')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 70,001.00 - Php 80,000.00'),
                                                    Forms\Components\TextInput::make('month13th_eightyNinety')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 80,001.00 - Php 90,000.00'),
                                                    Forms\Components\TextInput::make('month13th_ninetyHundred')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 90,001.00 - Php 100,000.00'),
                                                    Forms\Components\TextInput::make('month13th_moreHundred')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('> Php 100,001.00'),
                                                ]),
                                        ]),
                            
                        

                    
                    ]),
                    
            
                Tables\Actions\Action::make('edit-month13th')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->modalSubmitActionLabel('Update')
                    ->fillForm(
                        function (Month13th $record): array {
                            return [
                                'month13th_yearCovered' => $record->month13th_yearCovered ,
                                'month13th_numWorkers' => $record->month13th_numWorkers ,
                                'month13th_amount' => $record->month13th_amount ,
                                'month13th_ownRep' => $record->month13th_ownRep ,
                                'month13th_designation' => $record->month13th_designation ,
                                'month13th_contact' => $record->month13th_contact ,
                                'month13th_lessFive' => $record->month13th_lessFive ,
                                'month13th_fiveTen' => $record->month13th_fiveTen ,
                                'month13th_tenTwenty' => $record->month13th_tenTwenty ,
                                'month13th_twentyThirty' => $record->month13th_twentyThirty ,
                                'month13th_thirtyForty' => $record->month13th_thirtyForty ,
                                'month13th_fortyFifty' => $record->month13th_fortyFifty ,
                                'month13th_fiftySixty' => $record->month13th_fiftySixty ,
                                'month13th_sixtySeventy' => $record->month13th_sixtySeventy ,
                                'month13th_seventyEighty' => $record->month13th_seventyEighty ,
                                'month13th_eightyNinety' => $record->month13th_eightyNinety ,
                                'month13th_ninetyHundred' => $record->month13th_ninetyHundred ,
                                'month13th_moreHundred' => $record->month13th_moreHundred ,
                            ];
                        }
                    )
                    ->form([
                        Section::make()
                            ->columns(3)
                            ->schema([
                                Forms\Components\TextInput::make('month13th_ownRep')
                                    ->readOnly(),
                                Forms\Components\TextInput::make('month13th_designation')
                                    ->readOnly(),
                                Forms\Components\TextInput::make('month13th_contact')
                                    ->readOnly(),
                            ]),
                        Section::make('Report Details')
                            ->columns(3)
                            ->schema([
                                Forms\Components\TextInput::make('month13th_yearCovered')
                                    ->readOnly(),
                                Forms\Components\TextInput::make('month13th_numWorkers')
                                    ->integer()
                                    ->readOnly(),
                                Forms\Components\TextInput::make('month13th_amount')
                                    ->integer()
                                    ->readOnly(),
                                
                            ]),
                        Section::make('Affect Workers')
                                        ->columns(2)
                                        ->schema([
                                            Section::make()
                                                ->columnSpan(1)
                                                ->schema([
                                                    Forms\Components\TextInput::make('month13th_lessFive')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('< Php 5,000.00'),
                                                    Forms\Components\TextInput::make('month13th_fiveTen')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 5,001.00 - Php 10,000.00'),
                                                    Forms\Components\TextInput::make('month13th_tenTwenty')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 10,001.00 - Php 20,000.00'),
                                                    Forms\Components\TextInput::make('month13th_twentyThirty')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 20,001.00 - Php 30,000.00'),
                                                    Forms\Components\TextInput::make('month13th_thirtyForty')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 30,001.00 - Php 40,000.00'),
                                                    Forms\Components\TextInput::make('month13th_fortyFifty')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 40,001.00 - Php 50,000.00'),
                                                ]),
                                            Section::make()
                                                ->columnSpan(1)
                                                ->schema([
                                                    Forms\Components\TextInput::make('month13th_fiftySixty')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 50,001.00 - Php 60,000.00'),
                                                    Forms\Components\TextInput::make('month13th_sixtySeventy')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 60,001.00 - Php 70,000.00'),
                                                    Forms\Components\TextInput::make('month13th_seventyEighty')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 70,001.00 - Php 80,000.00'),
                                                    Forms\Components\TextInput::make('month13th_eightyNinety')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 80,001.00 - Php 90,000.00'),
                                                    Forms\Components\TextInput::make('month13th_ninetyHundred')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('Php 90,001.00 - Php 100,000.00'),
                                                    Forms\Components\TextInput::make('month13th_moreHundred')
                                                        ->readOnly()
                                                        ->inlineLabel()
                                                        ->label('> Php 100,001.00'),
                                                ]),
                                        ]),
                            
                        

                    ])
                    ->action(function (array $data, Month13th $record) {
                        $record->update($data);
                        return 
                            Notification::make()
                                ->title('Successfully Updated the Report!')
                                ->icon('heroicon-o-document-text')
                                ->iconColor('success')
                                ->send();
                    }),
                
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
        ];
    }
}
