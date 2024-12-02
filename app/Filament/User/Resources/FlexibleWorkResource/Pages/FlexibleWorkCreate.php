<?php

namespace App\Filament\User\Resources\FlexibleWorkResource\Pages;

use App\Filament\User\Resources\FlexibleWorkResource;
use Filament\Resources\Pages\Page;
use App\Models\FlexibleWork;
use App\Livewire\FlexibleWorkTable;

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

class FlexibleWorkCreate extends Page
{
    protected static string $resource = FlexibleWorkResource::class;

    protected static string $view = 'filament.user.resources.flexible-work-resource.pages.flexible-work-create';

    protected ?string $heading = 'FWA Report';

    protected static ?string $breadcrumb = 'FWA';

    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }

    public function create()
    {
        FlexibleWork::create($this->form->getState());

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
                    Wizard\Step::make('FWA / AWS')
                        ->schema([
                            Section::make()
                                ->columns(2)
                                ->schema([
                                    Forms\Components\DatePicker::make('fwa_startDate')
                                    ->required()
                                        ->columnSpan(1)
                                        ->label('Start Date')
                                        ->native(false),
                                    Forms\Components\DatePicker::make('fwa_endDate')
                                    ->required()
                                        ->columnSpan(1)
                                        ->label('End Date')
                                        ->native(false),
                                    Forms\Components\Select::make('fwa_type')
                                    ->required()
                                        ->columnSpan(1)
                                        ->searchable()
                                        ->label('Select Type of FWA / AWS')
                                        ->native(false)
                                        ->live()
                                        ->options([
                                            'Transfer of Employees' => 'Transfer of Employees to another branch of the same employer',
                                            'Assignment  of Employees' => 'Assignment  of Employees to their function or position in the same or other branch or outlets of the same employer',
                                            'Reduction of Workdays per week' => 'Reduction of Workdays per week',
                                            'Reduction of Workhours per day' => 'Reduction of Workhours per day',
                                            'Job Rotation' =>'Job Rotation alternatively providing employees with work within the workweek or within the month',
                                            'Partial Closure of Establishment' =>'Partial Closure of Establishment where some unit or departments of the establishment are continued while other units or department are closed',
                                            'Rotation of Workers' => 'Rotation of Workers',
                                            'Forced Leave' => 'Forced Leave',
                                            'Broken-Time Schedule' =>'Broken-Time Schedule',
                                            'Compressed Work Week' => 'Compressed Work Week',
                                            'Telecommuting Work Arrangement' => 'Telecommuting Work Arrangement',
                                            'Others' => 'Others',
                                        ]),
                                    Forms\Components\TextInput::make('fwa_typeSpecify')
                                    ->required()
                                        ->columnSpan(1)
                                        ->label('Specify (Others)')
                                        ->hidden(function(Get $get){
                                            if($get('fwa_type') == 'Others'){
                                                return false;
                                            }else{
                                                return true;
                                            }
                                        }),
                                    Forms\Components\Select::make('fwa_reason')
                                    ->required()
                                        ->columnSpan(1)
                                        ->searchable()
                                        ->label('Select Primary Reason')
                                        ->native(false)
                                        ->live()
                                        ->options([
                                            'Economic Reasons' => 'Economic Reasons',
                                            'Competition from Imports' => 'Competition from Imports',
                                            'CMM' => 'Change in Management/merger',
                                            'Change in Management/merger' => 'Financial Losses',
                                            'Government Regulation' => 'Government Regulation',
                                            'High cost of Production' => 'High cost of Production',
                                            'Lack of Capital' => 'Lack of Capital',
                                            'Lack of Market' => 'Lack of Market/ slump in demand/ cancellation of orders',
                                            'Lack of Raw materials' => 'Lack of Raw materials',
                                            'Increase in minimum wage rate' => 'Increase in minimum wage rate',
                                            'Peso Depreciation' => 'Peso Depreciation',
                                            'Incompetitive Price of Products' => 'Incompetitive price of products Non-Economic Reasons',
                                            'Inventory' => 'Inventory',
                                            'Natural or Man-made Calamity' => 'Natural or man-made calamity',
                                            'Project Completion' => 'Project Completion',
                                            'Repair or General Maintenance' => 'Repair or general maintenance',
                                            'Work Stoppage Order' => 'Work Stoppage Order/ cease and desist order',
                                            'Others' => 'Others'
                                        ]),
                                    Forms\Components\TextInput::make('fwa_reasonSpecify')
                                    ->required()
                                        ->columnSpan(1)
                                        ->label('Specify (Others)')
                                        ->hidden(function(Get $get){
                                            if($get('fwa_reason') == 'Others'){
                                                return false;
                                            }else{
                                                return true;
                                            }
                                        }),
                                ]),
                            Section::make()
                                ->description(fn():Htmlable => new HtmlString("
                                            <div style=\"color: gray; font-size: 12px;\">Instructions:</div>
                                            <div style=\"color: gray; font-size: 12px; margin-left: 5px;\">1. Check the Employees to be Selected</div>
                                            <div style=\"color: gray; font-size: 12px; margin-left: 5px;\">2. Click the button 'ADD SELECTED'</div>
                                        ")
                                    )
                                ->schema([
                                    Livewire::make(EmployeeTable::class)
                                        ->key('employee-table'),
                                ])
                            // Livewire::make(FlexibleWorkTable::class)
                            //     ->key('flexible-work-table')
                        ]),
                    Wizard\Step::make('Certification')
                        ->schema([
                            Forms\Components\TextInput::make('fwa_owner')
                            ->required()
                                ->label('Name of Owner/Representative')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('fwa_designation')
                            ->required()
                                ->label('Designation')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('fwa_contact')
                            ->required()
                                ->label('Contact No.')
                                ->mask('0999-999-9999')
                                ->placeholder('09XX-XXX-XXXX'),
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
