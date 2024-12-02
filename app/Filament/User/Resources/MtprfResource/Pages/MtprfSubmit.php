<?php

namespace App\Filament\User\Resources\MtprfResource\Pages;

use App\Filament\User\Resources\MtprfResource;
use Filament\Resources\Pages\Page;

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
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Forms\Components\Textarea;
use App\Livewire\MtprfRepeater;
use App\Models\Mtprf;
use App\Models\MtprfCancel;
use App\Models\MtprfContractor;
use App\Models\MtprfShoot;
use App\Models\MtprfWorkHours;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class MtprfSubmit extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = MtprfResource::class;

    protected static string $view = 'filament.user.resources.mtprf-resource.pages.mtprf-submit';

    protected ?string $heading = 'Movie and Television Production Report Form';

    protected static ?string $breadcrumb = 'MTPRF';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function create()
    {
        
        dd($this->form->getState());
        // $record->update($data); // Update main model fields

        // $mtprfCancelData = $data['Cancellation of Shoot']; // Access repeater data
        $uuid = Uuid::uuid4()->toString();
        $microseconds = substr(explode('.', microtime(true))[1], 0, 6);
        $uuid = 'mtprf-'.substr($uuid, 0, 7).'-'.$microseconds;

        // foreach($this->data['mtprfShoot'] as $shoot){
        //     dd($shoot['shoot_map']);
        //     $shooting = MtprfShoot::create([
        //         'mtprf_id' => $uuid,
        //         'shoot_address' => $shoot['shoot_address'],
        //         'shoot_map' => $shoot['shoot_map'],
        //         // 'shoot_startDate' => $shoot['shoot_startDate'],
        //         // 'shoot_startTime' => $shoot['shoot_startTime'],
        //         // 'shoot_endDate' => $shoot['shoot_endDate'],
        //         // 'shoot_endtime' => $shoot['shoot_endtime'],
        //         // 'shoot_workHoursMinor_date' => $shoot['shoot_workHoursMinor_date'],
        //         // 'shoot_workHoursMinor_startTime' => $shoot['shoot_workHoursMinor_startTime'],
        //         // 'shoot_workHoursMinor_endTime' => $shoot['shoot_workHoursMinor_endTime'],
        //     ]);
        //     foreach($shoot['shoot_map'] as $workHour){
        //         $workWork = MtprfWorkHours::create([
        //             'mtprf_id' => $uuid,
        //             'shoot_id' => $shooting->id,
        //             'shoot_address' => $shoot['shoot_address'],
        //             'shoot_map' => $shoot['shoot_map'],
        //             'shoot_startDate' => $workHour['shoot_startDate'],
        //             'shoot_startTime' => $workHour['shoot_startTime'],
        //             'shoot_endDate' => $workHour['shoot_endDate'],
        //             'shoot_endtime' => $workHour['shoot_endtime'],
        //             'shoot_workHoursMinor_date' => $workHour['shoot_workHoursMinor_startTime'],
        //             'shoot_workHoursMinor_startTime' => $workHour['shoot_workHoursMinor_startTime'],
        //             'shoot_workHoursMinor_endTime' => $workHour['shoot_workHoursMinor_endTime'],
        //         ]);
        //     }
        // }

        // foreach($this->data['mtprfCancel'] as $cancel){
        //     $cancelled = MtprfCancel::create([
        //         'mtprf_id' => $uuid,
        //         'cancel_date' => $cancel['cancel_date'],
        //         'cancel_reason' => $cancel['cancel_reason'],
        //         'cancel_affected' => $cancel['cancel_affected'],
        //         'cancel_commenced' => $cancel['cancel_commenced'],
        //         'cancel_notice' => $cancel['cancel_notice'],
        //     ]);
        // }

        // foreach($this->data['mtprfContract'] as $serv){
        //     $serving = MtprfContractor::create([
        //         'mtprf_id' => $uuid,
        //         'contractor_name' => $serve['contractor_name'],
        //         'contractor_service' => $serve['contractor_name'],
        //         'contractor_address' => $serve['contractor_name'],
        //         'contractor_mobileNum' => $serve['contractor_name'],
        //         'contractor_regNum' => $serve['contractor_name'],
        //         'contractor_deployedMale' => $serve['contractor_name'],
        //         'contractor_deployedFemale' => $serve['contractor_name'],
        //     ]);
        // }
        session()->put('mtprf', $uuid);

        Mtprf::create($this->form->getState());

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
            ->model(Mtprf::class)
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Report Details')
                        ->description('Fill up the Form.')
                        ->schema([
                            Section::make('I. Establishment Profile')
                                ->columns(3)
                                ->schema([
                                    Forms\Components\TextInput::make('mtprf_companyName')
                                        ->label('Name of Production Outfit/Company')
                                        ->columnSpan(1)
                                        ->maxLength(255),
                                    Forms\Components\Select::make('mtprf_companyType')
                                        ->label('Type')
                                        ->columnSpan(1)
                                        ->native(false)
                                        ->options([
                                            'Employer' => 'Employer',
                                            'Contractor' => 'Contractor',
                                            'Principal' => 'Principal',
                                        ]),
                                    Forms\Components\TextInput::make('mtprf_representativeOwner')
                                        ->label('Name of Authorized Representative')
                                        ->columnSpan(1)
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('mtprf_director')
                                        ->label('Name of Director/Production Manager')
                                        ->columnSpan(2)
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('mtprf_email')
                                        ->label('Email')
                                        ->columnSpan(1)
                                        ->email()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('mtprf_address')
                                        ->label('Principal Address')
                                        ->columnSpan(2)
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('mtprf_number')
                                        ->label('Contact Number')
                                        ->columnSpan(1)
                                        ->maxLength(255),
                                ]),


                            Section::make('II. Production Profile')
                                ->columns(3)
                                ->schema([
                                    Forms\Components\TextInput::make('mtprf_movieNamev')
                                        ->label('Name of Movie or Television Project:')
                                        ->columnSpan(3)
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('mtprf_productionManager')
                                        ->label('Name of Production Manager/Focal Person')
                                        ->columnSpan(1)
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('mtprf_pmEmail')
                                        ->label('Email')
                                        ->columnSpan(1)
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('mtprf_pmContactNum')
                                        ->label('Mobile Number')
                                        ->columnSpan(1)
                                        ->maxLength(255),
                                    Forms\Components\DatePicker::make('mtprf_projectDuration')
                                        ->label('Project Duration')
                                        ->columnSpan(1),
                                    Forms\Components\TextInput::make('mtprf_numDays')
                                        ->label('Estimated Number of days')
                                        ->minValue(0)
                                        ->default(0)
                                        ->columnSpan(1)
                                        ->integer(),
                                ]),
                            Section::make('Workers\' Profile')
                                ->columns(3)
                                ->schema([
                                    Section::make()
                                        ->columns(2)
                                        ->columnSpan(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('mtprf_15male')
                                                ->label('<15 y/o Male')
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0)
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('mtprf_15female')
                                                ->label('<15 y/o Female')
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0)
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('mtprf_18male')
                                                ->label('15-18 y/o Male')
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0)
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('mtprf_18female')
                                                ->label('15-18 y/o Female')
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0)
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('mtprf_19male')
                                                ->label('19-59 y/o Male')
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0)
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('mtprf_19female')
                                                ->label('19-59 y/o Female')
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0)
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('mtprf_60male')
                                                ->label('>59 y/o Male')
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0)
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('mtprf_60female')
                                                ->label('>59 y/o Female')
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0)
                                                ->maxLength(255),
                                        ]),
                                    Section::make()
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\ToggleButtons::make('mtprf_childPermit')
                                                ->label('Child Permit')
                                                ->grouped()
                                                ->options([
                                                    'Yes' => 'Yes',
                                                    'No' => 'No',
                                                ])
                                                ->colors([
                                                    'Yes' => 'success',
                                                    'No' => 'danger',
                                                ])
                                                ->icons([
                                                    'Yes' => 'heroicon-o-check',
                                                    'No' => 'heroicon-o-x-mark',
                                                ])
                                                ,
                                            Forms\Components\TextInput::make('mtprf_contractorWorker')
                                                ->label('No. of Contractor/s\' Workers:')
                                                ->minValue(0)
                                                ->default(0)
                                                ->integer(),
                                            Forms\Components\TextInput::make('mtprf_independentContractor')
                                                ->label('No. of Independent Contractors:')
                                                ->minValue(0)
                                                ->default(0)
                                                ->integer(),
                                        ]),
                                ])
                        ]), //step
                    Wizard\Step::make('Shoot Location')
                        ->schema([
                            Forms\Components\Repeater::make('mtprfShoot')
                                ->label(' ')
                                ->columns(3)
                                ->relationship()
                                ->addActionLabel('+ Additional Location Shoot')
                                ->schema([
                                    Section::make('Location')
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\Textarea::make('shoot_address')
                                                ->label('Specific Address')
                                                ->maxLength(255),
                                            Forms\Components\FileUpload::make('shoot_map')
                                                ->label('Vicinity Map'),
                                            ]),
                                    Forms\Components\Repeater::make('mtprf_workHours')
                                        ->label(' ')
                                        ->columnSpan(2)
                                        ->addActionLabel('+ Additional Working Hours')
                                        ->schema([
                                            Section::make('Working Hours')
                                                ->columnSpan(1)
                                                ->columns(3)
                                                ->schema([
                                                    Section::make('Start Date and Call Time ')
                                                        ->columns(1)
                                                        ->columnSpan(1)
                                                        ->schema([
                                                            Forms\Components\DatePicker::make('shoot_startDate')
                                                                ->label('Date'),
                                                            Forms\Components\TimePicker::make('shoot_startTime')
                                                                ->label('Start Time')
                                                                ->seconds(false)
                                                                ->minutesStep(5),
                                                        ]),
                                                    Section::make('End Date and Time of Egress')
                                                        ->columns(1)
                                                        ->columnSpan(1)
                                                        ->schema([
                                                            Forms\Components\DatePicker::make('shoot_endDate')
                                                                ->label('Date'),
                                                            Forms\Components\TimePicker::make('shoot_endTime')
                                                                ->label('End Time')
                                                                ->seconds(false)
                                                                ->minutesStep(5),
                                                        ]),
                                                    Section::make('Working Hours of Minor')
                                                        ->columns(1)
                                                        ->columnSpan(1)
                                                        ->schema([
                                                            Forms\Components\DatePicker::make('shoot_workHoursMinor_date')
                                                                ->label('Date'),
                                                            Forms\Components\TimePicker::make('shoot_workHoursMinor_startTime')
                                                                ->label('From')
                                                                ->seconds(false)
                                                                ->minutesStep(5),
                                                            Forms\Components\TimePicker::make('shoot_workHoursMinor_endTime')
                                                                ->label('To')
                                                                ->seconds(false)
                                                                ->minutesStep(5),
                                                        ]),
                                                ]),
                                        ]),
                                ]),
                            Forms\Components\Repeater::make('mtprfCancel')
                                ->columnSpan(2)
                                ->columns(3)
                                ->relationship('mtprfCancel')
                                ->addActionLabel('+ Additional Shoot Cancellation')
                                ->schema([
                                    Section::make(' ')
                                        ->columns(1)
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\DatePicker::make('shoot_cancel_date')
                                                ->label('Cancellation Date'),
                                        ]),
                                    Section::make(' ')
                                        ->columns(1)
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\TextInput::make('shoot_cancel_reason')
                                                ->label('Reason for Cancellation'),
                                            Forms\Components\TextInput::make('shoot_cancel_affected')
                                                ->label('Number of Affected Workers')
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0),
                                        ]),
                                    Section::make(' ')
                                        ->columns(1)
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\ToggleButtons::make('shoot_cancel_commenced')
                                                ->label('Commenced Work')
                                                ->grouped()
                                                ->options([
                                                    'Yes' => 'Yes',
                                                    'No' => 'No',
                                                ])
                                                ->colors([
                                                    'Yes' => 'success',
                                                    'No' => 'danger',
                                                ])
                                                ->icons([
                                                    'Yes' => 'heroicon-o-check',
                                                    'No' => 'heroicon-o-x-mark',
                                                ]),
                                            Forms\Components\ToggleButtons::make('shoot_cancel_notice')
                                                ->label('Notice of Cancellation')
                                                ->grouped()
                                                ->options([
                                                    'Yes' => 'Yes',
                                                    'No' => 'No',
                                                ])
                                                ->colors([
                                                    'Yes' => 'success',
                                                    'No' => 'danger',
                                                ])
                                                ->icons([
                                                    'Yes' => 'heroicon-o-check',
                                                    'No' => 'heroicon-o-x-mark',
                                                ]),
                                        ]),
                                ]),
                            Section::make()
                                ->schema([
                                    Forms\Components\Textarea::make('mtprf_shoot-remarks')
                                        ->label('Remarks')
                                        ->maxLength(255),
                                ])
                        ]),
                    Wizard\Step::make('Service Provider/s Details')
                        ->schema([
                            Forms\Components\Repeater::make('mtprfContract')
                                ->columns(5)
                                ->label(' ')
                                ->relationship('mtprfContract')
                                ->addActionLabel('+ Additional Service Provider')
                                ->schema([
                                    Section::make()
                                        ->columnSpan(4)
                                        ->columns(6)
                                        ->schema([
                                            Forms\Components\TextInput::make('mtprf_contractorName')
                                                ->columnSpan(2)
                                                ->label('Name of Contractor/s'),
                                            Forms\Components\TextInput::make('mtprf_contractorPsic')
                                                ->columnSpan(2)
                                                ->label('Service/s Provided'),
                                            Forms\Components\TextInput::make('mtprf_contractorAddress')
                                                ->columnSpan(2)
                                                ->label('Address'),
                                            Forms\Components\TextInput::make('mtprf_contractorNum')
                                                ->columnSpan(3)
                                                ->label('Focal Person / Mobile Number'),
                                            Forms\Components\TextInput::make('mtprf_contractorReg')
                                                ->columnSpan(3  )
                                                ->label('Registration Number under Department Order No. 174'),
                                        ]),
                                    Section::make('Number of Deployed Workers')
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\TextInput::make('mtprf_contractorMaleWork')
                                                ->label('Male'),
                                            Forms\Components\TextInput::make('mtprf_contractorFemaleWork')
                                                ->label('Female'),
                                        ]),
                                ]),
                        ]),
                    Wizard\Step::make('Occupational Safety and Health')
                        ->schema([
                            Section::make('OSH Personnel Requirement')
                                ->columns(3)
                                ->schema([
                                    Forms\Components\TextInput::make('mtprf_safetyOfficer')
                                        ->label('Name of Safety Officer/s (Principal Office) Name of Safety Officer/s (Onsite)')
                                        ->columnSpan(2)
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('mtprf_safetyOfficer_contact')
                                        ->label('Contact No.')
                                        ->columnSpan(1)
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('mtprf_firstAide')
                                        ->label('Name of First Aider/s (Principal Office) Name of First Aider/s (Onsite)')
                                        ->columnSpan(2)
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('mtprf_firstAide_contact')
                                        ->label('Contact No.')
                                        ->columnSpan(1)
                                        ->maxLength(255),
                                    Forms\Components\ToggleButtons::make('mtprf_safeHealthCommittee')
                                        ->label('Safety and Health Committee')
                                        ->columnSpan(3)
                                        ->grouped()
                                        ->options([
                                            'Yes' => 'Yes',
                                            'No' => 'No',
                                        ])
                                        ->colors([
                                            'Yes' => 'success',
                                            'No' => 'danger',
                                        ])
                                        ->icons([
                                            'Yes' => 'heroicon-o-check',
                                            'No' => 'heroicon-o-x-mark',
                                        ]),
                                    Forms\Components\ToggleButtons::make('mtprf_hospitalMoa')
                                        ->label('Memorandum of Agreement with a Hospital')
                                        ->columnSpan(3)
                                        ->grouped()
                                        ->options([
                                            'Yes' => 'Yes',
                                            'No' => 'No',
                                            'N/A' => 'N/A'
                                        ])
                                        ->colors([
                                            'Yes' => 'success',
                                            'No' => 'danger',
                                            'N/A' => 'primary'
                                        ])
                                        ->icons([
                                            'Yes' => 'heroicon-o-check',
                                            'No' => 'heroicon-o-x-mark',
                                        ]),

                                ]),
                            
                            
                            Section::make('OSH Program')
                                ->columns(2)
                                ->schema([
                                    Forms\Components\ToggleButtons::make('mtprf_safetyProgram')
                                        ->columnSpan(1)
                                        ->label('Safety Program')
                                        ->grouped()
                                        ->options([
                                            'Yes' => 'Yes',
                                            'No' => 'No',
                                        ])
                                        ->colors([
                                            'Yes' => 'success',
                                            'No' => 'danger',
                                        ])
                                        ->icons([
                                            'Yes' => 'heroicon-o-check',
                                            'No' => 'heroicon-o-x-mark',
                                        ]),
                                    Forms\Components\ToggleButtons::make('mtprf_permits')
                                        ->columnSpan(1)
                                        ->label('Permits')
                                        ->grouped()
                                        ->options([
                                            'Yes' => 'Yes',
                                            'No' => 'No',
                                            'N/A' => 'N//A',
                                        ])
                                        ->colors([
                                            'Yes' => 'success',
                                            'No' => 'danger',
                                            'N/A' => 'primary'
                                        ])
                                        ->icons([
                                            'Yes' => 'heroicon-o-check',
                                            'No' => 'heroicon-o-x-mark',
                                        ]),
                                    Forms\Components\ToggleButtons::make('mtprf_riskClass')
                                        ->columnSpan(1)
                                        ->label('Risk Classification')
                                        ->options([
                                            'Low' => 'Low',
                                            'Medium' => 'Medium',
                                            'High' => 'High',
                                        ])
                                        ->colors([
                                            'Low' => 'success',
                                            'Medium' => 'primary',
                                            'High' => 'danger'
                                        ]),
                                    Forms\Components\ToggleButtons::make('mtprf_firearms')
                                        ->columnSpan(1)
                                        ->label('Firearms and Weaponry')
                                        ->grouped()
                                        ->options([
                                            'Yes' => 'Yes',
                                            'No' => 'No',
                                            'N/A' => 'N//A',
                                        ])
                                        ->colors([
                                            'Yes' => 'success',
                                            'No' => 'danger',
                                            'N/A' => 'primary'
                                        ])
                                        ->icons([
                                            'Yes' => 'heroicon-o-check',
                                            'No' => 'heroicon-o-x-mark',
                                        ]),
                                    Forms\Components\ToggleButtons::make('mtprf_emergencyTransport')
                                        ->label('Emergency Transport Vehicle Available')
                                        ->grouped()
                                        ->options([
                                            'Yes' => 'Yes',
                                            'No' => 'No',
                                        ])
                                        ->colors([
                                            'Yes' => 'success',
                                            'No' => 'danger',
                                        ])
                                        ->icons([
                                            'Yes' => 'heroicon-o-check',
                                            'No' => 'heroicon-o-x-mark',
                                        ]), 
                                    
                                    Forms\Components\ToggleButtons::make('mtprf_animalHandling')
                                        ->columnSpan(1)
                                        ->label('Animal Handling')
                                        ->grouped()
                                        ->options([
                                            'Yes' => 'Yes',
                                            'No' => 'No',
                                            'N/A' => 'N//A',
                                        ])
                                        ->colors([
                                            'Yes' => 'success',
                                            'No' => 'danger',
                                            'N/A' => 'primary'
                                        ])
                                        ->icons([
                                            'Yes' => 'heroicon-o-check',
                                            'No' => 'heroicon-o-x-mark',
                                        ]),
                                    Forms\Components\FileUpload::make('mtprf_actionPlan')
                                        ->columnSpan(1)
                                        ->label('Action Plan'),
                                    Forms\Components\TextInput::make('mtprf_others')
                                        ->label('Others')
                                        ->maxLength(255), 
                                ]),
                            
                            
                        ]),
                    Wizard\Step::make('Standard Treatment')
                        ->schema([
                            Section::make()
                                ->columns(3)
                                ->schema([
                                    Forms\Components\ToggleButtons::make('mtprf_decorumCommitee')
                                        ->columnSpan(2)
                                        ->label('Commitee on Decorum and  Investigation')
                                        ->grouped()
                                        ->options([
                                            'Yes' => 'Yes',
                                            'No' => 'No',
                                        ])
                                        ->colors([
                                            'Yes' => 'success',
                                            'No' => 'danger',
                                        ])
                                        ->icons([
                                            'Yes' => 'heroicon-o-check',
                                            'No' => 'heroicon-o-x-mark',
                                        ]),
                                    Forms\Components\ToggleButtons::make('mtprf_policy_harrassment')
                                        ->columnSpan(1)
                                        ->label('Policy on Anti-Sexual Harassment/Safe Spaces')
                                        ->grouped()
                                        ->options([
                                            'Yes' => 'Yes',
                                            'No' => 'No',
                                        ])
                                        ->colors([
                                            'Yes' => 'success',
                                            'No' => 'danger',
                                        ])
                                        ->icons([
                                            'Yes' => 'heroicon-o-check',
                                            'No' => 'heroicon-o-x-mark',
                                        ]),

                                    Forms\Components\TextInput::make('mtprf_representative')
                                        ->label('Name of Employer\'s Representative')
                                        ->columnSpan(2)
                                        ->maxLength(255),
                                    Forms\Components\ToggleButtons::make('mtprf_policy_mentalHealth')
                                        ->columnSpan(1)
                                        ->label('Policy on Anti-Sexual Harassment/Safe Spaces')
                                        ->grouped()
                                        ->options([
                                            'Yes' => 'Yes',
                                            'No' => 'No',
                                        ])
                                        ->colors([
                                            'Yes' => 'success',
                                            'No' => 'danger',
                                        ])
                                        ->icons([
                                            'Yes' => 'heroicon-o-check',
                                            'No' => 'heroicon-o-x-mark',
                                        ]),

                                    Forms\Components\TextInput::make('mtprf_representativeAgent')
                                        ->label('Name of Workers\' Representative (Sole and Exclusive Bargaining Agent, if any):')
                                        ->columnSpan(2)
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('mtprf_representativeSupervisor')
                                        ->label('Name of Workers\' Representative (Supervisory):')
                                        ->columnSpan(2)
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('mtprf_representativeRankFile')
                                        ->label('Name of Workers\' Representative (Rank and File):')
                                        ->columnSpan(2)
                                        ->maxLength(255),
                                    Forms\Components\Textarea::make('mtprf_remarks')
                                        ->label('Remarks/Others:')
                                        ->columnSpan(1)
                                        ->maxLength(255),
                                ]),
                            Section::make('Cases on Gender Based Violence')
                                ->schema([
                                    Section::make()
                                        ->columns(3)
                                        ->schema([
                                            Forms\Components\TextInput::make('mtprf_gbv_affectedTotal')
                                                ->label('Total No. of Affected Workers:')
                                                ->columnSpan(3)
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0),
                                            Forms\Components\TextInput::make('mtprf_gbv_affectedMale')  
                                                ->label('Male:')
                                                ->columnSpan(1)
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0),
                                            Forms\Components\TextInput::make('mtprf_gbv_affectedFemale')
                                                ->label('Female:')
                                                ->columnSpan(1)
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0),
                                            Forms\Components\TextInput::make('mtprf_gbv_affectedLgbtq')
                                                ->label('LGTBQIA+:')
                                                ->columnSpan(1)
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0),
                                        ]),
                                    Section::make()
                                        ->columns(3)
                                        ->schema([
                                            Forms\Components\TextInput::make('mtprf_gbv_offenderTotal')
                                                ->label('Total No. of Offenders:')
                                                ->columnSpan(3)
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0),
                                            Forms\Components\TextInput::make('mtprf_gbv_offenderMale')
                                                ->label('Male:')
                                                ->columnSpan(1)
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0),
                                            Forms\Components\TextInput::make('mtprf_gbv_offenderFemale')
                                                ->label('Female:')
                                                ->columnSpan(1)
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0),
                                            Forms\Components\TextInput::make('mtprf_gbv_offenderLgbtq')
                                                ->label('LGBTQIA+:')
                                                ->columnSpan(1)
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0),
                                        ]),
                                    
                                    
                                ]),
                            
                                
                            
                        ]),
                    Wizard\Step::make('Certification')
                        ->schema([
                            Section::make()
                                ->label('Prepared By')
                                ->columns(4)
                                ->schema([
                                    Forms\Components\TextInput::make('mtprf_preparedBy')
                                        ->label('Prepared By')
                                        ->columnSpan(2)
                                        ->maxLength(255),
                                    Forms\Components\FileUpload::make('mtprf_preparedSign')
                                        ->label('Signature over Printed Name')
                                        ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                                        ->columnSpan(2),
                                    Forms\Components\TextInput::make('mtprf_designation')
                                        ->label('Designation')
                                        ->columnSpan(2)
                                        ->maxLength(255),
                                ])                                  
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
            ->statePath('data');
        
    }
}
