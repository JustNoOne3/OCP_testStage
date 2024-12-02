<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Pages\Page;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use App\Models\Establishment;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms;  
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Filament\Forms\Get;
use Filament\Forms\Components\Actions\Action;

class TeleReportHeadForm extends Component implements HasForms
{
    use InteractsWithForms;

    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    public function mount(): void
    {
        // $this->form->fill();
    }


    public function create()
    {
        Establishment::create($this->form->getState());
        return redirect('user');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Principal Establishment')
                        ->description('Main Office / Head Office')
                        ->schema([
                            Section::make()
                                ->columns(2)
                                ->schema([
                                    Section::make('Worker\'s Covered')
                                        ->columnSpan(1)
                                        ->columns(2)
                                        ->schema([
                                            Section::make('Managerial Employees')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('manager_male')
                                                        // ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('manager_female')
                                                        // ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->numeric(),
                                                ]),
                                            Section::make('Supervisory')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('supervisor_male')
                                                        // ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('supervisor_female')
                                                        // ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->numeric(),
                                                ]),
                                            Section::make('Rank and File')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('rankFile_male')
                                                        // ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('rankFile_female')
                                                        // ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->numeric(),
                                                ]),
                                            Forms\Components\TextInput::make('employee_total')
                                                // ->required()
                                                ->columnSpan(2)
                                                ->label("Total")
                                                ->disabled()
                                                ->maxLength(255),
                                            // Forms\Components\Actions\Action::make('myModalActionSADA')
                                            //         ->label('Open')
                                            //         ->action(function ($model) {
                                            //             // do something
                                            //         }),
                                        ]),
                                    Section::make('Special Group of Workers Covered')
                                        ->columnSpan(1)
                                        ->columns(2)
                                        ->schema([
                                            Section::make('Persons with Disability')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('manager_male')
                                                        // ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('manager_female')
                                                        // ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->numeric(),
                                                ]),
                                            Section::make('Solo Parent')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('supervisor_male')
                                                        // ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('supervisor_female')
                                                        // ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->numeric(),
                                                ]),
                                            Section::make('Immunocompromised ')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('immuno_male')
                                                        // ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('immuno_female')
                                                        // ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->numeric(),
                                                ]),
                                            Section::make('With Mental Health Condition')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('mental_male')
                                                        // ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('mental_female')
                                                        // ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->numeric(),
                                                ]),
                                            Section::make('Senior Citizen')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('Sernior_mle')
                                                        // ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('rankFile_female')
                                                        // ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->numeric(),
                                                ]),
                                            Forms\Components\TextInput::make('employee_total')
                                                // ->required()
                                                ->columnSpan(2)
                                                ->label("Total")
                                                ->disabled()
                                                ->maxLength(255),
                                        ]),
                                    Section::make('Telecommuting Workplace')
                                        ->schema([
                                            Forms\Components\CheckboxList::make('workplace')
                                                ->label('Alternative Workplace')
                                                ->options([
                                                    '1' => 'Branch Office (including Satellite Offices and Hubs) ',
                                                    '2' => 'Employee\'s Residence',
                                                    '3' => 'Co-Working Space ',
                                                    '4' => 'Others'
                                                ])
                                                ->live(),
                                            Forms\Components\CheckboxList::make('addtl_workplace')
                                                ->label('')
                                                ->options([
                                                    '5' => 'Pre-selected by the company',
                                                    '6' => 'At the discretion of the employee '
                                                ])
                                                ->hidden(function (Get $get){
                                                    if ($get('workplace') == '3'){
                                                        return false;
                                                    }else{
                                                        return true;
                                                    }
                                                }),
                                            Forms\Components\TextInput::make('cstm_workplace')
                                                ->label('Please Specify')
                                                ->hidden(function (Get $get){
                                                    if ($get('workplace') == '4'){
                                                        return false;
                                                    }else{
                                                        return true;
                                                    }
                                                }),
                                            
                                        ]),
                                    Section::make('Functional Areas Covered by the Telecommuting Program')
                                        ->schema([
                                            Forms\Components\CheckboxList::make('areas_covered')
                                                ->label('')
                                                ->options([
                                                    '1' => 'Research and Development',
                                                    '2' => 'Product Design and Development',
                                                    '3' => 'Sales and Customer Support',
                                                    '4' => 'Marketing and Brand Management',
                                                    '5' => 'Corporate Communication and Social Media Marketing',
                                                    '6' => 'Finance and Administrative functions/task',
                                                    '7' => 'Financial Management, Accounting, Audit, Controllership',
                                                    '8' => 'Human Resource Management',
                                                    '9' => 'IT and related Works',
                                                    '10' => 'Executive functions/tasks',
                                                    '11' => 'Materials Management / Procurement',
                                                    '12' => 'Engineering',
                                                    '13' => 'Others'
                                                ])
                                                ->columns(2)
                                                ->gridDirection('row')
                                                ->live(),
                                            Forms\Components\TextInput::make('areas_covered_addtl')
                                                ->label('Please Specify')
                                                ->hidden(function (Get $get){
                                                    if ($get('areas_covered') == '13'){
                                                        return false;
                                                    }else{
                                                        return true;
                                                    }
                                                }),
                                        ])
                                ]),
                            
                        ]),
                    Wizard\Step::make('Branch')
                        ->description('Satellite / Hub Office')
                        ->schema([
                            Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('est_name')
                                        // ->required()
                                        ->label("Name of Establishment")
                                        ->maxLength(255),
                                    Forms\Components\Actions::make([
                                        Forms\Components\Actions\Action::make('testAction')
                                            ->action(function (){
                                                dd('test action');
                                            }),
                                    ]),
                                ]),
                        ]),
                    Wizard\Step::make('Certification')
                        ->schema([
                            Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('est_name')
                                        // ->required()
                                        ->label("Name of Establishment")
                                        ->maxLength(255),
                                ]),
                        ]),
                ])
                ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button color="success" icon="heroicon-o-check" tag="button" type="submit" size="lg" >
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

    public function render()
    {
        return view('livewire.tele-report-head-form');
    }

}
