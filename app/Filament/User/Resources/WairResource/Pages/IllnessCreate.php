<?php

namespace App\Filament\User\Resources\WairResource\Pages;

use App\Filament\User\Resources\WairResource;
use Filament\Resources\Pages\Page;
use App\Models\IllnessReport;

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
use Illuminate\Contracts\Support\Htmlable;
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

class IllnessCreate extends Page implements HasForms
{
    use InteractsWithForms;


    protected static string $resource = WairResource::class;

    protected static string $view = 'filament.user.resources.wair-resource.pages.illness-create';

    protected ?string $heading = 'Illness Report';

    protected static ?string $breadcrumb = 'Illness';

    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }

    public function create()
    {
        IllnessReport::create($this->form->getState());

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
            // ->model(IllnessReport::class)
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Report Details')
                        ->description('Fill up the Form to Complete your Registration.')
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
                            Section::make('Preventive Measures')
                                ->columns(2)
                                ->schema([
                                    Forms\Components\TextInput::make('ip_engineering')
                                        ->required()
                                        ->label("Engineering")
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('ip_engineering_cost')
                                        ->required()
                                        ->label("Cost")
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
                                    Forms\Components\TextInput::make('ip_administrative')
                                        ->required()
                                        ->label("Administrative")
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('ip_administrative_cost')
                                        ->required()
                                        ->label("Cost")
                                        ->minValue(0)
                                        ->default(0)
                                        ->integer(),
                                    Forms\Components\TextInput::make('ip_ppe')
                                        ->required()
                                        ->label("PPE")
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('ip_ppe_cost')
                                        ->required()
                                        ->label("Cost")
                                        ->minValue(0)
                                        ->default(0)
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
