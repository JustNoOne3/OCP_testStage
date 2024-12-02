<?php

namespace App\Livewire;

use App\Models\Establishment;
use App\Models\Geocode;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms;  
use Filament\Forms\Get;

use Illuminate\Support\Facades\Auth;

class EstRegister extends Component implements HasForms
{
    use InteractsWithForms;

    //public ?array $data = [];

    // public function mount(): void
    // {
    //     $this->form->fill();
    // }

    protected ?string $heading = 'Establishment Registration';
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Details')
                        ->schema([
                            Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('est_name')
                                        ->required()
                                        ->label("Name of Establishment")
                                        ->maxLength(255),
                                        ]),
                            Section::make('Location')
                                ->columns(2)
                                ->schema([
                                    Forms\Components\TextInput::make('est_street')
                                        ->required()
                                        ->label("Floor / Bldg. No. / Street / Subdivision")
                                        ->maxLength(255),
                                    Forms\Components\Select::make('region_id')
                                        ->required()
                                        ->live()
                                        ->searchable()
                                        // ->native(false)
                                        ->default(1)
                                        ->options([
                                            1 => 'test',
                                            1300000000 => 'National Capital Region (NCR)',
                                            1400000000 => 'Cordillera Administrative Region (CAR)',
                                            100000000 => 'Region I (Ilocos Region)',
                                            200000000 => 'Region II (Cagayan Valley)',
                                            300000000 => 'Region III (Central Luzon)',
                                            400000000 => 'Region IV-A (CALABARZON)',
                                            1700000000 => 'MIMAROPA Region',
                                            500000000 => 'Region V (Bicol Region)',
                                            600000000 => 'Region VI (Western Visayas)',
                                            700000000 => 'Region VII (Central Visayas)',
                                            800000000 => 'Region VIII (Eastern Visayas)',
                                            900000000 => 'Region IX (Zamboanga Peninsula)',
                                            1000000000 => 'Region X (Northern Mindanao)',
                                            1100000000 => 'Region XI (Davao Region)',
                                            1200000000 => 'Region XII (SOCCSKSARGEN)',
                                            1600000000 => 'Region XIII (Caraga)',
                                            1900000000 => 'Bangsamoro Autonomous Region in Muslim Mindanao (BARMM)',
                                        ])
                                        ->label("Select Region"),
                                    Forms\Components\Select::make('province_id')
                                        ->required()
                                        ->live()
                                        ->searchable()
                                        ->native(false)
                                        ->options(function (Get $get){
                                            $num = intval($get('region_id'));
                                            $limit = $num + 100000000;
                                            if($num == 1){
                                                dd($limit);
                                            }
                                            
                                            return Geocode::query()
                                                        ->where('geo_id', '>', $num)
                                                        ->where('geo_id', '<', $limit)
                                                        ->whereRaw('MOD(geo_id, 100000) = 0')
                                                        ->pluck('geo_name', 'geo_id');
                                        })
                                        ->label("Select Province"),
                                    Forms\Components\Select::make('city_id')
                                        ->required()
                                        ->live()
                                        ->searchable()
                                        ->native(false)
                                        ->options(function (Get $get){
                                            $num = intval($get('province_id'));
                                            $limit = $num + 100000;
                                            // dd($num, $limit);
                                            return Geocode::query()
                                                        ->where('geo_id', '>', $num)
                                                        ->where('geo_id', '<', $limit)
                                                        ->whereRaw('MOD(geo_id, 1000) = 0')
                                                        ->pluck('geo_name', 'geo_id');
                                        })
                                        ->label("Select Municipality / City"),
                                    Forms\Components\Select::make('barangay_id')
                                        ->required()
                                        ->live()
                                        ->searchable()
                                        ->native(false)
                                        ->options(function (Get $get){
                                            $num = intval($get('city_id'));
                                            $limit = $num + 1000;
                                            return Geocode::query()
                                                        ->where('geo_id', '>', $num)
                                                        ->where('geo_id', '<', $limit)
                                                        ->pluck('geo_name', 'geo_id');
                                        })
                                        ->label("Select Barangay"),
                                ]),
                            Section::make()
                                ->columns(2)
                                ->schema([
                                    Forms\Components\Select::make('psic_section')
                                        ->required()
                                        ->label("Nature of Business")
                                        ->options([
                                            1 => 'Transportation and Storage',
                                            2 => 'Agriculture, Forestry, and Fishing',
                                            3 => 'Other Services Actvities',
                                            4 => 'Arts, Entertainment and Recreation',
                                            5 => 'Human Health and Social Work Activities',
                                            6 => 'Education',
                                            7 => 'Administrative and Support Service Activities',
                                            8 => 'Professional, Scientific and Technical Activities',
                                            9 => 'Real Estate Activities',
                                            10 => 'Financial and Insurance Activities',
                                            11 => 'Information and Communication',
                                            12 => 'Accommodation and Food Service Activities',
                                            13 => 'Wholesale and Retail Trade; Repair og Motor Vehicles and Motorcycles',
                                            14 => 'Construction',
                                            15 => 'Water Supply; Sewerage, Waste Management and Remediation',
                                            16 => 'Electricity, Gas, Steam and Air Conditioning Supply',
                                            17 => 'Manufaturing',
                                            18 => 'Mining and Quarrying',
                                        ]),
                                    Forms\Components\TextInput::make('est_products')
                                        ->required()
                                        ->label("Major products/service/goods offered or sold")
                                        ->maxLength(255),
                                ]),
                            Section::make()
                                ->columns(2)
                                ->schema([
                                    Forms\Components\Select::make('est_class')
                                        ->required()
                                        ->label("Establishment Classification")
                                        ->options([
                                            1 => 'Head Office',
                                            2 => 'Branch',
                                            3 => 'Franchise',
                                        ]),
                                    Forms\Components\TextInput::make('est_tin')
                                        ->required()
                                        ->label("Company TIN")
                                        ->mask('999-999-999-999')
                                        ->placeholder('___-___-___-___'),
                                    Forms\Components\TextInput::make('est_sss')
                                        ->required()
                                        ->label("Company SSS")
                                        ->mask('99-9999999-9')
                                        ->placeholder('__-_______-_'),
                                    Forms\Components\Select::make('est_payment')
                                        ->required()
                                        ->label("Payment Method of Salary or other Benefits")
                                        ->options([
                                            1 => 'Through Banks',
                                            2 => 'Through E-Money (e.g. Gcash, PayMaya, etc)',
                                            3 => 'Through Cash Agents (e.g. Remittance Centers, and other Retail Outlets',
                                            4 => 'Through Cash',
                                            5 => 'Others'
                                        ]),
                                    Forms\Components\Select::make('est_yearImplemented')
                                        ->required()
                                        ->label("Year the payment method was implemented")
                                        ->options([
                                            1 => 'Since 2023',
                                            2 => 'Since 2022',
                                            3 => 'Since 2021',
                                            4 => 'Since 2020',
                                            5 => 'Since 2019',
                                            6 => '2018 and prior years',
                                        ]),
                                ]),
                            Section::make('Number of Workers')
                                ->columns(2)
                                ->schema([
                                    Section::make()
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\TextInput::make('est_numworkMale')
                                                ->required()
                                                ->columnSpan(1)
                                                ->label("Male")
                                                ->live()
                                                ->numeric(),
                                            Forms\Components\TextInput::make('est_numworkFemale')
                                                ->required()
                                                ->columnSpan(1)
                                                ->label("Female")
                                                ->live()
                                                ->numeric(),
                                        ]),
                                    Section::make()
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\TextInput::make('est_numworkManager')
                                                ->required()
                                                ->columnSpan(1)
                                                ->label("Managerial Employees")
                                                ->numeric(),
                                            Forms\Components\TextInput::make('est_numworkSupervisor')
                                                ->required()
                                                ->columnSpan(1)
                                                ->label("Supervisory")
                                                ->numeric(),
                                            Forms\Components\TextInput::make('est_numworkRanks')
                                                ->required()
                                                ->columnSpan(1)
                                                ->label("Rank and File")
                                                ->numeric(),
                                        ]),
                                    Section::make()
                                        ->columnSpan(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('est_numworkTotal')
                                                ->required()
                                                ->label("Total Employees")
                                                ->numeric(),
                                        ]),
                                    
                                ]),
                            Section::make()
                                ->description('Accepted files \n - PDF')
                                ->columns(1)
                                ->schema([
                                    Forms\Components\FileUpload::make('est_permit')
                                        ->label("Business Permit")
                                        ->required(),
                                    Forms\Components\FileUpload::make('est_govId')
                                        ->label("Government-Issued ID of Owner / Representative")
                                        ->required(),
                                ]),
                        ]),
                    Wizard\Step::make('Certification')
                        ->description('This is to certify the accuracy of data provided in the registration form.')
                        ->schema([
                            Section::make()
                                ->columns(2)
                                ->schema([
                                    Forms\Components\TextInput::make('est_owner')
                                        ->required()
                                        ->label("Name of Owner or Representative")
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('est_designation')
                                        ->required()
                                        ->label('Designation / Position')
                                        ->maxLength(255),
                                ]),
                            Section::make()
                                ->columns(3)
                                ->schema([
                                    Forms\Components\TextInput::make('est_telNum')
                                        ->maxLength(255)
                                        ->label('Telephone No.'),
                                    Forms\Components\TextInput::make('est_contactNum')
                                        ->required()
                                        ->label('Contact No.')
                                        ->numeric(),
                                    Forms\Components\TextInput::make('est_email')
                                        ->email()
                                        ->required()
                                        ->label('Email Address')
                                        ->maxLength(255),
                                ]),
                            Section::make()
                                ->description('Please Check and ensure that all the data are correct. By clicking submit, you are agreeing to the Terms and Conditions.')
                                ->schema([
                                    Forms\Components\Checkbox::make('Terms')
                                        ->label('I hereby certify that the data provided by me for this online registration is true, accurate and correct to the best of my knowledge.
                                        I further understand that any false statements may result in denial or revocation of application for registration.')
                                        ->accepted()
                                ]),
                        ]),
                ]),
            ])
            
            // ])
            //->statePath('data')
            ;
    }
    
    public function create(): void
    {

        $est = Establishment::create([
            $this->form->getState()
        ]);
    }

    public function render()
    {
        return view('livewire.est-register');
    }
}
