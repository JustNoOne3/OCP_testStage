<?php

namespace App\Filament\User\Resources\Month13thResource\Pages;

use App\Filament\User\Resources\Month13thResource;
use Filament\Resources\Pages\Page;
use App\Models\Month13th;

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
use App\Models\Establishment;

class Month13thSubmit extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = Month13thResource::class;

    protected static string $view = 'filament.user.resources.month13th-resource.pages.month13th-submit';

    protected ?string $heading = '13th Month Report';

    protected static ?string $breadcrumb = '13th Month';

    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }


    public function create()
    {
        Month13th::create($this->form->getState());

        Notification::make()
            ->title('Report Submitted')
            ->icon('heroicon-o-document-text')
            ->iconColor('success')
            ->send();
            
        return redirect('user');
    }

    public function form(Form $form): Form
    {
        $estab = Establishment::query()->where('est_id', Auth::user()->est_id)->first();
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Report Details')
                        ->schema([
                            Section::make()
                                ->columns(3)
                                ->schema([
                                    Forms\Components\TextInput::make('month13th_ownRep')
                                        ->label('Name of Employer\'s Representative')
                                        // ->default($estab->est_owner)
                                        ->columnSpan(1)
                                        ->required(),
                                    Forms\Components\TextInput::make('month13th_designation')
                                        ->label('Designation ')
                                        // ->default($estab->est_designation)
                                        ->columnSpan(1)
                                        ->required(),
                                    Forms\Components\TextInput::make('month13th_contact')
                                        ->label('Contact Number')
                                        ->columnSpan(1)
                                        // ->default($estab->est_contactNum)
                                        ->required()
                                        ->mask('0999-999-9999')
                                        ->placeholder('09XX-XXX-XXXX'),
                                ]),
                            Section::make()
                                ->columns(3)
                                ->schema([
                                    Forms\Components\Select::make('month13th_yearCovered')
                                        ->label('Year Covered by Report')
                                        ->placeholder('Select a year covered by this report.')
                                        ->options([
                                            '2019' => '2019',
                                            '2020' => '2020',
                                            '2021' => '2021',
                                            '2022' => '2022',
                                            '2023' => '2023',
                                            '2024' => '2024',
                                        ])
                                        ->native(false)
                                        ->columnSpan(1)
                                        
                                        ->required(),
                                    Forms\Components\TextInput::make('month13th_numWorkers')
                                        ->label('Total Number of Workers Benefitted')
                                        ->columnSpan(1)
                                        ->required(),
                                    Forms\Components\TextInput::make('month13th_amount')
                                        ->label('Total Amount of Benefits Granted')
                                        ->integer()
                                        ->columnSpan(1)
                                        ->required(),
                                ]), 
                        ]),
                    Wizard\Step::make('Number of Workers and Salary Range')
                        ->schema([
                            Section::make()
                                ->columns(2)
                                ->schema([
                                    Section::make()
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\TextInput::make('month13th_lessFive')
                                                ->label('< Php 5,000')
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0)
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_fiveTen')
                                                ->label('Php 5,001 - 10,000')
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0)
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_tenTwenty')
                                                ->label('Php 10,001 - 20,000')
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0)
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_twentyThirty')
                                                ->label('Php 20,001 - 30,000')
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0)
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_thirtyForty')
                                                ->label('Php 30,001 - 40,000')
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0)
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_fortyFifty')
                                                ->label('Php 40,001 - 50,000')
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0)
                                                ->required()
                                                ->inlineLabel(),
                                        ]),
                                    Section::make()
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\TextInput::make('month13th_fiftySixty')
                                                ->label('Php 50,001 - 60,000')
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0)
                                                ->required()
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_sixtySeventy')
                                                ->label('Php 60,001 - 70,000')
                                                ->integer()
                                                ->default(0)
                                                ->minValue(0)
                                                ->required()
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_seventyEighty')
                                                ->label('Php 70,001 - 80,000 ')
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0)
                                                ->required()
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_eightyNinety')
                                                ->label('Php 80,001 - 90,000')
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0)
                                                ->required()
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_ninetyHundred')
                                                ->label('Php 90,001 - 100,000')
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0)
                                                ->required()
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_moreHundred')
                                                ->label('> Php 100,001')
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0)
                                                ->required()
                                                ->inlineLabel(),
                                        ]),
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
            ->statePath('data')
            ;
    }
}
