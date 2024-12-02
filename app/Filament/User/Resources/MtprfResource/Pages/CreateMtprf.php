<?php

namespace App\Filament\User\Resources\MtprfResource\Pages;

use App\Filament\User\Resources\MtprfResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Wizard\Step;
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
use Illuminate\Database\Eloquent\Model;

class CreateMtprf extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = MtprfResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('Report Details')
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
                                    Forms\Components\TextInput::make(' mtprf_18male')
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
            Step::make('Shoot Location')
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
                        ->label('Cancellation of Shoot')
                        ->relationship()
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
            Step::make('Service Provider/s Details')
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
            Step::make('Occupational Safety and Health')
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
            Step::make('Standard Treatment')
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
            Step::make('Certification')
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
            
                
            
        ];
    }
    
    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Report Submitted';
    }
}
