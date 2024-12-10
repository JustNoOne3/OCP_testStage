<?php

namespace App\Filament\User\Resources\TeleReportResource\Pages;

use App\Filament\User\Resources\TeleReportResource;
use Filament\Resources\Pages\Page;
use App\Models\TeleReportHead;
use App\Models\TeleReportBranch;
use App\Models\TeleReportTemp;

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
use App\Livewire\TeleBranchTable;
use Filament\Notifications\Notification;

class TeleHeadCreate extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = TeleReportResource::class;

    protected static string $view = 'filament.user.resources.tele-report-resource.pages.tele-head-create';

    protected ?string $heading = 'Telecommuting report';

    protected static ?string $breadcrumb = 'Telecommuting';

    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }

    public function create()
    {
        $form_data = $this->form->getState('teleBranch_program');
        $temp_tele = TeleReportTemp::query()->where('teleBranch_estabId', Auth::user()->est_id)->get();
        // dd($this->form->getState());
        if($temp_tele != null){
            foreach ($temp_tele as $tele) {
                $attributes = $tele->toArray();
                $attributes['teleBranch_program'] = $form_data['teleHead_program'];
                $attributes['teleBranch_employer'] = $form_data['teleHead_employer'];
                $attributes['teleBranch_designation'] = $form_data['teleHead_designation'];
                $attributes['teleBranch_contact'] = $form_data['teleHead_contact'];
                session()->put('tele_id', $attributes['id']);
                session()->put('tele_branch', $attributes['teleBranch_estabId']);
                TeleReportBranch::create($attributes);
                TeleReportTemp::where('id', $attributes['id'])->delete();
            }
        }
        TeleReportHead::create($this->form->getState());

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
                    Wizard\Step::make('Principal Establishment')
                        ->description('Main Office')
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
                                                    Forms\Components\TextInput::make('teleHead_manageMale')
                                                        ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('teleHead_manageFemale')
                                                        ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                ]),
                                            Section::make('Supervisory')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('teleHead_superMale')
                                                        ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('teleHead_superFemale')
                                                        ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                ]),
                                            Section::make('Rank and File')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('teleHead_rankMale')
                                                        ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('teleHead_rankFemale')
                                                        ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                ]),
                                            // Forms\Components\TextInput::make('teleHead_total')
                                            //     // ->required()
                                            //     ->columnSpan(2)
                                            //     ->label("Total")
                                            //     // ->disabled()
                                            //     ->maxLength(255),
                                            Forms\Components\Placeholder::make('teleHead_total')
                                                ->content(function (Get $get): int {
                                                    return intval($get('teleHead_manageMale')) + 
                                                            intval($get('teleHead_manageFemale')) + 
                                                            intval($get('teleHead_superMale')) + 
                                                            intval($get('teleHead_superFemale')) + 
                                                            intval($get('teleHead_rankMale')) + 
                                                            intval($get('teleHead_rankFemale'));
                                                })
                                                ->label('Total'),
                                            
                                            
                                        ]),
                                    Section::make('Special Group of Workers Covered')
                                        ->columnSpan(1)
                                        ->columns(2)
                                        ->schema([
                                            Section::make('Persons with Disability')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('teleHead_disabMale')
                                                        ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('teleHead_disabFemale')
                                                        ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                ]),
                                            Section::make('Solo Parent')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('teleHead_soloperMale')
                                                        ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('teleHead_soloperFemale')
                                                        ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                ]),
                                            Section::make('Immunocompromised ')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('teleHead_immunoMale')
                                                        ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('teleHead_immunoFemale')
                                                        ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                ]),
                                            Section::make('With Mental Health Condition')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('teleHead_mentalMale')
                                                        ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('teleHead_mentalFemale')
                                                        ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                ]),
                                            Section::make('Senior Citizen')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('teleHead_seniorMale')
                                                        ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('teleHead_seniorFemale')
                                                        ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                ]),
                                            // Forms\Components\TextInput::make('teleHead_specialTotal')
                                            //     // ->required()
                                            //     ->columnSpan(2)
                                            //     ->label("Total")
                                            //     // ->disabled()
                                            //     ->maxLength(255),
                                            Forms\Components\Placeholder::make('teleHead_specialTotal')
                                                ->content(function (Get $get): int {
                                                    return intval($get('teleHead_disabMale')) + 
                                                            intval($get('teleHead_disabFemale')) + 
                                                            intval($get('teleHead_soloperMale')) + 
                                                            intval($get('teleHead_soloperFemale')) + 
                                                            intval($get('teleHead_immunoMale')) + 
                                                            intval($get('teleHead_immunoFemale')) + 
                                                            intval($get('teleHead_mentalMale')) + 
                                                            intval($get('teleHead_mentalFemale')) + 
                                                            intval($get('teleHead_seniorMale')) + 
                                                            intval($get('teleHead_seniorFemale'));
                                                })
                                                ->label('Total'),
                                        ]),
                                    Section::make('Telecommuting Workplace')
                                        ->schema([
                                            Forms\Components\Select::make('teleHead_workspace')
                                                ->label('Select Alternative Workplace')
                                                ->native(false)
                                                ->options([
                                                    'Branch Office (including Satellite Offices and Hubs)' => 'Branch Office (including Satellite Offices and Hubs) ',
                                                    'Employee\'s Residence' => 'Employee\'s Residence',
                                                    'Pre-selected by the company' => 'Pre-selected by the company',
                                                    'At the discretion of the employee' => 'At the discretion of the employee ',
                                                    'Others' => 'Others',
                                                ])
                                                ->live(),
                                            Forms\Components\TextInput::make('teleHead_workspace_others')
                                                ->label('Please Specify')
                                                ->hidden(function (Get $get){
                                                    if ($get('teleHead_workspace') == 'Others'){
                                                        return false;
                                                    }else{
                                                        return true;
                                                    }
                                                }),
                                            
                                        ]),
                                    Section::make('Functional Areas Covered by the Telecommuting Program')
                                        ->schema([
                                            Forms\Components\Select::make('teleHead_areasCovered')
                                                ->label('( Click All that Applies)')
                                                ->native(false)
                                                ->options([
                                                    'Research and Development' => 'Research and Development',
                                                    'Product Design and Development' => 'Product Design and Development',
                                                    'Sales and Customer Support' => 'Sales and Customer Support',
                                                    'Marketing and Brand Management' => 'Marketing and Brand Management',
                                                    'Corporate Communication and Social Media Marketing' => 'Corporate Communication and Social Media Marketing',
                                                    'Finance and Administrative functions/task' => 'Finance and Administrative functions/task',
                                                    'Financial Management, Accounting, Audit, Controllership' => 'Financial Management, Accounting, Audit, Controllership',
                                                    'Human Resource Management' => 'Human Resource Management',
                                                    'IT and related Works' => 'IT and related Works',
                                                    'Executive functions/tasks' => 'Executive functions/tasks',
                                                    'Materials Management / Procurement' => 'Materials Management / Procurement',
                                                    'Engineering' => 'Engineering',
                                                    'Others' => 'Others'
                                                ])
                                                // ->gridDirection('row')
                                                ->live(),
                                            Forms\Components\TextInput::make('teleHead_areasCovered_others')
                                                ->label('Please Specify')
                                                ->hidden(function (Get $get){
                                                    if ($get('teleHead_areasCovered') == 'Others'){
                                                        return false;
                                                    }else{
                                                        return true;
                                                    } 
                                                }),
                                        ])
                                    
                                    
                                ]),
                            
                        ]),
                    Wizard\Step::make('Branch Report')
                        ->schema([
                            Livewire::make(TeleBranchTable::class)
                                ->key('employee-table'),
                        ]),
                    Wizard\Step::make('Certification')
                        ->schema([
                            Section::make()
                                ->columns(2)
                                ->schema([
                                    Forms\Components\FileUpload::make('teleHead_program')
                                        ->label("Upload Telecommuting Program")
                                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                                        ->columnSpan(2),
                                    Forms\Components\TextInput::make('teleHead_employer')
                                        ->label("Owner / Employer")
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('teleHead_designation')
                                        ->label("Designation")
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('teleHead_contact')
                                        ->label("Contact Number:")
                                        ->maxLength(255)
                                        ->mask('0999-999-9999')
                                        ->placeholder('09XX-XXX-XXXX'),
                                        
                                ]),
                        ]),
                ])
                ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button wire:click="create" color="success" icon="heroicon-o-check" tag="button" type="submit" size="lg" >
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
