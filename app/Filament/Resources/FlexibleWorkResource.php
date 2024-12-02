<?php

namespace App\Filament\Resources;

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

use Illuminate\Support\Facades\Auth;
use App\Models\Establishment;

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
                    return FlexibleWork::query()->where('created_at', '!=', null);
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
                Tables\Actions\Action::make('view-fwa')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->modalSubmitActionLabel('Done')
                    ->modalCancelAction(false)
                    ->disabledForm()
                    ->fillForm(
                        function (FlexibleWork $record): array {
                            return [
                                'fwa_startDate' => $record->fwa_startDate ,
                                'fwa_endDate' => $record->fwa_endDate ,
                                'fwa_type' => $record->fwa_type ,
                                'fwa_typeSpecify' => $record->fwa_typeSpecify ,
                                'fwa_reason' => $record->fwa_reason ,
                                'fwa_reasonSpecify' => $record->fwa_reasonSpecify ,
                                'fwa_affectedWorkers' => $record->fwa_affectedWorkers ,
                                'fwa_agreement' => $record->fwa_agreement ,
                                'fwa_owner' => $record->fwa_owner ,
                                'fwa_designation' => $record->fwa_designation ,
                                'fwa_contact' => $record->fwa_contact ,
                            ];
                        }
                    )
                    ->form([
                        Section::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\DatePicker::make('fwa_startDate')
                                    ->columnSpan(1)
                                    ->label('Start Date')
                                    ->native(false),
                                Forms\Components\DatePicker::make('fwa_endDate')
                                    ->columnSpan(1)
                                    ->label('End Date')
                                    ->native(false),
                                Forms\Components\Select::make('fwa_type')
                                    ->columnSpan(1)
                                    ->searchable()
                                    ->label('Select Type of FWA / AWS')
                                    ->native(false)
                                    ->live()
                                    ->options([
                                        'TOE' => 'Transfer of Employees to another branch of the same employer',
                                        'AOE' => 'Assignment  of Employees to ther function or position in the same or other branch or outlets of the same employer',
                                        'RWD' => 'Reduction of Workdays per week',
                                        'RWH' => 'Reduction of Workhours per day',
                                        'JR' =>'Job Rotation alternatively providing employees with work within the workweek or within the month',
                                        'PCE' =>'Partial Closure of Establishment where some unit or departments of the establishment are continued while other units or department are closed',
                                        'ROW' => 'Rotation of Workers',
                                        'FCL' => 'Forced Leave',
                                        'BTS' =>'Broken-Time Schedule',
                                        'CWW' => 'Compressed Work Week',
                                        'TWA' => 'Telecommuting Work Arrangement',
                                        'OTH' => 'Others',
                                    ]),
                                Forms\Components\TextInput::make('fwa_typeSpecify')
                                    ->columnSpan(1)
                                    ->label('Specify (Others)')
                                    ->hidden(function(Get $get){
                                        if($get('fwa_type') == 'OTH'){
                                            return false;
                                        }else{
                                            return true;
                                        }
                                    }),
                                Forms\Components\Select::make('fwa_reason')
                                    ->columnSpan(1)
                                    ->searchable()
                                    ->label('Select Primary Reason')
                                    ->native(false)
                                    ->live()
                                    ->options([
                                        'Economic Reasons' => 'Economic Reasons',
                                        'CI' => 'Competition from Imports',
                                        'CMM' => 'Change in Management/merger',
                                        'FL' => 'Financial Losses',
                                        'GR' => 'Government Regulation',
                                        'HCP' => 'High cost of Production',
                                        'LC' => 'Lack of Capital',
                                        'LM' => 'Lack of Market/ slump in demand/ cancellation of orders',
                                        'LRM' => 'Lack of raw materials',
                                        'MR' => 'Increase in minimum wage rate',
                                        'PD' => 'Peso depreciation',
                                        'UPP' => 'Incompetitive price of products Non-Economic Reasons',
                                        'INV' => 'Inventory',
                                        'NMC' => 'Natural or man-made calamity',
                                        'PC' => 'Project Completion',
                                        'RGM' => 'Repair or general maintenance',
                                        'WSO' => 'Work stoppage order/ cease and desist order',
                                        'OTH' => 'Others'
                                    ]),
                                Forms\Components\TextInput::make('fwa_reasonSpecify')
                                    ->columnSpan(1)
                                    ->label('Specify (Others)')
                                    ->hidden(function(Get $get){
                                        if($get('fwa_reason') == 'OTH'){
                                            return false;
                                        }else{
                                            return true;
                                        }
                                    }),
                            ]),
                        Section::make()
                            ->schema([
                                Forms\Components\Textarea::make('fwa_affectedWorkers')
                                    ->label('Affected Workers')
                            ])
                    ]),
            
                Tables\Actions\Action::make('edit-fwa')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->modalSubmitActionLabel('Update')
                    ->fillForm(
                        function (FlexibleWork $record): array {
                            return [
                                'fwa_startDate' => $record->fwa_startDate ,
                                'fwa_endDate' => $record->fwa_endDate ,
                                'fwa_type' => $record->fwa_type ,
                                'fwa_typeSpecify' => $record->fwa_typeSpecify ,
                                'fwa_reason' => $record->fwa_reason ,
                                'fwa_reasonSpecify' => $record->fwa_reasonSpecify ,
                                'fwa_affectedWorkers' => $record->fwa_affectedWorkers ,
                                'fwa_agreement' => $record->fwa_agreement ,
                                'fwa_owner' => $record->fwa_owner ,
                                'fwa_designation' => $record->fwa_designation ,
                                'fwa_contact' => $record->fwa_contact ,
                            ];
                        }
                    )
                    ->form([
                        Section::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\DatePicker::make('fwa_startDate')
                                    ->columnSpan(1)
                                    ->label('Start Date')
                                    ->native(false),
                                Forms\Components\DatePicker::make('fwa_endDate')
                                    ->columnSpan(1)
                                    ->label('End Date')
                                    ->native(false),
                                Forms\Components\Select::make('fwa_type')
                                    ->columnSpan(1)
                                    ->searchable()
                                    ->label('Select Type of FWA / AWS')
                                    ->native(false)
                                    ->live()
                                    ->options([
                                        'TOE' => 'Transfer of Employees to another branch of the same employer',
                                        'AOE' => 'Assignment  of Employees to ther function or position in the same or other branch or outlets of the same employer',
                                        'RWD' => 'Reduction of Workdays per week',
                                        'RWH' => 'Reduction of Workhours per day',
                                        'JR' =>'Job Rotation alternatively providing employees with work within the workweek or within the month',
                                        'PCE' =>'Partial Closure of Establishment where some unit or departments of the establishment are continued while other units or department are closed',
                                        'ROW' => 'Rotation of Workers',
                                        'FCL' => 'Forced Leave',
                                        'BTS' =>'Broken-Time Schedule',
                                        'CWW' => 'Compressed Work Week',
                                        'TWA' => 'Telecommuting Work Arrangement',
                                        'OTH' => 'Others',
                                    ]),
                                Forms\Components\TextInput::make('fwa_typeSpecify')
                                    ->columnSpan(1)
                                    ->label('Specify (Others)')
                                    ->hidden(function(Get $get){
                                        if($get('fwa_type') == 'OTH'){
                                            return false;
                                        }else{
                                            return true;
                                        }
                                    }),
                                Forms\Components\Select::make('fwa_reason')
                                    ->columnSpan(1)
                                    ->searchable()
                                    ->label('Select Primary Reason')
                                    ->native(false)
                                    ->live()
                                    ->options([
                                        'Economic Reasons' => 'Economic Reasons',
                                        'CI' => 'Competition from Imports',
                                        'CMM' => 'Change in Management/merger',
                                        'FL' => 'Financial Losses',
                                        'GR' => 'Government Regulation',
                                        'HCP' => 'High cost of Production',
                                        'LC' => 'Lack of Capital',
                                        'LM' => 'Lack of Market/ slump in demand/ cancellation of orders',
                                        'LRM' => 'Lack of raw materials',
                                        'MR' => 'Increase in minimum wage rate',
                                        'PD' => 'Peso depreciation',
                                        'UPP' => 'Incompetitive price of products Non-Economic Reasons',
                                        'INV' => 'Inventory',
                                        'NMC' => 'Natural or man-made calamity',
                                        'PC' => 'Project Completion',
                                        'RGM' => 'Repair or general maintenance',
                                        'WSO' => 'Work stoppage order/ cease and desist order',
                                        'OTH' => 'Others'
                                    ]),
                                Forms\Components\TextInput::make('fwa_reasonSpecify')
                                    ->columnSpan(1)
                                    ->label('Specify (Others)')
                                    ->hidden(function(Get $get){
                                        if($get('fwa_reason') == 'OTH'){
                                            return false;
                                        }else{
                                            return true;
                                        }
                                    }),
                            ]),
                        Section::make()
                            ->schema([
                                Forms\Components\Textarea::make('fwa_affectedWorkers')
                            ])

                    ])
                    ->action(function (array $data, FlexibleWork $record) {
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
            'index' => Pages\ListFlexibleWorks::route('/'),
            'create' => Pages\CreateFlexibleWork::route('/create'),
        ];
    }
}
