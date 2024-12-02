<?php

namespace App\Livewire;

use Livewire\Component;

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

class MtprfRepeater extends Component implements HasForms
{
    use InteractsWithForms;
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function create(): void
    {
        dd($this->form->getState());
    }
    
    public function render(): View
    {
        return view('livewire.mtprf-repeater');
    }
    public function form(Form $form): Form {
        return $form
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
                                        ->columnSpan(1)
                                        ->integer()
                                        ->default(0)
                                        ->minValue(0),
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
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('mtprf_15female')
                                                ->label('<15 y/o Female')
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make(' mtprf_18male')
                                                ->label('15-18 y/o Male')
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('mtprf_18female')
                                                ->label('15-18 y/o Female')
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('mtprf_19male')
                                                ->label('19-59 y/o Male')
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('mtprf_19female')
                                                ->label('19-59 y/o Female')
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('mtprf_60male')
                                                ->label('>59 y/o Male')
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('mtprf_60female')
                                                ->label('>59 y/o Female')
                                                ->maxLength(255),
                                        ]),
                                    Section::make()
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\Select::make('mtprf_childPermit')
                                                ->label('Child Permit')
                                                ->options([
                                                    'Yes' => 'Yes',
                                                    'No' => 'No',
                                                ]),
                                            Forms\Components\TextInput::make('mtprf_contractorWorker')
                                                ->label('No. of Contractor/s\' / Workers:')
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0),
                                            Forms\Components\TextInput::make('mtprf_independentContractor')
                                                ->label('No. of Independent Contractors:')
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0),
                                        ]),
                                    
                                    
                                    Forms\Components\TextInput::make('mtprf_total')
                                        ->maxLength(255),
                                ])
                            ]),
                    Wizard\Step::make('22 Report Details'),
                ])
            ]);
    }
    // public function form(Form $form): Form
    // {
        
    //     return $form
    //         ->schema([
    //             Wizard::make([
    //                 Wizard\Step::make('Report Details')
    //                     ->description('Fill up the Form.')
    //                     ->schema([
    //                         Section::make('I. Establishment Profile')
    //                             ->columns(3)
    //                             ->schema([
    //                                 Forms\Components\TextInput::make('mtprf_companyName')
    //                                     ->label('Name of Production Outfit/Company')
    //                                     ->columnSpan(1)
    //                                     ->maxLength(255),
    //                                 Forms\Components\Select::make('mtprf_companyType')
    //                                     ->label('Type')
    //                                     ->columnSpan(1)
    //                                     ->options([
    //                                         'Employer' => 'Employer',
    //                                         'Contractor' => 'Contractor',
    //                                         'Principal' => 'Principal',
    //                                     ]),
    //                                 Forms\Components\TextInput::make('mtprf_representativeOwner')
    //                                     ->label('Name of Authorized Representative')
    //                                     ->columnSpan(1)
    //                                     ->maxLength(255),
    //                                 Forms\Components\TextInput::make('mtprf_director')
    //                                     ->label('Name of Director/Production Manager')
    //                                     ->columnSpan(2)
    //                                     ->maxLength(255),
    //                                 Forms\Components\TextInput::make('mtprf_email')
    //                                     ->label('Email')
    //                                     ->columnSpan(1)
    //                                     ->email()
    //                                     ->maxLength(255),
    //                                 Forms\Components\TextInput::make('mtprf_address')
    //                                     ->label('Principal Address')
    //                                     ->columnSpan(2)
    //                                     ->maxLength(255),
    //                                 Forms\Components\TextInput::make('mtprf_number')
    //                                     ->label('Contact Number')
    //                                     ->columnSpan(1)
    //                                     ->maxLength(255),
    //                             ]),
    //                         Section::make('II. Production Profile')
    //                             ->columns(3)
    //                             ->schema([
    //                                 Forms\Components\TextInput::make('mtprf_movieNamev')
    //                                     ->label('Name of Movie or Television Project:')
    //                                     ->columnSpan(3)
    //                                     ->maxLength(255),
    //                                 Forms\Components\TextInput::make('mtprf_productionManager')
    //                                     ->label('Name of Production Manager/Focal Person')
    //                                     ->columnSpan(1)
    //                                     ->maxLength(255),
    //                                 Forms\Components\TextInput::make('mtprf_pmEmail')
    //                                     ->label('Email')
    //                                     ->columnSpan(1)
    //                                     ->maxLength(255),
    //                                 Forms\Components\TextInput::make('mtprf_pmContactNum')
    //                                     ->label('Mobile Number')
    //                                     ->columnSpan(1)
    //                                     ->maxLength(255),
    //                                 Forms\Components\DatePicker::make('mtprf_projectDuration')
    //                                     ->label('Project Duration')
    //                                     ->columnSpan(1),
    //                                 Forms\Components\TextInput::make('mtprf_numDays')
    //                                     ->label('Estimated Number of days')
    //                                     ->columnSpan(1)
    //                                     ->integer()
                                        // ->default(0)
                                        // ->minValue(0),
    //                             ]),
    //                         Section::make('Workers\' Profile')
    //                             ->columns(3)
    //                             ->schema([
    //                                 Section::make()
    //                                     ->columns(2)
    //                                     ->columnSpan(2)
    //                                     ->schema([
    //                                         Forms\Components\TextInput::make('mtprf_15male')
    //                                             ->label('<15 y/o Male')
    //                                             ->maxLength(255),
    //                                         Forms\Components\TextInput::make('mtprf_15female')
    //                                             ->label('<15 y/o Female')
    //                                             ->maxLength(255),
    //                                         Forms\Components\TextInput::make(' mtprf_18male')
    //                                             ->label('15-18 y/o Male')
    //                                             ->maxLength(255),
    //                                         Forms\Components\TextInput::make('mtprf_18female')
    //                                             ->label('15-18 y/o Female')
    //                                             ->maxLength(255),
    //                                         Forms\Components\TextInput::make('mtprf_19male')
    //                                             ->label('19-59 y/o Male')
    //                                             ->maxLength(255),
    //                                         Forms\Components\TextInput::make('mtprf_19female')
    //                                             ->label('19-59 y/o Female')
    //                                             ->maxLength(255),
    //                                         Forms\Components\TextInput::make('mtprf_60male')
    //                                             ->label('>59 y/o Male')
    //                                             ->maxLength(255),
    //                                         Forms\Components\TextInput::make('mtprf_60female')
    //                                             ->label('>59 y/o Female')
    //                                             ->maxLength(255),
    //                                     ]),
    //                                 Section::make()
    //                                     ->columnSpan(1)
    //                                     ->schema([
    //                                         Forms\Components\Select::make('mtprf_childPermit')
    //                                             ->label('Child Permit')
    //                                             ->options([
    //                                                 'Yes' => 'Yes',
    //                                                 'No' => 'No',
    //                                             ]),
    //                                         Forms\Components\TextInput::make('mtprf_contractorWorker')
    //                                             ->label('No. of Contractor/s\' / Workers:')
    //                                             ->integer()
                                        // ->default(0)
                                        // ->minValue(0),
    //                                         Forms\Components\TextInput::make('mtprf_independentContractor')
    //                                             ->label('No. of Independent Contractors:')
    //                                             ->integer()
                                        // ->default(0)
                                        // ->minValue(0),
    //                                     ]),
                                    
                                    
    //                                 Forms\Components\TextInput::make('mtprf_total')
    //                                     ->maxLength(255),
    //                             ])
    //                         ]),
    //                 Wizard\Step::make('Shoot Location')
    //                     ->schema([
    //                         Forms\Components\Repeater::make('MtprfShoot')
    //                             ->relationship()
    //                             ->schema([
    //                                 Section::make('Location')
    //                                     ->columns(2)
    //                                     ->schema([
    //                                         Forms\Components\TextInput::make('mtprf_shoot-address')
    //                                             ->label('Specific Address')
    //                                             ->maxLength(255),
    //                                         Forms\Components\FileUpload::make('mtprf_shoot-address')
    //                                             ->label('Vicinity Map'),
    //                                         ]),
    //                                 Section::make('Working Hours')
    //                                     ->columns(3)
    //                                     ->schema([
    //                                         Section::make('Start Date and Call Time ')
    //                                             ->columns(1)
    //                                             ->schema([
    //                                                 Forms\Components\DatePicker::make('mtprf_shoot-dateFrom')
    //                                                     ->label('Date'),
    //                                                 Forms\Components\TimePicker::make('mtprf_shoot-timeFrom')
    //                                                     ->label('From'),
    //                                             ]),
    //                                         Section::make('End Date and Time of Egress')
    //                                             ->columns(1)
    //                                             ->schema([
    //                                                 Forms\Components\DatePicker::make('mtprf_shoot-dateTo')
    //                                                     ->label('Date'),
    //                                                 Forms\Components\TimePicker::make('mtprf_shoot-timeTo')
    //                                                     ->label('To'),
    //                                             ]),
    //                                         Section::make('Working Hours of Minor')
    //                                             ->columns(1)
    //                                             ->schema([
    //                                                 Forms\Components\DatePicker::make('mtprf_shoot-minorDateTo')
    //                                                     ->label('Date'),
    //                                                 Forms\Components\TimePicker::make('mtprf_shoot-minorTimeFrom')
    //                                                     ->label('From'),
    //                                                 Forms\Components\TimePicker::make('mtprf_shoot-minorTimeTo')
    //                                                     ->label('To'),
    //                                             ]),
    //                                     ]),
    //                             ]),
    //                         Forms\Components\Textarea::make('mtprf_shoot-remarks')
    //                             ->label('Remarks')
    //                             ->maxLength(255),
    //                     ]),
                    
    //             ])
    //             ->submitAction(new HtmlString(Blade::render(<<<BLADE
    //                 <x-filament::button color="success" icon="heroicon-o-check" tag="button" type="submit" size="lg" wire:click="create" >
    //                     Submit
    //                     <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="animate-spin fi-btn-icon transition duration-75 h-5 w-5 text-white" wire:loading.delay.default="" wire:target="dispatchFormEvent">
    //                         <path clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
    //                         <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
    //                     </svg>
    //                 </x-filament::button>
    //             BLADE))),
    //         ])
    //         ->statePath('data')
            
    //         ;
        
    // }

    
    

}
