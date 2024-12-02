<?php

namespace App\Filament\User\Resources\WairResource\Pages;

use App\Filament\User\Resources\WairResource;
use Filament\Resources\Pages\Page;
use App\Models\IAReport;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms;  
use Filament\Forms\Get;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Set;
use Closure;
use Filament\Forms\Components\Livewire;
use App\Livewire\EmployeeTable;
use App\Livewire\EmployeeReviewTable;
use App\Models\TempEmp;
use App\Models\Employees;
use Filament\Notifications\Notification;

class AccIllCreate extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = WairResource::class;

    protected static string $view = 'filament.user.resources.wair-resource.pages.acc-ill-create';

    protected ?string $heading = 'Accident and Illness Report';

    protected static ?string $breadcrumb = 'Accident and Illness';

    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }

    public function create()
    {
        $temp_emp = TempEmp::query()->where('emp_estabId', Auth::user()->est_id)->get();
        $emp_ids = [];
        // dd($this->form->getState());
        if($temp_emp != null){
            $c = 1;
            foreach ($temp_emp as $emp) {
                $attributes = $emp->toArray();
                $emp_ids[$c] = $attributes['id'];
                Employees::create($attributes);
                TempEmp::where('id', $attributes['id'])->delete();
                $c += $c;
            }
            session()->put('emp_ids', $emp_ids);
        }
        IAReport::create($this->form->getState());

        Notification::make()
            ->title('Report Submitted')
            ->icon('heroicon-o-document-text')
            ->iconColor('success')
            ->send();
            
        return redirect('user');
    }

    public function form(Form $form): Form
    {
        
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Report Details')
                        ->description('Fill up the Form to Complete your Registration.')
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
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
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
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('ia_timeLostDay_hours')
                                        ->columnSpan(1)
                                        ->required()
                                        ->label("Hours:")
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
                                    Forms\Components\TextInput::make('ia_timeLostDay_mins')
                                        ->columnSpan(1)
                                        ->required()
                                        ->label("Minutes:")
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
                                    Forms\Components\TextInput::make('ia_timeLostSubseq')
                                        ->columnSpan(2)
                                        ->required()
                                        ->label("Time Lost on Subsequent Days")
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('ia_timeLostSubseq_hours')
                                        ->columnSpan(1)
                                        ->required()
                                        ->label("Hours:")
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
                                    Forms\Components\TextInput::make('ia_timeLostSubseq_mins')
                                        ->columnSpan(1)
                                        ->required()
                                        ->label("Minutes:")
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
                                    Forms\Components\TextInput::make('ia_timeReducedOutput')
                                        ->columnSpan(2)
                                        ->required()
                                        ->label("Time on light work or reduced output")
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('ia_timeReducedOutput_days')
                                        ->columnSpan(1)
                                        ->required()
                                        ->label("Days:")
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
                                    Forms\Components\TextInput::make('ia_timeReducedOutput_percent')
                                        ->columnSpan(1)
                                        ->required()
                                        ->label("Percentage Output:")
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
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
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
                                    Forms\Components\TextInput::make('ia_machineryDamage_time')
                                        ->columnSpan(1)
                                        ->required()
                                        ->label("Lost Production Time (in hours)")
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
                                    Forms\Components\TextInput::make('ia_machineryDamage_production')
                                        ->columnSpan(1)
                                        ->required()
                                        ->label("Cost of Lost production time")
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
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
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
                                    Forms\Components\TextInput::make('ia_materialDamage_time')
                                        ->columnSpan(1)
                                        ->required()
                                        ->label("Lost Production Time (in hours)")
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
                                    Forms\Components\TextInput::make('ia_materialDamage_production')
                                        ->columnSpan(1)
                                        ->required()
                                        ->label("Cost of Lost production time")
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
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
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
                                    Forms\Components\TextInput::make('ia_equipmentDamage_time')
                                        ->columnSpan(1)
                                        ->required()
                                        ->label("Lost Production Time (in hours)")
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
                                    Forms\Components\TextInput::make('ia_equipmentDamage_production')
                                        ->columnSpan(1)
                                        ->required()
                                        ->label("Cost of Lost production time")
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
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
                ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button color="success" icon="heroicon-o-check" tag="button" type="submit" size="lg" wire:click="create" >
                        Submit
                        <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="animate-spin fi-btn-icon transition duration-75 h-5 w-5 text-white" wire:loading.delay.default="" wire:target="dispatchFormEvent">
                            <path clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
                            <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
                        </svg>
                    </x-filament::button>
                BLADE))),
            ])
            ->statePath('data')
            
            ;
        
    }
}