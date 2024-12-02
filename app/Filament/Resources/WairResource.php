<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WairResource\Pages;
use App\Filament\Resources\WairResource\RelationManagers;
use App\Models\Wair;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Filament\Exports\Month13thExporter;
use Filament\Tables\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;

use Illuminate\Support\Facades\Auth;
use App\Models\Establishment;
use Filament\Tables\Columns\TextColumn;

use App\Models\AccidentReport;
use App\Models\IllnessReport;
use App\Models\IAReport;
use App\Models\NIAReport;
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

class WairResource extends Resource
{
    protected static ?string $model = Wair::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-exclamation';

    protected static ?string $modelLabel = 'Workplace Accident / Illness Report';

    protected static ?string $navigationLabel = 'Workplace Accident / Illness Reports';

    protected static ?string $navigationGroup = 'Reports';

    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function() {
                if(Auth::user()->authority == '20'){
                    return Wair::query()->where('created_at', '!=', null);
                }else{
                    $est_array = Establishment::query()->where('region_id', Auth::user()->authority)->pluck('est_id');
                    return Wair::query()->whereIn('wairs_estabId',$est_array);
                }
            })
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date of Submission'),
                TextColumn::make('wairs_reportType')
                    ->label('Type of Report')
                    ->toggleable(),
                TextColumn::make('wairs_estabId')
                    ->label('Name of Establishment')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => (Establishment::query()->where('est_id', $state)->value('est_name'))),
            ])
            ->filters([
                //
            ])
            ->actions([
                // accident butons
                Tables\Actions\Action::make('view-accRep')
                    ->hidden(function (Wair $record){
                        return $record->wairs_reportType != 'Accident Report';
                    })
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->modalSubmitActionLabel('Done')
                    ->modalCancelAction(false)
                    ->disabledForm()
                    ->fillForm(
                        function (Wair $wair): array {
                            $record = AccidentReport::query()->where('id', $wair->wairs_reportId)->first();
                            return  [
                                'ar_owner' => $record->ar_owner,
                                'ar_nationality'  => $record->ar_nationality ,
                                'ar_dateTime'  => $record->ar_dateTime ,
                                'ar_injury'  => $record->ar_injury ,
                                'ar_damage'  => $record->ar_damage ,
                                'ar_description'  => $record->ar_description ,
                                'ar_wasInjured'  => $record->ar_wasInjured ,
                                'ar_ntInjuredReason'  => $record->ar_ntInjuredReason ,
                                'ar_agencyInvolved'  => $record->ar_agencyInvolved ,
                                'ar_agencyPart'  => $record->ar_agencyPart ,
                                'ar_accidentType'  => $record->ar_accidentType ,
                                'ar_condition'  => $record->ar_condition ,
                                'ar_unsafeAct'  => $record->ar_unsafeAct ,
                                'ar_factor'  => $record->ar_factor ,
                                'ar_preventiveMeasure'  => $record->ar_preventiveMeasure ,
                                'ar_safeguard'  => $record->ar_safeguard ,
                                'ar_useSafeguard'  => $record->ar_useSafeguard ,
                                'ar_ntSafeguardReason'  => $record->ar_ntSafeguardReason ,
                                'ar_engineer'  => $record->ar_engineer ,
                                'ar_engineer_cost'  => $record->ar_engineer_cost ,
                                'ar_administrative'  => $record->ar_administrative ,
                                'ar_administrative_cost'  => $record->ar_administrative_cost ,
                                'ar_ppe'  => $record->ar_ppe ,
                                'ar_ppe_cost'  => $record->ar_ppe_cost ,
                                'ar_affectedWorkers'  => $record->ar_affectedWorkers ,
                                'ar_affectedWorkers_count'  => $record->ar_affectedWorkers_count ,
                                'ar_compensation'  => $record->ar_compensation ,
                                'ar_compensation_amount'  => $record->ar_compensation_amount ,
                                'ar_medical'  => $record->ar_medical ,
                                'ar_burial'  => $record->ar_burial ,
                                'ar_timeLostDay'  => $record->ar_timeLostDay ,
                                'ar_timeLostDay_hours'  => $record->ar_timeLostDay_hours ,
                                'ar_timeLostDay_mins'  => $record->ar_timeLostDay_mins ,
                                'ar_timeLostSubseq'  => $record->ar_timeLostSubseq ,
                                'ar_timeLostSubseq_hours'  => $record->ar_timeLostSubseq_hours ,
                                'ar_timeLostSubseq_mins'  => $record->ar_timeLostSubseq_mins ,
                                'ar_timeReducedOutput'  => $record->ar_timeReducedOutput ,
                                'ar_timeReducedOutput_days'  => $record->ar_timeReducedOutput_days ,
                                'ar_timeReducedOutput_percent'  => $record->ar_timeReducedOutput_percent ,
                                'ar_machineryDamage'  => $record->ar_machineryDamage ,
                                'ar_machineryDamage_repair'  => $record->ar_machineryDamage_repair ,
                                'ar_machineryDamage_time'  => $record->ar_machineryDamage_time , 
                                'ar_machineryDamage_production'  => $record->ar_machineryDamage_production ,
                                'ar_materialDamage'  => $record->ar_materialDamage ,
                                'ar_materialDamage_repair'  => $record->ar_materialDamage_repair ,
                                'ar_materialDamage_time'  => $record->ar_materialDamage_time ,
                                'ar_materialDamage_production'  => $record->ar_materialDamage_production ,
                                'ar_equipmentDamage'  => $record->ar_equipmentDamage ,
                                'ar_equipmentDamage_repair'  => $record->ar_equipmentDamage_repair ,
                                'ar_equipmentDamage_time'  => $record->ar_equipmentDamage_time ,
                                'ar_equipmentDamage_production'  => $record->ar_equipmentDamage_production ,
                                'ar_safetyOfficer'  => $record->ar_safetyOfficer ,
                                'ar_safetyOfficer_id'  => $record->ar_safetyOfficer_id ,
                                'ar_employer'  => $record->ar_employer ,
                                'ar_employer_id'  => $record->ar_employer_id ,
                            ];
                        }
                    )
                    ->form([
                        Section::make()
                            ->schema([
                                TextInput::make('ar_owner')
                                    ->required()
                                    ->label("Name of Owner"),
                                TextInput::make('ar_nationality')
                                    ->required()
                                    ->label("Nationality of Owner"),
                                ]),
                        
                        Section::make('Accident Report')
                            ->columns(2)
                            ->schema([
                                TextInput::make('ar_dateTime')
                                    ->label("Date and Time of Accident"),
                                TextInput::make('ar_injury')
                                    ->label("Personal Injury"),
                                TextInput::make('ar_damage')
                                    ->label("Property Damage"),
                                TextInput::make('ar_description')
                                    ->label("Description of Accident"),
                                TextInput::make('ar_wasInjured')
                                    ->label("Was injured doing regular part of job at time of accident?"),
                                TextInput::make('ar_ntInjuredReason')
                                    ->label("If not, why?"),
                                TextInput::make('ar_agencyInvolved')
                                    ->label("The Agency Involved "),
                                TextInput::make('ar_agencyPart')
                                    ->label("The Agency Part Involved "),
                                TextInput::make('ar_accidentType')
                                    ->label("Accident Type"),
                                TextInput::make('ar_condition')
                                    ->label("Unsafe Mechanical or Physical Condition"),
                                TextInput::make('ar_unsafeAct')
                                    ->label("The Unsafe Act"),
                                TextInput::make('ar_factor')
                                    ->label("Contributing Factor"),
                                ]),
                        Section::make('Preventive Measures')
                            ->columns(2)
                            ->schema([
                                TextInput::make('ar_preventiveMeasure')
                                    ->label("Preventive Measures (Taken or Recommended)"),
                                TextInput::make('ar_safeguard')
                                    ->label("Mechanical Guards, Personal Protective Equipment and other Safeguards"),
                                    TextInput::make('ar_useSafeguard')
                                    ->label("Were all safeguards in use?"),
                                TextInput::make('ar_ntSafeguardReason')
                                    ->label("If not, why?"),
                                Section::make('Control Instituted')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('ar_engineer')
                                            ->label("Engineering"),
                                        TextInput::make('ar_engineer_cost')
                                            ->label("Cost"),
                                        TextInput::make('ar_administrative')
                                            ->label("Administrative"),
                                        TextInput::make('ar_administrative_cost')
                                            ->label("Cost")
                                            ->integer()
                                            ->minValue(0)
                                            ->default(0),
                                        TextInput::make('ar_ppe')
                                            ->label("PPE")
                                            ->maxLength(255),
                                        TextInput::make('ar_ppe_cost')
                                            ->label("Cost"),
                                    ]),
                            ]),
                        Section::make('Affected Workers')
                            ->schema([
                                TextInput::make('ar_affectedWorkers')
                                    ->label('Workers')
                            ]),
                        Section::make('Manpower')
                            ->columns(4)
                            ->schema([
                                TextInput::make('ar_compensation')
                                    ->label("Compensation"),
                                TextInput::make('ar_compensation_amount')
                                    ->label("Compensation Amount"),
                                TextInput::make('ar_medical')
                                    ->label("Medical and Hospitalization"),
                                TextInput::make('ar_burial')
                                    ->label("Burial"),
                                TextInput::make('ar_timeLostDay')
                                    ->label("Time Lost on Day of injury"),
                                TextInput::make('ar_timeLostDay_hours')
                                    ->label("Hours:"),
                                TextInput::make('ar_timeLostDay_mins')
                                    ->label("Minutes:"),
                                TextInput::make('ar_timeLostSubseq')
                                    ->label("Time Lost on Subsequent Days"),
                                TextInput::make('ar_timeLostSubseq_hours')
                                    ->label("Hours:"),
                                TextInput::make('ar_timeLostSubseq_mins')
                                    ->label("Minutes:"),
                                TextInput::make('ar_timeReducedOutput')
                                    ->label("Time on light work or reduced output"),
                                TextInput::make('ar_timeReducedOutput_days')
                                    ->label("Days:"),
                                TextInput::make('ar_timeReducedOutput_percent')
                                    ->label("Percentage Output:"),
                            ]),
                        Section::make('Machinery and Tools')
                            ->columns(2)
                            ->aside()
                            ->schema([
                                TextInput::make('ar_machineryDamage')
                                    ->label("Damage to Machinery and Tools (Describe)"),
                                TextInput::make('ar_machineryDamage_repair')
                                    ->label("Cost of Repair or Replacement"),
                                TextInput::make('ar_machineryDamage_time')
                                    ->label("Lost Production Time (in hours)"),
                                TextInput::make('ar_machineryDamage_production')
                                    ->label("Cost of Lost production time"),
                            ]),
                        Section::make('Materials')
                            ->columns(2)
                            ->aside()
                            ->schema([
                                TextInput::make('ar_materialDamage')
                                    ->label("Damage to Materials (Describe)"),
                                TextInput::make('ar_materialDamage_repair')
                                    ->label("Cost of Repair or Replacement"),
                                TextInput::make('ar_materialDamage_time')
                                    ->label("Lost Production Time (in hours)"),
                                TextInput::make('ar_materialDamage_production')
                                    ->label("Cost of Lost production time"),
                            ]),
                        Section::make('Equipment')
                            ->columns(2)
                            ->aside()
                            ->schema([
                                TextInput::make('ar_equipmentDamage')
                                    ->label("Damage to Equipment Tools (Describe)"),
                                TextInput::make('ar_equipmentDamage_repair')
                                    ->label("Cost of Repair or Replacement"),
                                TextInput::make('ar_equipmentDamage_time')
                                    ->label("Lost Production Time (in hours)"),
                                TextInput::make('ar_equipmentDamage_production')
                                    ->label("Cost of Lost production time"),
                            ]),
                        Section::make()
                            ->schema([
                                TextInput::make('ar_safetyOfficer')
                                    ->label("OH Personnel / Safety Officer"),
                                Forms\Components\FileUpload::make('ar_safetyOfficer_id')
                                    ->previewable(true)
                                    ->label("OH Personnel / Safety Officer ID "),
                                
                            ]),
                        Section::make()
                            ->schema([
                                TextInput::make('ar_employer')
                                    ->label("Employer Name"),
                                Forms\Components\FileUpload::make('ar_employer_id')
                                    ->previewable(true)
                                    ->label("Employer ID"),
                                
                            ])


                    ])
                    ->action(function (array $data, Wair $record) {
                        return;
                    }),
                    
                Tables\Actions\Action::make('edit-accRep')
                    ->hidden(function (Wair $record){
                        return $record->wairs_reportType != 'Accident Report';
                    })
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->modalSubmitActionLabel('Update')
                    ->fillForm(
                        function (Wair $wair): array {
                            $record = AccidentReport::query()->where('id', $wair->wairs_reportId)->first();
                            return  [
                                'ar_owner' => $record->ar_owner,
                                'ar_nationality'  => $record->ar_nationality ,
                                'ar_dateTime'  => $record->ar_dateTime ,
                                'ar_injury'  => $record->ar_injury ,
                                'ar_damage'  => $record->ar_damage ,
                                'ar_description'  => $record->ar_description ,
                                'ar_wasInjured'  => $record->ar_wasInjured ,
                                'ar_ntInjuredReason'  => $record->ar_ntInjuredReason ,
                                'ar_agencyInvolved'  => $record->ar_agencyInvolved ,
                                'ar_agencyPart'  => $record->ar_agencyPart ,
                                'ar_accidentType'  => $record->ar_accidentType ,
                                'ar_condition'  => $record->ar_condition ,
                                'ar_unsafeAct'  => $record->ar_unsafeAct ,
                                'ar_factor'  => $record->ar_factor ,
                                'ar_preventiveMeasure'  => $record->ar_preventiveMeasure ,
                                'ar_safeguard'  => $record->ar_safeguard ,
                                'ar_useSafeguard'  => $record->ar_useSafeguard ,
                                'ar_ntSafeguardReason'  => $record->ar_ntSafeguardReason ,
                                'ar_engineer'  => $record->ar_engineer ,
                                'ar_engineer_cost'  => $record->ar_engineer_cost ,
                                'ar_administrative'  => $record->ar_administrative ,
                                'ar_administrative_cost'  => $record->ar_administrative_cost ,
                                'ar_ppe'  => $record->ar_ppe ,
                                'ar_ppe_cost'  => $record->ar_ppe_cost ,
                                'ar_affectedWorkers'  => $record->ar_affectedWorkers ,
                                'ar_affectedWorkers_count'  => $record->ar_affectedWorkers_count ,
                                'ar_compensation'  => $record->ar_compensation ,
                                'ar_compensation_amount'  => $record->ar_compensation_amount ,
                                'ar_medical'  => $record->ar_medical ,
                                'ar_burial'  => $record->ar_burial ,
                                'ar_timeLostDay'  => $record->ar_timeLostDay ,
                                'ar_timeLostDay_hours'  => $record->ar_timeLostDay_hours ,
                                'ar_timeLostDay_mins'  => $record->ar_timeLostDay_mins ,
                                'ar_timeLostSubseq'  => $record->ar_timeLostSubseq ,
                                'ar_timeLostSubseq_hours'  => $record->ar_timeLostSubseq_hours ,
                                'ar_timeLostSubseq_mins'  => $record->ar_timeLostSubseq_mins ,
                                'ar_timeReducedOutput'  => $record->ar_timeReducedOutput ,
                                'ar_timeReducedOutput_days'  => $record->ar_timeReducedOutput_days ,
                                'ar_timeReducedOutput_percent'  => $record->ar_timeReducedOutput_percent ,
                                'ar_machineryDamage'  => $record->ar_machineryDamage ,
                                'ar_machineryDamage_repair'  => $record->ar_machineryDamage_repair ,
                                'ar_machineryDamage_time'  => $record->ar_machineryDamage_time , 
                                'ar_machineryDamage_production'  => $record->ar_machineryDamage_production ,
                                'ar_materialDamage'  => $record->ar_materialDamage ,
                                'ar_materialDamage_repair'  => $record->ar_materialDamage_repair ,
                                'ar_materialDamage_time'  => $record->ar_materialDamage_time ,
                                'ar_materialDamage_production'  => $record->ar_materialDamage_production ,
                                'ar_equipmentDamage'  => $record->ar_equipmentDamage ,
                                'ar_equipmentDamage_repair'  => $record->ar_equipmentDamage_repair ,
                                'ar_equipmentDamage_time'  => $record->ar_equipmentDamage_time ,
                                'ar_equipmentDamage_production'  => $record->ar_equipmentDamage_production ,
                                'ar_safetyOfficer'  => $record->ar_safetyOfficer ,
                                'ar_safetyOfficer_id'  => $record->ar_safetyOfficer_id ,
                                'ar_employer'  => $record->ar_employer ,
                                'ar_employer_id'  => $record->ar_employer_id ,
                            ];
                        }
                    )
                    ->form([
                        Wizard::make([
                            Wizard\Step::make('Report Details')
                                ->schema([
                                    Section::make()
                                        ->schema([
                                            Forms\Components\TextInput::make('ar_owner')
                                                ->required()
                                                ->label("Name of Owner")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ar_nationality')
                                                ->required()
                                                ->label("Nationality of Owner")
                                                ->maxLength(255),
                                            ]),
                                        ]),
                            Wizard\Step::make('Accident')
                                ->schema([
                                    Section::make('Accident Report')
                                        ->columns(2)
                                        ->schema([
                                            Forms\Components\DateTimePicker::make('ar_dateTime')
                                                ->required()
                                                ->columnSpan(2)
                                                ->seconds(false)
                                                ->minutesStep(5)
                                                ->label("Date and Time of Accident"),
                                            Forms\Components\TextInput::make('ar_injury')
                                                ->required()
                                                ->label("Personal Injury")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ar_damage')
                                                ->required()
                                                ->label("Property Damage")
                                                ->maxLength(255),
                                            Textarea::make('ar_description')
                                                ->required()
                                                ->columnSpan(2)
                                                ->label("Description of Accident")
                                                ->placeholder('Give full details on how accident occured')
                                                ->maxLength(255),
                                            Forms\Components\Select::make('ar_wasInjured')
                                                ->required()
                                                ->native(false)
                                                ->live()
                                                ->default('Yes')
                                                ->options([
                                                    'Yes' => 'Yes',
                                                    'No' => 'No',
                                                ])
                                                ->label("Was injured doing regular part of job at time of accident?"),
                                            Forms\Components\TextInput::make('ar_ntInjuredReason')
                                                ->label("If not, why?")
                                                ->disabled(function (Get $get){
                                                    if($get('ar_wasInjured') == 'Yes'){
                                                        return true;
                                                    }else{
                                                        return false;
                                                    }
                                                })
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ar_agencyInvolved')
                                                ->required()
                                                ->label("The Agency Involved ")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ar_agencyPart')
                                                ->required()
                                                ->label("The Agency Part Involved ")
                                                ->maxLength(255),
                                            Forms\Components\Select::make('ar_accidentType')
                                                ->required()
                                                ->native(false)
                                                ->searchable() 
                                                ->options([
                                                    'Falls of persons' => 'Falls of persons',
                                                    'Falls of persons from heights' => 'Falls of persons from heights',
                                                    'Falls of persons on the same level' => 'Falls of persons on the same level',
                                                    'Struck by falling objects' => 'Struck by falling objects',
                                                    'Slides and cave-ins' => 'Slides and cave-ins',
                                                    'Collapse (buildings, walls, scaffolds, ladders, piles of goods)' => 'Collapse (buildings, walls, scaffolds, ladders, piles of goods)',
                                                    'Struck by falling objects during handling' => 'Struck by falling objects during handling',
                                                    'Struck by falling objects, not elsewhere classified' => 'Struck by falling objects, not elsewhere classified',
                                                    'Stepping on, striking against or struck by objects excluding falling objects' => 'Stepping on, striking against or struck by objects excluding falling objects',
                                                    'Stepping on objects' => 'Stepping on objects',
                                                    'Striking against stationary objects (except impacts due to a previous fall)' => 'Striking against stationary objects (except impacts due to a previous fall)',
                                                    'Striking against moving objects' => 'Striking against moving objects',
                                                    'Struck by moving objects (including flying fragments and excluding falling objects particles) Caught in or between objects' => 'Struck by moving objects (including flying fragments and excluding falling objects particles) Caught in or between objects',
                                                    'Caught in an object' => 'Caught in an object',
                                                    'Caught between a stationary object and a moving object' => 'Caught between a stationary object and a moving object',
                                                    'Caught between moving objects (except flying or falling objects)' => 'Caught between moving objects (except flying or falling objects)',
                                                    'Overexertion or strenuous movements' => 'Overexertion or strenuous movements',
                                                    'Overexertion in lifting objects' => 'Overexertion in lifting objects',
                                                    'Overexertion in pushing or pulling objects' => 'Overexertion in pushing or pulling objects',
                                                    'Overexertion in handling or throwing objects' => 'Overexertion in handling or throwing objects',
                                                    'Strenuous movements' => 'Strenuous movements',
                                                    'Exposure to or contact with extreme temperatures' => 'Exposure to or contact with extreme temperatures',
                                                    'Exposure to heat (atmosphere or environment)' => 'Exposure to heat (atmosphere or environment)',
                                                    'Exposure to cold (atmosphere or environment) Contact with hot substances or objects' => 'Exposure to cold (atmosphere or environment) Contact with hot substances or objects',
                                                    'Contact with very cold substances or objects' => 'Contact with very cold substances or objects',
                                                    'Exposure to or contact with electric current' => 'Exposure to or contact with electric current',
                                                    'Exposure to or contact with harmful substances or radiations' => 'Exposure to or contact with harmful substances or radiations',
                                                    'Contact by inhalation, ingestion or absorption of harmful substances' => 'Contact by inhalation, ingestion or absorption of harmful substances',
                                                    'Exposure to ionizing radiations' => 'Exposure to ionizing radiations',
                                                    'Exposure to radiations other than ionizing radiations' => 'Exposure to radiations other than ionizing radiations',
                                                    'Other types of accident, not elsewhere classified, including accidents not classified for lack of sufficient data' => 'Other types of accident, not elsewhere classified, including accidents not classified for lack of sufficient data',
                                                    'Other types of accident, not elsewhere classified' => 'Other types of accident, not elsewhere classified',
                                                    'Accidents not classified for lack of sufficient data' => 'Accidents not classified for lack of sufficient data',
                                                ])
                                                ->label("Accident Type"),
                                            Forms\Components\TextInput::make('ar_condition')
                                                ->required()
                                                ->label("Unsafe Mechanical or Physical Condition")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ar_unsafeAct')
                                                ->required()
                                                ->label("The Unsafe Act")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ar_factor')
                                                ->required()
                                                ->label("Contributing Factor")
                                                ->maxLength(255),
                                            ]),
                                    Section::make('Preventive Measures')
                                        ->columns(2)
                                        ->schema([
                                            Forms\Components\TextArea::make('ar_preventiveMeasure')
                                                ->required()
                                                ->label("Preventive Measures (Taken or Recommended)")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ar_safeguard')
                                                ->required()
                                                ->label("Mechanical Guards, Personal Protective Equipment and other Safeguards")
                                                ->maxLength(255),
                                            Forms\Components\Select::make('ar_useSafeguard')
                                                ->required()
                                                ->label("Were all safeguards in use?")
                                                ->live()
                                                ->native(false)
                                                ->options([
                                                    'Yes' => 'Yes',
                                                    'No' => 'No',
                                                ]),
                                            Forms\Components\TextInput::make('ar_ntSafeguardReason')
                                                ->label("If not, why?")
                                                ->maxLength(255)
                                                ->live()
                                                ->disabled(function(Get $get){
                                                    if($get('ar_useSafeguard') == 'No'){
                                                        return false;
                                                    }
                                                    return true;
                                                }),
                                            Section::make('Control Instituted')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('ar_engineer')
                                                        ->required()
                                                        ->label("Engineering")
                                                        ->maxLength(255),
                                                    Forms\Components\TextInput::make('ar_engineer_cost')
                                                        ->required()
                                                        ->label("Cost")
                                                        ->integer()
                                                        ->minValue(0)
                                                        ->default(0),
                                                    Forms\Components\TextInput::make('ar_administrative')
                                                        ->required()
                                                        ->label("Administrative")
                                                        ->maxLength(255),
                                                    Forms\Components\TextInput::make('ar_administrative_cost')
                                                        ->required()
                                                        ->label("Cost")
                                                        ->integer()
                                                        ->minValue(0)
                                                        ->default(0),
                                                    Forms\Components\TextInput::make('ar_ppe')
                                                        ->required()
                                                        ->label("PPE")
                                                        ->maxLength(255),
                                                    Forms\Components\TextInput::make('ar_ppe_cost')
                                                        ->required()
                                                        ->label("Cost")
                                                        ->integer()
                                                        ->minValue(0)
                                                        ->default(0),
                                                ]),
                                        ]),
                                ]),
                            Wizard\Step::make('Workers')
                                ->schema([
                                    Section::make('Affected Workers')
                                        ->schema([
                                            TextInput::make('ar_affectedWorkers')
                                                ->label('Workers')
                                        ]),
                                    Section::make('Manpower')
                                        ->columns(4)
                                        ->schema([
                                            Forms\Components\TextInput::make('ar_compensation')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Compensation")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ar_compensation_amount')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Compensation Amount")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ar_medical')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Medical and Hospitalization")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ar_burial')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Burial")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ar_timeLostDay')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Time Lost on Day of injury")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ar_timeLostDay_hours')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Hours:")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ar_timeLostDay_mins')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Minutes:")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ar_timeLostSubseq')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Time Lost on Subsequent Days")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ar_timeLostSubseq_hours')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Hours:")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ar_timeLostSubseq_mins')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Minutes:")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ar_timeReducedOutput')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Time on light work or reduced output")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ar_timeReducedOutput_days')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Days:")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ar_timeReducedOutput_percent')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Percentage Output:")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                        ]),
                                ]),
                            Wizard\Step::make('Equipment')
                                ->schema([
                                    Section::make('Machinery and Tools')
                                        ->columns(2)
                                        ->aside()
                                        ->schema([
                                            Forms\Components\TextArea::make('ar_machineryDamage')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Damage to Machinery and Tools (Describe)")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ar_machineryDamage_repair')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Cost of Repair or Replacement")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ar_machineryDamage_time')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Lost Production Time (in hours)")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ar_machineryDamage_production')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Cost of Lost production time")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                        ]),
                                    Section::make('Materials')
                                        ->columns(2)
                                        ->aside()
                                        ->schema([
                                            Forms\Components\TextArea::make('ar_materialDamage')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Damage to Materials (Describe)")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ar_materialDamage_repair')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Cost of Repair or Replacement")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ar_materialDamage_time')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Lost Production Time (in hours)")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ar_materialDamage_production')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Cost of Lost production time")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                        ]),
                                    Section::make('Equipment')
                                        ->columns(2)
                                        ->aside()
                                        ->schema([
                                            Forms\Components\TextArea::make('ar_equipmentDamage')
                                                ->columnSpan(2 )
                                                ->required()
                                                ->label("Damage to Equipment Tools (Describe)")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ar_equipmentDamage_repair')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Cost of Repair or Replacement")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ar_equipmentDamage_time')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Lost Production Time (in hours)")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ar_equipmentDamage_production')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Cost of Lost production time")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                        ]),
                                ]),
                            Wizard\Step::make('Certify')
                                ->columns(2)
                                ->schema([
                                    Section::make()
                                        ->schema([
                                            Forms\Components\TextInput::make('ar_safetyOfficer')
                                                ->required()
                                                ->label("OH Personnel / Safety Officer")
                                                ->maxLength(255),
                                            Forms\Components\FileUpload::make('ar_safetyOfficer_id')
                                                ->required()
                                                ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                                                ->label("OH Personnel / Safety Officer ID "),
                                            
                                        ]),
                                    Section::make()
                                        ->description(fn():Htmlable => new HtmlString("
                                                <div style=\"color: gray; font-size: 12px;\">Max File Size: 10mb</div>
                                                <div style=\"color: gray; font-size: 12px;\">Accepted File Types</div>
                                                <div style=\"color: gray; font-size: 12px;\">&nbsp; - PDF</div>
                                                <div style=\"color: gray; font-size: 12px;\">&nbsp; - JPEG</div>
                                                <div style=\"color: gray; font-size: 12px;\">&nbsp; - PNG</div>
                                            ")
                                        )
                                        ->schema([
                                            Forms\Components\TextInput::make('ar_employer')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Employer Name")
                                                ->maxLength(255),
                                            Forms\Components\FileUpload::make('ar_employer_id')
                                                ->required()
                                                ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                                                ->label("Employer ID"),
                                            
                                        ])
                                    
                                ]),
                        
                        ])

                    ])
                    ->action(function (array $data, Wair $wair) {
                        $record = AccidentReport::query()->where('id', $wair->wairs_reportId)->first();
                        $record->update($data);
                        return 
                            Notification::make()
                                ->title('Successfully Updated the Report!')
                                ->icon('heroicon-o-document-text')
                                ->iconColor('success')
                                ->send();
                    }),
                
                // Illness buttons
                Tables\Actions\Action::make('view-illRep')
                    ->hidden(function (Wair $record){
                        return $record->wairs_reportType != 'Illness Report';
                    })
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->modalSubmitActionLabel('Done')
                    ->modalCancelAction(false)
                    ->disabledForm()
                    ->fillForm(
                        function (Wair $wair): array {
                            $record = IllnessReport::query()->where('id', $wair->wairs_reportId)->first();
                            return [
                                'ip_owner' => $record->ip_owner,
                                'ip_nationality' => $record->ip_nationality,
                                'ip_engineering' => $record->ip_engineering,
                                'ip_engineering_cost' => $record->ip_engineering_cost,
                                'ip_administrative' => $record->ip_administrative,
                                'ip_administrative_cost' => $record->ip_administrative_cost,
                                'ip_ppe' => $record->ip_ppe,
                                'ip_ppe_cost' => $record->ip_ppe_cost,
                                'ip_safetyOfficer' => $record->ip_safetyOfficer,
                                'ip_safetyOfficer_id' => $record->ip_safetyOfficer_id,
                                'ip_employer' => $record->ip_employer,
                                'ip_employer_id' => $record->ip_employer_id,
                                'ip_affectedWorkers' => $record->ip_affectedWorkers,
                                'ip_affectedWorkers_count' => $record->ip_affectedWorkers_count,
                            ];
                        }
                    )
                    ->form([
                        Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('ip_owner')
                                    ->required()
                                    ->label("Name of Owner")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ip_nationality')
                                    ->required()
                                    ->label("Nationality of Owner")
                                    ->maxLength(255),
                                ]),
                        Section::make('Preventive Measres')
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('ip_engineering')
                                    ->required()
                                    ->label("Engineering")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ip_engineering_cost')
                                    ->required()
                                    ->label("Cost")
                                    ->integer(),
                                Forms\Components\TextInput::make('ip_administrative')
                                    ->required()
                                    ->label("Administrative")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ip_administrative_cost')
                                    ->required()
                                    ->label("Cost")
                                    ->integer(),
                                Forms\Components\TextInput::make('ip_ppe')
                                    ->required()
                                    ->label("PPE")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ip_ppe_cost')
                                    ->required()
                                    ->label("Cost")
                                    ->integer(),
                            ]),
                        Section::make('Affected Workers')
                            ->schema([
                                Forms\Components\TextInput::make('ip_affectedWorkers')
                                    ->label("Workers"),
                            ]),
                        Section::make('Certify')
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('ip_safetyOfficer')
                                    ->required()
                                    ->label("OH Personnel / Safety Officer")
                                    ->maxLength(255),
                                Forms\Components\FileUpload::make('ip_safetyOfficer_id')
                                    ->required()
                                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                                    ->label("OH Personnel / Safety Officer ID "),
                                Forms\Components\TextInput::make('ip_employer')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label("Employer Name")
                                    ->maxLength(255),
                                Forms\Components\FileUpload::make('ip_employer_id')
                                    ->required()
                                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                                    ->label("Employer ID"),
                            ]),
                    ]),
            
                Tables\Actions\Action::make('edit-illRep')
                    ->hidden(function (Wair $record){
                        return $record->wairs_reportType != 'Illness Report';
                    })
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->modalSubmitActionLabel('Update')
                    ->fillForm(
                        function (Wair $wair): array {
                            $record = IllnessReport::query()->where('id', $wair->wairs_reportId)->first();
                            return [
                                'ip_owner' => $record->ip_owner,
                                'ip_nationality' => $record->ip_nationality,
                                'ip_engineering' => $record->ip_engineering,
                                'ip_engineering_cost' => $record->ip_engineering_cost,
                                'ip_administrative' => $record->ip_administrative,
                                'ip_administrative_cost' => $record->ip_administrative_cost,
                                'ip_ppe' => $record->ip_ppe,
                                'ip_ppe_cost' => $record->ip_ppe_cost,
                                'ip_safetyOfficer' => $record->ip_safetyOfficer,
                                'ip_safetyOfficer_id' => $record->ip_safetyOfficer_id,
                                'ip_employer' => $record->ip_employer,
                                'ip_employer_id' => $record->ip_employer_id,
                                'ip_affectedWorkers' => $record->ip_affectedWorkers,
                                'ip_affectedWorkers_count' => $record->ip_affectedWorkers_count,
                            ];
                        }
                    )
                    ->form([
                        Wizard::make([
                            Wizard\Step::make('Report Details')
                                ->schema([
                                    Section::make()
                                        ->schema([
                                            Forms\Components\TextInput::make('ip_owner')
                                                ->required()
                                                ->label("Name of Owner")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ip_nationality')
                                                ->required()
                                                ->label("Nationality of Owner")
                                                ->maxLength(255),
                                            ]),
                                    Section::make('Preventive Measres')
                                        ->columns(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('ip_engineering')
                                                ->required()
                                                ->label("Engineering")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ip_engineering_cost')
                                                ->required()
                                                ->label("Cost")
                                                ->integer(),
                                            Forms\Components\TextInput::make('ip_administrative')
                                                ->required()
                                                ->label("Administrative")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ip_administrative_cost')
                                                ->required()
                                                ->label("Cost")
                                                ->integer(),
                                            Forms\Components\TextInput::make('ip_ppe')
                                                ->required()
                                                ->label("PPE")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ip_ppe_cost')
                                                ->required()
                                                ->label("Cost")
                                                ->integer(),
                                        ]),
                                ]),
                            Wizard\Step::make('Affected Workers')
                                ->schema([
                                    Section::make('Affected Workers')
                                        ->description(fn():Htmlable => new HtmlString("
                                                <div style=\"color: gray; font-size: 12px;\">Instructions:</div>
                                                <div style=\"color: gray; font-size: 12px; margin-left: 5px;\">1. Check the Employees to be Selected</div>
                                                <div style=\"color: gray; font-size: 12px; margin-left: 5px;\">2. Click the button 'ADD SELECTED'</div>
                                            ")
                                        )
                                        ->schema([
                                            Livewire::make(EmployeeTable::class)
                                                ->key('employee-table-3'),
                                        ]),
                                ]),
                            Wizard\Step::make('Certify')
                                ->columns(2)
                                ->schema([
                                    Forms\Components\TextInput::make('ip_safetyOfficer')
                                        ->required()
                                        ->label("OH Personnel / Safety Officer")
                                        ->maxLength(255),
                                    Forms\Components\FileUpload::make('ip_safetyOfficer_id')
                                        ->required()
                                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                                        ->label("OH Personnel / Safety Officer ID "),
                                    Forms\Components\TextInput::make('ip_employer')
                                        ->columnSpan(1)
                                        ->required()
                                        ->label("Employer Name")
                                        ->maxLength(255),
                                    Forms\Components\FileUpload::make('ip_employer_id')
                                        ->required()
                                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                                        ->label("Employer ID"),
                                ]),
                            
                        ])

                    ])
                    ->action(function (array $data, Wair $wair) {
                        $record = IllnessReport::query()->where('id', $wair->wairs_reportId)->first();
                        $record->update($data);
                        return 
                            Notification::make()
                                ->title('Successfully Updated the Report!')
                                ->icon('heroicon-o-document-text')
                                ->iconColor('success')
                                ->send();
                    }),
                // accident and illness button
                Tables\Actions\Action::make('view-iaRep')
                    ->hidden(function (Wair $record){
                        return $record->wairs_reportType != 'Accident and Illness Report';
                    })
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->modalSubmitActionLabel('Done')
                    ->modalCancelAction(false)
                    ->disabledForm()
                    ->fillForm(
                        function (Wair $wair): array {
                            $record = IAReport::query()->where('id', $wair->wairs_reportId)->first();
                            return [
                                'ia_owner' => $record->ia_owner ,
                                'ia_nationality' => $record->ia_nationality ,
                                'ia_dateTime' => $record->ia_dateTime ,
                                'ia_injury' => $record->ia_injury ,
                                'ia_damage' => $record->ia_damage ,
                                'ia_description' => $record->ia_description ,
                                'ia_wasInjured' => $record->ia_wasInjured ,
                                'ia_ntInjuredReason' => $record->ia_ntInjuredReason ,
                                'ia_agencyInvolved' => $record->ia_agencyInvolved ,
                                'ia_agencyPart' => $record->ia_agencyPart ,
                                'ia_accidentType' => $record->ia_accidentType ,
                                'ia_condition' => $record->ia_condition ,
                                'ia_unsafeAct' => $record->ia_unsafeAct ,
                                'ia_factor' => $record->ia_factor ,
                                'ia_preventiveMeasure' => $record->ia_preventiveMeasure ,
                                'ia_safeguard' => $record->ia_safeguard ,
                                'ia_useSafeguard' => $record->ia_useSafeguard ,
                                'ia_ntSafeguardReason' => $record->ia_ntSafeguardReason ,
                                'ia_affectedWorkers' => $record->ia_affectedWorkers ,
                                'ia_affectedWorkers_count' => $record->ia_affectedWorkers_count ,
                                'ia_compensation' => $record->ia_compensation ,
                                'ia_compensation_amount' => $record->ia_compensation_amount ,
                                'ia_medical' => $record->ia_medical ,
                                'ia_burial' => $record->ia_burial ,
                                'ia_timeLostDay' => $record->ia_timeLostDay ,
                                'ia_timeLostDay_hours' => $record->ia_timeLostDay_hours ,
                                'ia_timeLostDay_mins' => $record->ia_timeLostDay_mins ,
                                'ia_timeLostSubseq' => $record->ia_timeLostSubseq ,
                                'ia_timeLostSubseq_hours' => $record->ia_timeLostSubseq_hours ,
                                'ia_timeLostSubseq_mins' => $record->ia_timeLostSubseq_mins ,
                                'ia_timeReducedOutput' => $record->ia_timeReducedOutput ,
                                'ia_timeReducedOutput_days' => $record->ia_timeReducedOutput_days ,
                                'ia_timeReducedOutput_percent' => $record->ia_timeReducedOutput_percent ,
                                'ia_machineryDamage' => $record->ia_machineryDamage ,
                                'ia_machineryDamage_repair' => $record->ia_machineryDamage_repair ,
                                'ia_machineryDamage_time' => $record->ia_machineryDamage_time , 
                                'ia_machineryDamage_production' => $record->ia_machineryDamage_production ,
                                'ia_materialDamage' => $record->ia_materialDamage ,
                                'ia_materialDamage_repair' => $record->ia_materialDamage_repair ,
                                'ia_materialDamage_time' => $record->ia_materialDamage_time ,
                                'ia_materialDamage_production' => $record->ia_materialDamage_production ,
                                'ia_equipmentDamage' => $record->ia_equipmentDamage ,
                                'ia_equipmentDamage_repair' => $record->ia_equipmentDamage_repair ,
                                'ia_equipmentDamage_time' => $record->ia_equipmentDamage_time ,
                                'ia_equipmentDamage_production' => $record->ia_equipmentDamage_production ,
                                'ia_safetyOfficer' => $record->ia_safetyOfficer ,
                                'ia_safetyOfficer_id' => $record->ia_safetyOfficer_id ,
                                'ia_employer' => $record->ia_employer ,
                                'ia_employer_id' => $record->ia_employer_id ,
                            ];
                        }
                    )
                    ->form([
                        Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('ia_owner')
                                    ->required()
                                    ->label("Name of Owner")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ia_nationality')
                                    ->required()
                                    ->label("Nationality of Owner")
                                    ->maxLength(255),
                                ]),
                        Section::make('Accident Report')
                            ->columns(2)
                            ->schema([
                                Forms\Components\DateTimePicker::make('ia_dateTime')
                                    ->required()
                                    ->columnSpan(2)
                                    ->seconds(false)
                                    ->minutesStep(5)
                                    ->label("Date and Time of Accident"),
                                Forms\Components\TextInput::make('ia_injury')
                                    ->required()
                                    ->label("Personal Injury")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ia_damage')
                                    ->required()
                                    ->label("Property Damage")
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('ia_description')
                                    ->required()
                                    ->columnSpan(2)
                                    ->label("Description of Accident")
                                    ->placeholder('Give full details on how accident occured')
                                    ->maxLength(255),
                                Forms\Components\Select::make('ia_wasInjured')
                                    ->required()
                                    ->native(false)
                                    ->live()
                                    ->default('Yes')
                                    ->options([
                                        'Yes' => 'Yes',
                                        'No' => 'No',
                                    ])
                                    ->label("Was injured doing regular part of job at time of accident?"),
                                Forms\Components\TextInput::make('ia_ntInjuredReason')
                                    ->label("If not, why?")
                                    ->disabled(function (Get $get){
                                        if($get('ia_wasInjured') == 'Yes'){
                                            return true;
                                        }else{
                                            return false;
                                        }
                                    })
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ia_agencyInvolved')
                                    ->required()
                                    ->label("The Agency Involved ")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ia_agencyPart')
                                    ->required()
                                    ->label("The Agency Part Involved ")
                                    ->maxLength(255),
                                Forms\Components\Select::make('ia_accidentType')
                                    ->required()
                                    ->native(false)
                                    ->searchable() 
                                    ->options([
                                        'Falls of persons' => 'Falls of persons',
                                        'Falls of persons from heights' => 'Falls of persons from heights',
                                        'Falls of persons on the same level' => 'Falls of persons on the same level',
                                        'Struck by falling objects' => 'Struck by falling objects',
                                        'Slides and cave-ins' => 'Slides and cave-ins',
                                        'Collapse (buildings, walls, scaffolds, ladders, piles of goods)' => 'Collapse (buildings, walls, scaffolds, ladders, piles of goods)',
                                        'Struck by falling objects during handling' => 'Struck by falling objects during handling',
                                        'Struck by falling objects, not elsewhere classified' => 'Struck by falling objects, not elsewhere classified',
                                        'Stepping on, striking against or struck by objects excluding falling objects' => 'Stepping on, striking against or struck by objects excluding falling objects',
                                        'Stepping on objects' => 'Stepping on objects',
                                        'Striking against stationary objects (except impacts due to a previous fall)' => 'Striking against stationary objects (except impacts due to a previous fall)',
                                        'Striking against moving objects' => 'Striking against moving objects',
                                        'Struck by moving objects (including flying fragments and excluding falling objects particles) Caught in or between objects' => 'Struck by moving objects (including flying fragments and excluding falling objects particles) Caught in or between objects',
                                        'Caught in an object' => 'Caught in an object',
                                        'Caught between a stationary object and a moving object' => 'Caught between a stationary object and a moving object',
                                        'Caught between moving objects (except flying or falling objects)' => 'Caught between moving objects (except flying or falling objects)',
                                        'Overexertion or strenuous movements' => 'Overexertion or strenuous movements',
                                        'Overexertion in lifting objects' => 'Overexertion in lifting objects',
                                        'Overexertion in pushing or pulling objects' => 'Overexertion in pushing or pulling objects',
                                        'Overexertion in handling or throwing objects' => 'Overexertion in handling or throwing objects',
                                        'Strenuous movements' => 'Strenuous movements',
                                        'Exposure to or contact with extreme temperatures' => 'Exposure to or contact with extreme temperatures',
                                        'Exposure to heat (atmosphere or environment)' => 'Exposure to heat (atmosphere or environment)',
                                        'Exposure to cold (atmosphere or environment) Contact with hot substances or objects' => 'Exposure to cold (atmosphere or environment) Contact with hot substances or objects',
                                        'Contact with very cold substances or objects' => 'Contact with very cold substances or objects',
                                        'Exposure to or contact with electric current' => 'Exposure to or contact with electric current',
                                        'Exposure to or contact with harmful substances or radiations' => 'Exposure to or contact with harmful substances or radiations',
                                        'Contact by inhalation, ingestion or absorption of harmful substances' => 'Contact by inhalation, ingestion or absorption of harmful substances',
                                        'Exposure to ionizing radiations' => 'Exposure to ionizing radiations',
                                        'Exposure to radiations other than ionizing radiations' => 'Exposure to radiations other than ionizing radiations',
                                        'Other types of accident, not elsewhere classified, including accidents not classified for lack of sufficient data' => 'Other types of accident, not elsewhere classified, including accidents not classified for lack of sufficient data',
                                        'Other types of accident, not elsewhere classified' => 'Other types of accident, not elsewhere classified',
                                        'Accidents not classified for lack of sufficient data' => 'Accidents not classified for lack of sufficient data',
                                    ])
                                    ->label("Accident Type"),
                                Forms\Components\TextInput::make('ia_condition')
                                    ->required()
                                    ->label("Unsafe Mechanical or Physical Condition")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ia_unsafeAct')
                                    ->required()
                                    ->label("The Unsafe Act")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ia_factor')
                                    ->required()
                                    ->label("Contributing Factor")
                                    ->maxLength(255),
                                ]),
                        Section::make('Preventive Measures')
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextArea::make('ia_preventiveMeasure')
                                    ->required()
                                    ->label("Preventive Measures (Taken or Recommended)")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ia_safeguard')
                                    ->required()
                                    ->label("Mechanical Guards, Personal Protective Equipment and other Safeguards")
                                    ->maxLength(255),
                                Forms\Components\Select::make('ia_useSafeguard')
                                    ->required()
                                    ->label("Were all safeguards in use?")
                                    ->live()
                                    ->native(false)
                                    ->options([
                                        'Yes' => 'Yes',
                                        'No' => 'No',
                                    ]),
                                Forms\Components\TextInput::make('ia_ntSafeguardReason')
                                    ->label("If not, why?")
                                    ->maxLength(255)
                                    ->live()
                                    ->disabled(function(Get $get){
                                        if($get('ia_useSafeguard') == 'No'){
                                            return false;
                                        }
                                        return true;
                                    }),
                            ]),
                    
                        Section::make('Affected Workers')
                            ->schema([
                                TextInput::make('ia_affectedWorkers')
                                    ->label('Workers'),
                            ]),
                        Section::make('Manpower')
                            ->columns(4)
                            ->schema([
                                Forms\Components\TextInput::make('ia_compensation')
                                    ->columnSpan(2)
                                    ->required()
                                    ->label("Compensation")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ia_compensation_amount')
                                    ->columnSpan(2)
                                    ->required()
                                    ->label("Compensation Amount")
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                                Forms\Components\TextInput::make('ia_medical')
                                    ->columnSpan(2)
                                    ->required()
                                    ->label("Medical and Hospitalization")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ia_burial')
                                    ->columnSpan(2)
                                    ->required()
                                    ->label("Burial")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ia_timeLostDay')
                                    ->columnSpan(2)
                                    ->required()
                                    ->label("Time Lost on Day of injury")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ia_timeLostDay_hours')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label("Hours:")
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                                Forms\Components\TextInput::make('ia_timeLostDay_mins')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label("Minutes:")
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                                Forms\Components\TextInput::make('ia_timeLostSubseq')
                                    ->columnSpan(2)
                                    ->required()
                                    ->label("Time Lost on Subsequent Days")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ia_timeLostSubseq_hours')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label("Hours:")
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                                Forms\Components\TextInput::make('ia_timeLostSubseq_mins')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label("Minutes:")
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                                Forms\Components\TextInput::make('ia_timeReducedOutput')
                                    ->columnSpan(2)
                                    ->required()
                                    ->label("Time on light work or reduced output")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ia_timeReducedOutput_days')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label("Days:")
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                                Forms\Components\TextInput::make('ia_timeReducedOutput_percent')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label("Percentage Output:")
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                            ]),
                        
                    
                        Section::make('Machinery and Tools')
                            ->columns(2)
                            ->aside()
                            ->schema([
                                Forms\Components\TextArea::make('ia_machineryDamage')
                                    ->columnSpan(2)
                                    ->required()
                                    ->label("Damage to Machinery and Tools (Describe)")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ia_machineryDamage_repair')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label("Cost of Repair or Replacement")
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                                Forms\Components\TextInput::make('ia_machineryDamage_time')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label("Lost Production Time (in hours)")
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                                Forms\Components\TextInput::make('ia_machineryDamage_production')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label("Cost of Lost production time")
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                            ]),
                        Section::make('Materials')
                            ->columns(2)
                            ->aside()
                            ->schema([
                                Forms\Components\TextArea::make('ia_materialDamage')
                                    ->columnSpan(2)
                                    ->required()
                                    ->label("Damage to Materials (Describe)")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ia_materialDamage_repair')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label("Cost of Repair or Replacement")
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                                Forms\Components\TextInput::make('ia_materialDamage_time')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label("Lost Production Time (in hours)")
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                                Forms\Components\TextInput::make('ia_materialDamage_production')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label("Cost of Lost production time")
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                            ]),
                        Section::make('Equipment')
                            ->columns(2)
                            ->aside()
                            ->schema([
                                Forms\Components\TextArea::make('ia_equipmentDamage')
                                    ->columnSpan(2 )
                                    ->required()
                                    ->label("Damage to Equipment Tools (Describe)")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ia_equipmentDamage_repair')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label("Cost of Repair or Replacement")
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                                Forms\Components\TextInput::make('ia_equipmentDamage_time')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label("Lost Production Time (in hours)")
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                                Forms\Components\TextInput::make('ia_equipmentDamage_production')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label("Cost of Lost production time")
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                            ]),
                        
                        Section::make('Certify')
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('ia_safetyOfficer')
                                    ->required()
                                    ->label("OH Personnel / Safety Officer")
                                    ->maxLength(255),
                                Forms\Components\FileUpload::make('ia_safetyOfficer_id')
                                    ->required()
                                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                                    ->label("OH Personnel / Safety Officer ID "),
                                Forms\Components\TextInput::make('ia_employer')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label("Employer Name")
                                    ->maxLength(255),
                                Forms\Components\FileUpload::make('ia_employer_id')
                                    ->required()
                                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                                    ->label("Employer ID"),
                            ]),
                    ]),
            
                Tables\Actions\Action::make('edit-iaRep')
                    ->hidden(function (Wair $record){
                        return $record->wairs_reportType != 'Accident and Illness Report';
                    })
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->modalSubmitActionLabel('Update')
                    ->fillForm(
                        function (Wair $wair): array {
                            $record = IAReport::query()->where('id', $wair->wairs_reportId)->first();
                            return [
                                'ia_owner' => $record->ia_owner ,
                                'ia_nationality' => $record->ia_nationality ,
                                'ia_dateTime' => $record->ia_dateTime ,
                                'ia_injury' => $record->ia_injury ,
                                'ia_damage' => $record->ia_damage ,
                                'ia_description' => $record->ia_description ,
                                'ia_wasInjured' => $record->ia_wasInjured ,
                                'ia_ntInjuredReason' => $record->ia_ntInjuredReason ,
                                'ia_agencyInvolved' => $record->ia_agencyInvolved ,
                                'ia_agencyPart' => $record->ia_agencyPart ,
                                'ia_accidentType' => $record->ia_accidentType ,
                                'ia_condition' => $record->ia_condition ,
                                'ia_unsafeAct' => $record->ia_unsafeAct ,
                                'ia_factor' => $record->ia_factor ,
                                'ia_preventiveMeasure' => $record->ia_preventiveMeasure ,
                                'ia_safeguard' => $record->ia_safeguard ,
                                'ia_useSafeguard' => $record->ia_useSafeguard ,
                                'ia_ntSafeguardReason' => $record->ia_ntSafeguardReason ,
                                'ia_affectedWorkers' => $record->ia_affectedWorkers ,
                                'ia_affectedWorkers_count' => $record->ia_affectedWorkers_count ,
                                'ia_compensation' => $record->ia_compensation ,
                                'ia_compensation_amount' => $record->ia_compensation_amount ,
                                'ia_medical' => $record->ia_medical ,
                                'ia_burial' => $record->ia_burial ,
                                'ia_timeLostDay' => $record->ia_timeLostDay ,
                                'ia_timeLostDay_hours' => $record->ia_timeLostDay_hours ,
                                'ia_timeLostDay_mins' => $record->ia_timeLostDay_mins ,
                                'ia_timeLostSubseq' => $record->ia_timeLostSubseq ,
                                'ia_timeLostSubseq_hours' => $record->ia_timeLostSubseq_hours ,
                                'ia_timeLostSubseq_mins' => $record->ia_timeLostSubseq_mins ,
                                'ia_timeReducedOutput' => $record->ia_timeReducedOutput ,
                                'ia_timeReducedOutput_days' => $record->ia_timeReducedOutput_days ,
                                'ia_timeReducedOutput_percent' => $record->ia_timeReducedOutput_percent ,
                                'ia_machineryDamage' => $record->ia_machineryDamage ,
                                'ia_machineryDamage_repair' => $record->ia_machineryDamage_repair ,
                                'ia_machineryDamage_time' => $record->ia_machineryDamage_time , 
                                'ia_machineryDamage_production' => $record->ia_machineryDamage_production ,
                                'ia_materialDamage' => $record->ia_materialDamage ,
                                'ia_materialDamage_repair' => $record->ia_materialDamage_repair ,
                                'ia_materialDamage_time' => $record->ia_materialDamage_time ,
                                'ia_materialDamage_production' => $record->ia_materialDamage_production ,
                                'ia_equipmentDamage' => $record->ia_equipmentDamage ,
                                'ia_equipmentDamage_repair' => $record->ia_equipmentDamage_repair ,
                                'ia_equipmentDamage_time' => $record->ia_equipmentDamage_time ,
                                'ia_equipmentDamage_production' => $record->ia_equipmentDamage_production ,
                                'ia_safetyOfficer' => $record->ia_safetyOfficer ,
                                'ia_safetyOfficer_id' => $record->ia_safetyOfficer_id ,
                                'ia_employer' => $record->ia_employer ,
                                'ia_employer_id' => $record->ia_employer_id ,
                            ];
                        }
                    )
                    ->form([
                        
                        Wizard::make([
                            Wizard\Step::make('Report Details')
                                ->schema([
                                    Section::make()
                                        ->schema([
                                            Forms\Components\TextInput::make('ia_owner')
                                                ->required()
                                                ->label("Name of Owner")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ia_nationality')
                                                ->required()
                                                ->label("Nationality of Owner")
                                                ->maxLength(255),
                                            ]),
                                        ]),
                            Wizard\Step::make('Accident')
                                ->schema([
                                    Section::make('Accident Report')
                                        ->columns(2)
                                        ->schema([
                                            Forms\Components\DateTimePicker::make('ia_dateTime')
                                                ->required()
                                                ->columnSpan(2)
                                                ->seconds(false)
                                                ->minutesStep(5)
                                                ->label("Date and Time of Accident"),
                                            Forms\Components\TextInput::make('ia_injury')
                                                ->required()
                                                ->label("Personal Injury")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ia_damage')
                                                ->required()
                                                ->label("Property Damage")
                                                ->maxLength(255),
                                            Forms\Components\Textarea::make('ia_description')
                                                ->required()
                                                ->columnSpan(2)
                                                ->label("Description of Accident")
                                                ->placeholder('Give full details on how accident occured')
                                                ->maxLength(255),
                                            Forms\Components\Select::make('ia_wasInjured')
                                                ->required()
                                                ->native(false)
                                                ->live()
                                                ->default('Yes')
                                                ->options([
                                                    'Yes' => 'Yes',
                                                    'No' => 'No',
                                                ])
                                                ->label("Was injured doing regular part of job at time of accident?"),
                                            Forms\Components\TextInput::make('ia_ntInjuredReason')
                                                ->label("If not, why?")
                                                ->disabled(function (Get $get){
                                                    if($get('ia_wasInjured') == 'Yes'){
                                                        return true;
                                                    }else{
                                                        return false;
                                                    }
                                                })
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ia_agencyInvolved')
                                                ->required()
                                                ->label("The Agency Involved ")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ia_agencyPart')
                                                ->required()
                                                ->label("The Agency Part Involved ")
                                                ->maxLength(255),
                                            Forms\Components\Select::make('ia_accidentType')
                                                ->required()
                                                ->native(false)
                                                ->searchable() 
                                                ->options([
                                                    'Falls of persons' => 'Falls of persons',
                                                    'Falls of persons from heights' => 'Falls of persons from heights',
                                                    'Falls of persons on the same level' => 'Falls of persons on the same level',
                                                    'Struck by falling objects' => 'Struck by falling objects',
                                                    'Slides and cave-ins' => 'Slides and cave-ins',
                                                    'Collapse (buildings, walls, scaffolds, ladders, piles of goods)' => 'Collapse (buildings, walls, scaffolds, ladders, piles of goods)',
                                                    'Struck by falling objects during handling' => 'Struck by falling objects during handling',
                                                    'Struck by falling objects, not elsewhere classified' => 'Struck by falling objects, not elsewhere classified',
                                                    'Stepping on, striking against or struck by objects excluding falling objects' => 'Stepping on, striking against or struck by objects excluding falling objects',
                                                    'Stepping on objects' => 'Stepping on objects',
                                                    'Striking against stationary objects (except impacts due to a previous fall)' => 'Striking against stationary objects (except impacts due to a previous fall)',
                                                    'Striking against moving objects' => 'Striking against moving objects',
                                                    'Struck by moving objects (including flying fragments and excluding falling objects particles) Caught in or between objects' => 'Struck by moving objects (including flying fragments and excluding falling objects particles) Caught in or between objects',
                                                    'Caught in an object' => 'Caught in an object',
                                                    'Caught between a stationary object and a moving object' => 'Caught between a stationary object and a moving object',
                                                    'Caught between moving objects (except flying or falling objects)' => 'Caught between moving objects (except flying or falling objects)',
                                                    'Overexertion or strenuous movements' => 'Overexertion or strenuous movements',
                                                    'Overexertion in lifting objects' => 'Overexertion in lifting objects',
                                                    'Overexertion in pushing or pulling objects' => 'Overexertion in pushing or pulling objects',
                                                    'Overexertion in handling or throwing objects' => 'Overexertion in handling or throwing objects',
                                                    'Strenuous movements' => 'Strenuous movements',
                                                    'Exposure to or contact with extreme temperatures' => 'Exposure to or contact with extreme temperatures',
                                                    'Exposure to heat (atmosphere or environment)' => 'Exposure to heat (atmosphere or environment)',
                                                    'Exposure to cold (atmosphere or environment) Contact with hot substances or objects' => 'Exposure to cold (atmosphere or environment) Contact with hot substances or objects',
                                                    'Contact with very cold substances or objects' => 'Contact with very cold substances or objects',
                                                    'Exposure to or contact with electric current' => 'Exposure to or contact with electric current',
                                                    'Exposure to or contact with harmful substances or radiations' => 'Exposure to or contact with harmful substances or radiations',
                                                    'Contact by inhalation, ingestion or absorption of harmful substances' => 'Contact by inhalation, ingestion or absorption of harmful substances',
                                                    'Exposure to ionizing radiations' => 'Exposure to ionizing radiations',
                                                    'Exposure to radiations other than ionizing radiations' => 'Exposure to radiations other than ionizing radiations',
                                                    'Other types of accident, not elsewhere classified, including accidents not classified for lack of sufficient data' => 'Other types of accident, not elsewhere classified, including accidents not classified for lack of sufficient data',
                                                    'Other types of accident, not elsewhere classified' => 'Other types of accident, not elsewhere classified',
                                                    'Accidents not classified for lack of sufficient data' => 'Accidents not classified for lack of sufficient data',
                                                ])
                                                ->label("Accident Type"),
                                            Forms\Components\TextInput::make('ia_condition')
                                                ->required()
                                                ->label("Unsafe Mechanical or Physical Condition")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ia_unsafeAct')
                                                ->required()
                                                ->label("The Unsafe Act")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ia_factor')
                                                ->required()
                                                ->label("Contributing Factor")
                                                ->maxLength(255),
                                            ]),
                                    Section::make('Preventive Measures')
                                        ->columns(2)
                                        ->schema([
                                            Forms\Components\TextArea::make('ia_preventiveMeasure')
                                                ->required()
                                                ->label("Preventive Measures (Taken or Recommended)")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ia_safeguard')
                                                ->required()
                                                ->label("Mechanical Guards, Personal Protective Equipment and other Safeguards")
                                                ->maxLength(255),
                                            Forms\Components\Select::make('ia_useSafeguard')
                                                ->required()
                                                ->label("Were all safeguards in use?")
                                                ->live()
                                                ->native(false)
                                                ->options([
                                                    'Yes' => 'Yes',
                                                    'No' => 'No',
                                                ]),
                                            Forms\Components\TextInput::make('ia_ntSafeguardReason')
                                                ->label("If not, why?")
                                                ->maxLength(255)
                                                ->live()
                                                ->disabled(function(Get $get){
                                                    if($get('ia_useSafeguard') == 'No'){
                                                        return false;
                                                    }
                                                    return true;
                                                }),
                                        ]),
                                ]),
                            Wizard\Step::make('Workers')
                                ->schema([
                                    Section::make('Affected Workers')
                                        ->description(fn():Htmlable => new HtmlString("
                                                    <div style=\"color: gray; font-size: 12px;\">Instructions:</div>
                                                    <div style=\"color: gray; font-size: 12px; margin-left: 5px;\">1. Check the Employees to be Selected</div>
                                                    <div style=\"color: gray; font-size: 12px; margin-left: 5px;\">2. Click the button 'ADD SELECTED'</div>
                                                ")
                                            )
                                        ->schema([
                                            Livewire::make(EmployeeTable::class)
                                                ->key('employee-table'),
                                        ]),
                                    Section::make('Manpower')
                                        ->columns(4)
                                        ->schema([
                                            Forms\Components\TextInput::make('ia_compensation')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Compensation")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ia_compensation_amount')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Compensation Amount")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ia_medical')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Medical and Hospitalization")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ia_burial')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Burial")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ia_timeLostDay')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Time Lost on Day of injury")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ia_timeLostDay_hours')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Hours:")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ia_timeLostDay_mins')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Minutes:")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ia_timeLostSubseq')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Time Lost on Subsequent Days")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ia_timeLostSubseq_hours')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Hours:")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ia_timeLostSubseq_mins')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Minutes:")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ia_timeReducedOutput')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Time on light work or reduced output")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ia_timeReducedOutput_days')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Days:")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ia_timeReducedOutput_percent')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Percentage Output:")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                        ]),
                                ]),
                            Wizard\Step::make('Equipment')
                                ->schema([
                                    Section::make('Machinery and Tools')
                                        ->columns(2)
                                        ->aside()
                                        ->schema([
                                            Forms\Components\TextArea::make('ia_machineryDamage')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Damage to Machinery and Tools (Describe)")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ia_machineryDamage_repair')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Cost of Repair or Replacement")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ia_machineryDamage_time')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Lost Production Time (in hours)")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ia_machineryDamage_production')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Cost of Lost production time")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                        ]),
                                    Section::make('Materials')
                                        ->columns(2)
                                        ->aside()
                                        ->schema([
                                            Forms\Components\TextArea::make('ia_materialDamage')
                                                ->columnSpan(2)
                                                ->required()
                                                ->label("Damage to Materials (Describe)")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ia_materialDamage_repair')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Cost of Repair or Replacement")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ia_materialDamage_time')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Lost Production Time (in hours)")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ia_materialDamage_production')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Cost of Lost production time")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                        ]),
                                    Section::make('Equipment')
                                        ->columns(2)
                                        ->aside()
                                        ->schema([
                                            Forms\Components\TextArea::make('ia_equipmentDamage')
                                                ->columnSpan(2 )
                                                ->required()
                                                ->label("Damage to Equipment Tools (Describe)")
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ia_equipmentDamage_repair')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Cost of Repair or Replacement")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ia_equipmentDamage_time')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Lost Production Time (in hours)")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                            Forms\Components\TextInput::make('ia_equipmentDamage_production')
                                                ->columnSpan(1)
                                                ->required()
                                                ->label("Cost of Lost production time")
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                        ]),
                                ]),
                            Wizard\Step::make('Certify')
                                ->columns(2)
                                ->schema([
                                    Forms\Components\TextInput::make('ia_safetyOfficer')
                                        ->required()
                                        ->label("OH Personnel / Safety Officer")
                                        ->maxLength(255),
                                    Forms\Components\FileUpload::make('ia_safetyOfficer_id')
                                        ->required()
                                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                                        ->label("OH Personnel / Safety Officer ID "),
                                    Forms\Components\TextInput::make('ia_employer')
                                        ->columnSpan(1)
                                        ->required()
                                        ->label("Employer Name")
                                        ->maxLength(255),
                                    Forms\Components\FileUpload::make('ia_employer_id')
                                        ->required()
                                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                                        ->label("Employer ID"),
                                ]),
                            
                        ])

                    ])
                    ->action(function (array $data, Wair $wair) {
                        $record = IAReport::query()->where('id', $wair->wairs_reportId)->first();
                        $record->update($data);
                        return 
                            Notification::make()
                                ->title('Successfully Updated the Report!')
                                ->icon('heroicon-o-document-text')
                                ->iconColor('success')
                                ->send();
                    }),
               // no accident and illness button
                Tables\Actions\Action::make('view-niaRep')
                    ->hidden(function (Wair $record){
                        return $record->wairs_reportType != 'No Incident of Illness or Accident Report';
                    })
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->modalSubmitActionLabel('Done')
                    ->modalCancelAction(false)
                    ->disabledForm()
                    ->fillForm(
                        function (Wair $wair): array {
                            $record = NIAReport::query()->where('id', $wair->wairs_reportId)->first();
                            return [
                                    'nia_owner' => $record->nia_owner ,
                                    'nia_nationality' => $record->nia_nationality ,
                                    'nia_safetyOfficer' => $record->nia_safetyOfficer ,
                                    'nia_safetyOfficer_id' => $record->nia_safetyOfficer_id ,
                                    'nia_employer' => $record->nia_employer ,
                                    'nia_employer_id' => $record->nia_employer_id ,
                            ];
                        }
                    )
                    ->form([
                            Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('nia_owner')
                                        ->required()
                                        ->label("Name of Owner")
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('nia_nationality')
                                        ->required()
                                        ->label("Nationality of Owner")
                                        ->maxLength(255),
                                    ]),
                            Section::make('Certify')
                                ->columns(2)
                                ->schema([
                                    Forms\Components\TextInput::make('nia_safetyOfficer')
                                        ->required()
                                        ->label("OH Personnel / Safety Officer")
                                        ->maxLength(255),
                                    Forms\Components\FileUpload::make('nia_safetyOfficer_id')
                                        ->required()
                                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                                        ->label("OH Personnel / Safety Officer ID "),
                                    Forms\Components\TextInput::make('nia_employer')
                                        ->columnSpan(1)
                                        ->required()
                                        ->label("Employer Name")
                                        ->maxLength(255),
                                    Forms\Components\FileUpload::make('nia_employer_id')
                                        ->required()
                                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                                        ->label("Employer ID"),
                                ]),
                    ]),
       
                Tables\Actions\Action::make('edit-niaRep')
                    ->hidden(function (Wair $record){
                        return $record->wairs_reportType != 'No Incident of Illness or Accident Report';
                    })
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->modalSubmitActionLabel('Update')
                    ->fillForm(
                        function (Wair $wair): array {
                            $record = NIAReport::query()->where('id', $wair->wairs_reportId)->first();
                            return [
                                    'nia_owner' => $record->nia_owner ,
                                    'nia_nationality' => $record->nia_nationality ,
                                    'nia_safetyOfficer' => $record->nia_safetyOfficer ,
                                    'nia_safetyOfficer_id' => $record->nia_safetyOfficer_id ,
                                    'nia_employer' => $record->nia_employer ,
                                    'nia_employer_id' => $record->nia_employer_id ,
                            ];
                        }
                    )
                    ->form([
                            Wizard::make([
                                Wizard\Step::make('Report Details')
                                    ->description('Fill up the Form to Complete your Registration.')
                                    ->schema([
                                        Section::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('nia_owner')
                                                    ->required()
                                                    ->label("Name of Owner")
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('nia_nationality')
                                                    ->required()
                                                    ->label("Nationality of Owner")
                                                    ->maxLength(255),
                                                ]),
                                        Section::make('Certify')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('nia_safetyOfficer')
                                                    ->required()
                                                    ->label("OH Personnel / Safety Officer")
                                                    ->maxLength(255),
                                                Forms\Components\FileUpload::make('nia_safetyOfficer_id')
                                                    ->required()
                                                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                                                    ->label("OH Personnel / Safety Officer ID "),
                                                Forms\Components\TextInput::make('nia_employer')
                                                    ->columnSpan(1)
                                                    ->required()
                                                    ->label("Employer Name")
                                                    ->maxLength(255),
                                                Forms\Components\FileUpload::make('nia_employer_id')
                                                    ->required()
                                                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                                                    ->label("Employer ID"),
                                            ]),
                                    ]),
                            
                            ])

                    ])
                    ->action(function (array $data, Wair $wair) {
                        $record = NIAReport::query()->where('id', $wair->wairs_reportId)->first();
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
            'index' => Pages\ListWairs::route('/'),
        ];
    }
}
