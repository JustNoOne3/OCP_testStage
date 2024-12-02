<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Month13th;
use App\Filament\Resources\User\Resources\Month13thResource;

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


class Submit13thMonth extends Page implements HasForms
{
    use InteractsWithForms;
    
    protected static string $resource = Month13thResource::class;

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
        Month13th::create($this->form->getState());

        Notification::make()
            ->title('Report Submitted')
            ->icon('heroicon-o-document-text')
            ->iconColor('success')
            ->send();
            
        return redirect('user');
    }

    protected function getSteps(): array
    {
        return [
            Wizard\Step::make('Report Details')
            ->schema([
                Section::make()
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('month13th_yearCovered')
                            ->label('Year Covered by Report')
                            ->placeholder('Select a year covered by this report.')
                            ->options(range(2019, now()->year))
                            ->native(false)
                            ->columnSpan(1)
                            
                            ->required(),
                        Forms\Components\TextInput::make('month13th_numWorkers')
                            ->label('Total Number of Workers Benifited')
                            ->columnSpan(1)
                            ->live()
                            ->afterStateUpdated(function (Set $set){
                                $estab = Establishment::query()->where('est_id', Auth::user()->est_id)->first();
                                $set('estabName', $estab->est_name);
                                $set('street', $estab->est_street);
                                $set('region', Geocode::query()->where('geo_id', $estab->region_id)->value('geo_name'));
                                $set('province', Geocode::query()->where('geo_id', $estab->province_id)->value('geo_name'));
                                $set('city', Geocode::query()->where('geo_id', $estab->city_id)->value('geo_name'));
                                $set('barangay', Geocode::query()->where('geo_id', $estab->barangay_id)->value('geo_name'));
                                $set('natureBusiness', $estab->psic_section);
                                $set('maleWorkers', $estab->est_numworkMale);
                                $set('femaleWorkers', $estab->est_numworkFemale);
                                $set('managerial', $estab->est_numworkManager);
                                $set('supervisory', $estab->est_numworkSupervisor);
                                $set('rankFile', $estab->est_numworkRanks);
                                $set('totalEmployees', $estab->est_numworkTotal);
                            })
                            ->required(),
                        Forms\Components\TextInput::make('month13th_amount')
                            ->label('Total Amount of Benefits Granted')
                            ->columnSpan(1)
                            ->required(),
                        Forms\Components\TextInput::make('month13th_ownRep')
                            ->label('Name of Employer\'s Representative')
                            ->columnSpan(1)
                            ->required(),
                        Forms\Components\TextInput::make('month13th_designation')
                            ->label('Designation ')
                            ->columnSpan(1)
                            ->required(),
                        Forms\Components\TextInput::make('month13th_contact')
                            ->label('Contact Number')
                            ->columnSpan(1)
                            ->required(),
                    ]),
            ]),
        Wizard\Step::make('Amount range and Number of Workers')
            ->schema([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\TextInput::make('month13th_lessFive')
                                    ->label('< Php 5,000.00')
                                    ->integer()
                                    ->default(0)
                                    ->minValue(0)
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_fiveTen')
                                    ->label('Php 5,001.00 - Php 10,000.00')
                                    ->integer()
                                    ->default(0)
                                    ->minValue(0)
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_tenTwenty')
                                    ->label('Php 10,001.00 - Php 20,000.00')
                                    ->integer()
                                    ->default(0)
                                    ->minValue(0)
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_twentyThirty')
                                    ->label('Php 20,001.00 - Php 30,000.00 ')
                                    ->integer()
                                    ->default(0)
                                    ->minValue(0)
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_thirtyForty')
                                    ->label('Php 30,001.00 - Php 40,000.00 ')
                                    ->integer()
                                    ->default(0)
                                    ->minValue(0)
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_fortyFifty')
                                    ->label('Php 40,001.00 - Php 50,000.00')
                                    ->integer()
                                    ->default(0)
                                    ->minValue(0)
                                    ->required()
                                    ->inlineLabel(),
                            ]),
                        Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\TextInput::make('month13th_fiftySixty')
                                    ->label('Php 50,001.00 - Php 60,000.00')
                                    ->integer()
                                    ->default(0)
                                    ->minValue(0)
                                    ->required()
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_sixtySeventy')
                                    ->label('Php 60,001.00 - Php 70,000.00 ')
                                    ->integer()
                                    ->default(0)
                                    ->minValue(0)
                                    ->required()
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_seventyEighty')
                                    ->label('Php 70,001.00 - Php 80,000.00 ')
                                    ->integer()
                                    ->default(0)
                                    ->minValue(0)
                                    ->required()
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_eightyNinety')
                                    ->label('Php 80,001.00 - Php 90,000.00')
                                    ->integer()
                                    ->default(0)
                                    ->minValue(0)
                                    ->required()
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_ninetyHundred')
                                    ->label('Php 90,001.00 - Php 100,000.00')
                                    ->integer()
                                    ->default(0)
                                    ->minValue(0)
                                    ->required()
                                    ->inlineLabel(),
                                Forms\Components\TextInput::make('month13th_moreHundred')
                                    ->label('> Php 100,001.00')
                                    ->integer()
                                    ->default(0)
                                    ->minValue(0)
                                    ->required()
                                    ->inlineLabel(),
                            ]),
                    ])
            ]),
        Wizard\Step::make('Review')
            ->schema([
                Section::make('Report Details')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('month13th_yearCovered')
                            ->readOnly(),
                        Forms\Components\TextInput::make('month13th_numWorkers')
                            ->readOnly(),
                        Forms\Components\TextInput::make('month13th_amount')
                            ->readOnly(),
                        Forms\Components\TextInput::make('month13th_ownRep')
                            ->readOnly(),
                        Forms\Components\TextInput::make('month13th_designation')
                            ->readOnly(),
                        Forms\Components\TextInput::make('month13th_contact')
                            ->readOnly(),
                    ]),
                Section::make('Affect Workers')
                    ->columns(2)
                    ->schema([
                        Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\TextInput::make('month13th_lessFive')
                                    ->readOnly()
                                    ->inlineLabel()
                                    ->label('< Php 5,000'),
                                Forms\Components\TextInput::make('month13th_fiveTen')
                                    ->readOnly()
                                    ->inlineLabel()
                                    ->label('Php 5,001 - 10,000'),
                                Forms\Components\TextInput::make('month13th_tenTwenty')
                                    ->readOnly()
                                    ->inlineLabel()
                                    ->label('Php 10,001 - 20,000'),
                                Forms\Components\TextInput::make('month13th_twentyThirty')
                                    ->readOnly()
                                    ->inlineLabel()
                                    ->label('Php 20,001 - 30,000'),
                                Forms\Components\TextInput::make('month13th_thirtyForty')
                                    ->readOnly()
                                    ->inlineLabel()
                                    ->label('Php 30,001 - 40,000'),
                                Forms\Components\TextInput::make('month13th_fortyFifty')
                                    ->readOnly()
                                    ->inlineLabel()
                                    ->label('Php 40,001 - 50,000'),
                            ]),
                        Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\TextInput::make('month13th_fiftySixty')
                                    ->readOnly()
                                    ->inlineLabel()
                                    ->label('Php 50,001 - 60,000'),
                                Forms\Components\TextInput::make('month13th_sixtySeventy')
                                    ->readOnly()
                                    ->inlineLabel()
                                    ->label('Php 60,001 - 70,000'),
                                Forms\Components\TextInput::make('month13th_seventyEighty')
                                    ->readOnly()
                                    ->inlineLabel()
                                    ->label('Php 70,001 - 80,000'),
                                Forms\Components\TextInput::make('month13th_eightyNinety')
                                    ->readOnly()
                                    ->inlineLabel()
                                    ->label('Php 80,001 - 90,000'),
                                Forms\Components\TextInput::make('month13th_ninetyHundred')
                                    ->readOnly()
                                    ->inlineLabel()
                                    ->label('Php 90,001 - 100,000'),
                                Forms\Components\TextInput::make('month13th_moreHundred')
                                    ->readOnly()
                                    ->inlineLabel()
                                    ->label('> Php 100,001'),
                            ]),
                    ]),
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('estabName')
                            ->label('Establishment Name')
                            ->readOnly(),
                            ]),
                Section::make('Location')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('street')
                            ->readOnly()
                            ->label("Floor / Bldg. No. / Street / Subdivision"),
                        Forms\Components\TextInput::make('region')
                            ->readOnly()
                            ->label("Region"),
                        Forms\Components\TextInput::make('province')
                            ->readOnly()
                            ->label("Province"),
                        Forms\Components\TextInput::make('city')
                            ->readOnly()
                            ->label("Municipality / City"),
                        Forms\Components\TextInput::make('barangay')
                            ->readOnly()
                            ->label("Barangay"),
                        
                    ]),
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('natureBusiness')
                            ->readOnly()
                            ->label("Nature of Business"),
                    ]),
                Section::make('Current Workers')
                    ->columns(2)
                    ->schema([
                        Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\TextInput::make('maleWorkers')
                                    ->label('Male Workers')
                                    ->readOnly(),
                                Forms\Components\TextInput::make('femaleWorkers')
                                    ->label('Female Workers')
                                    ->readOnly(),
                            ]),
                        Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\TextInput::make('managerial')
                                    ->label('Managerial Position')
                                    ->readOnly(),
                                Forms\Components\TextInput::make('supervisory')
                                    ->label('Supervisorial Position')
                                    ->readOnly(),
                                Forms\Components\TextInput::make('rankFile')
                                    ->label('Rank and File')
                                    ->readOnly(),
                            ]),
                        Section::make()
                            ->columnSpan(2)
                            ->schema([
                                Forms\Components\TextInput::make('totalEmployees')
                                ->label('Total Employees')
                                ->readOnly(),
                            ]),
                        Section::make()
                            ->description('By clicking submit, you are agreeing to the Terms and Conditions.')
                            ->schema([
                                Forms\Components\Checkbox::make('Terms')
                                    ->label('I hereby certify that the data provided by me for this online registration is true, accurate and correct to the latest business data.
                                    I further understand that any false statements may result in the denial of application for registration.')
                                    ->accepted()
                            ]),
                    ]),
            ]),
        ];
    }           
    
    


}
