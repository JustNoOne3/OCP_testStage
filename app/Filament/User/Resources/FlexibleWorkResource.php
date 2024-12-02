<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\FlexibleWorkResource\Pages;
use App\Filament\User\Resources\FlexibleWorkResource\RelationManagers;
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

// use Illuminate\Support\Facades\Auth;
use App\Models\Request;
// use App\Models\Establishment;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class FlexibleWorkResource extends Resource
{
    protected static ?string $model = FlexibleWork::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'Flexible Work Arrangement / Alternative Work Scheme';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\DatePicker::make('fwa_startDate'),
                // Forms\Components\DatePicker::make('fwa_endDate'),
                // Forms\Components\TextInput::make('fwa_type')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('fwa_typeSpecify')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('fwa_reason')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('fwa_reasonSpecify')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('fwa_affectedWorkers'),
                // Forms\Components\TextInput::make('fwa_agreement')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('fwa_owner')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('fwa_designation')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('fwa_contact')
                //     ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(fn (FlexibleWork $fwa) => $fwa
                        ->where('fwa_estabId', Auth::user()->est_id)
                    )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Report ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('fwa_startDate')
                    ->date()
                    ->label('Effectivity Date')
                    ->sortable(),
                Tables\Columns\TextColumn::make('fwa_endDate')
                    ->date()
                    ->label('End Date')
                    ->sortable(),
                Tables\Columns\TextColumn::make('fwa_type')
                    ->label('Type of FWA / AWS')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fwa_reason')
                    ->label('Cause')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
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
                Tables\Actions\Action::make('request')
                    ->label('Request for Edit')
                    ->icon('heroicon-o-chevron-double-right')
                    ->color('danger')
                    ->modalSubmitActionLabel('Request')
                    ->form([
                        Section::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('req_field')
                                    ->required()
                                    ->columnSpan(1)
                                    ->label("Field to Edit")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('req_fieldNew')
                                    ->required()
                                    ->columnSpan(1)
                                    ->label("Replace With")
                                    ->maxLength(255),
                                ]),
                        Section::make()
                            ->schema([
                                Forms\Components\Textarea::make('req_reason')
                                    ->required()
                                    ->columnSpan(2)
                                    ->label("Reason for Editing")
                                    ->maxLength(255),
                                ]),                            
                    ])
                    ->action(function (array $data, FlexibleWork $record) {
                        $uuid = Uuid::uuid4()->toString();
                        $microseconds = substr(explode('.', microtime(true))[1], 0, 6);
                        $uuid = 'req-' . substr($uuid, 0, 12) . '-' . $microseconds;

                        $est = Establishment::query()->where('est_id', Auth::user()->est_id)->first();

                        $req = Request::create([
                            'id' => $uuid,
                            'req_reportId' => $record->id,
                            'req_reportType' => 'FWA Report',
                            'req_estabId' => $record->fwa_estabId,
                            'req_estabName' => $est->est_name,
                            'req_region'  => $est->region_id,
                            'req_field' => $data['req_field'],
                            'req_fieldNew'  => $data['req_fieldNew'],
                            'req_reason'  => $data['req_reason'],
                            'req_status'  => 'Pending',
                        ]);
                        return 
                            Notification::make()
                                ->title('Successfully Sent the Request!')
                                ->icon('heroicon-o-document-text')
                                ->iconColor('success')
                                ->send();
                    }),
                
            
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
            'index' => Pages\ListFlexibleWorks::route('/'),
            'create' => Pages\CreateFlexibleWork::route('/create'),
            'edit' => Pages\EditFlexibleWork::route('/{record}/edit'),
        ];
    }
}
