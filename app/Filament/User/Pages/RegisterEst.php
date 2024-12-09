<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;
use App\Models\Establishment;
use App\Models\Geocode;
use App\Models\User;
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
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Set;
use Closure;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Filament\Infolists\Components\ImageEntry;

use App\Models\PsicSection;
use App\Models\PsicDivision;
use App\Models\PsicGroup;
use App\Models\PsicClass;

class RegisterEst extends Page implements HasForms
{
    use InteractsWithForms;

    protected static bool $shouldRegisterNavigation = false;

    // protected static ?string $navigationLabel = 'Register for RULE 1020';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected ?string $heading = 'Establishment Registration';

    protected static string $view = 'filament.user.pages.register-est';

    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }

    public function create()
    {
        Establishment::create($this->form->getState());
        // Notification::make()
        //     ->title('Establishment is successfully Registered')
        //     ->icon('heroicon-o-document-text')
        //     ->iconColor('success')
        //     ->send();
        return redirect('user');

        
    }

    function set (Set $set){
        $set('est_numworkTotal', getTotal());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Details')
                        ->description('Fill up the Form to Complete your Registration.')
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
                                        ->native(false)
                                        ->options([
                                            1300000000 => 'National Capital Region (NCR)',
                                            1400000000 => 'Cordillera Administrative Region (CAR)',
                                            100000000 => 'Region I (Ilocos Region)',
                                            200000000 => 'Region II (Cagayan Valley)',
                                            300000000 => 'Region III (Central Luzon)',
                                            400000000 => 'Region IV-A (CALABARZON)',
                                            1700000000 => 'MIMAROPA Region',
                                            500000000 => 'Region V (Bicol Region)',
                                            600000000 => 'Region VI (Western Visayas)',
                                            1800000000 => 'Negros Island Region (NIR)',
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
                                            if($num == 1300000000){
                                                return [
                                                    'First District' => 'First District',
                                                    'Second District' => 'Second District',
                                                    'Third District' => 'Third District',
                                                    'Fourth District' => 'Fourth District',
                                                ];
                                            }
                                            if($num == 1800000000){
                                                return [
                                                    1804500000 => 'Negros Occidental',
                                                    1804600000 => 'Negros Oriental',
                                                    1806100000 => 'Siquijor',
                                                ];
                                            }
                                            if($num == 700000000){
                                                return [
                                                    701200000 => 'Bohol',
                                                    702200000 => 'Cebu',
                                                ];
                                            }
                                            $limit = $num + 100000000;
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
                                            
                                            if(intval($get('province_id'))){
                                                $num = intval($get('province_id'));
                                                $limit = $num + 100000;
                                                if($num == 1804500000){
                                                    return [
                                                        1830200000 => 'City of Bacolod',
                                                        1804502000 => 'City of Bago',
                                                        1804503000 => 'Binalbagan',
                                                        1804504000 => 'City of Cadiz',
                                                        1804505000 => 'Calatrava',
                                                        1804506000 => 'Candoni',
                                                        1804507000 => 'Cauayan',
                                                        1804508000 => 'Enrique B. Magalona',
                                                        1804509000 => 'City of Escalante',
                                                        1804510000 => 'City of Himamaylan',
                                                        1804511000 => 'Hinigaran',
                                                        1804512000 => 'Hinoba-an',
                                                        1804513000 => 'Ilog',
                                                        1804514000 => 'Isabela',
                                                        1804515000 => 'City of Kabankalan',
                                                        1804516000 => 'City of La Carlota',
                                                        1804517000 => 'La Castellana',
                                                        1804518000 => 'Manapla',
                                                        1804519000 => 'Moises Padilla',
                                                        1804520000 => 'Murcia',
                                                        1804521000 => 'Pontevedra',
                                                        1804522000 => 'Pulupandan',
                                                        1804523000 => 'City of Sagay',
                                                        1804524000 => 'City of San Carlos',
                                                        1804525000 => 'San Enrique',
                                                        1804526000 => 'City of Silay',
                                                        1804527000 => 'City of Sipalay',
                                                        1804528000 => 'City of Talisay',
                                                        1804529000 => 'Toboso',
                                                        1804530000 => 'Valladolid',
                                                        1804531000 => 'City of Victorias',
                                                        1804532000 => 'Salvador Benedicto',
                                                    ];
                                                }
                                                if($num == 702200000){
                                                    return [
                                                        702201000 => 'Alcantara',
                                                        702202000 => 'Alcoy',
                                                        702203000 => 'Alegria',
                                                        702204000 => 'Aloguinsan',
                                                        702205000 => 'Argao',
                                                        702206000 => 'Asturias',
                                                        702207000 => 'Badian',
                                                        702208000 => 'Balamban',
                                                        702209000 => 'Bantayan',
                                                        702210000 => 'Barili',
                                                        702211000 => 'City of Bogo',
                                                        702212000 => 'Boljoon',
                                                        702213000 => 'Borbon',
                                                        702214000 => 'City of Carcar',
                                                        702215000 => 'Carmen',
                                                        702216000 => 'Catmon',
                                                        730600000 => 'Cebu City (Capital)',
                                                        702218000 => 'Compostela',
                                                        702219000 => 'Consolacion',
                                                        702220000 => 'Cordova',
                                                        702221000 => 'Daanbantayan',
                                                        702222000 => 'Dalaguete',
                                                        702223000 => 'Danao City',
                                                        702224000 => 'Dumanjug',
                                                        702225000 => 'Ginatilan',
                                                        731100000 => 'Lapu Lapu City (OPON)',
                                                        702227000 => 'Liloan',
                                                        702228000 => 'Madridejos',
                                                        702229000 => 'Malabuyoc',
                                                        731300000 => 'Mandaue City',
                                                        702231000 => 'Medellin',
                                                        702232000 => 'Minglanilla',
                                                        702233000 => 'Moalboal',
                                                        702234000 => 'City of Naga',
                                                        702235000 => 'Oslob',
                                                        702236000 => 'Pilar',
                                                        702237000 => 'Pinamungajan',
                                                        702238000 => 'Poro',
                                                        702239000 => 'Ronda',
                                                        702240000 => 'Samboan',
                                                        702241000 => 'San Fernando',
                                                        702242000 => 'San Francisco',
                                                        702243000 => 'San Remigio',
                                                        702244000 => 'Santa Fe',
                                                        702245000 => 'Santander',
                                                        702246000 => 'Sibonga',
                                                        702247000 => 'Sogod',
                                                        702248000 => 'Tabogon',
                                                        702249000 => 'Tabuelan',
                                                        702250000 => 'City of Talisay',
                                                        702251000 => 'City of Toledo',
                                                        702252000 => 'Tuburan',
                                                        702253000 => 'Tudela',
                                                    ];
                                                }
                                                if(Geocode::query()
                                                ->where('geo_id', '>', $num)
                                                ->where('geo_id', '<', $limit)
                                                ->whereRaw('MOD(geo_id, 1000) = 0')
                                                ->count()>1){
                                                    return Geocode::query()
                                                            ->where('geo_id', '>', $num)
                                                            ->where('geo_id', '<', $limit)
                                                            ->whereRaw('MOD(geo_id, 1000) = 0')
                                                            ->pluck('geo_name', 'geo_id');
                                                }else{
                                                    return [$num => 'N/A'];
                                                }
                                            }else{
                                                switch($get('province_id')){
                                                    case 'First District':
                                                        return [
                                                            '1380601000' => 'Tondo I/II',
                                                            '1380602000' => 'Binondo',
                                                            '1380603000' => 'Quiapo',
                                                            '1380604000' => 'San Nicolas',
                                                            '1380605000' => 'Santa Cruz',
                                                            '1380606000' => 'Sampaloc',
                                                            '1380607000' => 'San Miguel',
                                                            '1380608000' => 'Ermita',
                                                            '1380609000' => 'Intramuros',
                                                            '1380610000' => 'Malate',
                                                            '1380611000' => 'Paco',
                                                            '1380612000' => 'Pandacan',
                                                            '1380613000' => 'Port Area',
                                                            '1380614000' => 'Santa Ana',
                                                        ];
                                                        break;
                                                    case 'Second District':
                                                        return [
                                                            '1380500000' => 'City of Mandaluyong',
                                                            '1380700000' => 'City of Marikina',
                                                            '1381200000' => 'City of Pasig',
                                                            '1381300000' => 'Quezon City',
                                                            '1381400000' => 'City of San Juan',
                                                        ];
                                                        break;
                                                    case 'Third District':
                                                        return [
                                                            '1380100000' => 'City of Caloocan',
                                                            '1380400000' => 'City of Malabon',
                                                            '1380900000' => 'City of Navotas',
                                                            '1381600000' => 'City of Valenzuela',
                                                        ];
                                                        break;
                                                    case 'Fourth District':
                                                        return [
                                                            '1380200000' => 'City of Las Pinas',
                                                            '1380300000' => 'City of Makati',
                                                            '1380800000' => 'City of Muntinlupa',
                                                            '1381000000' => 'City of Paranaque',
                                                            '1381100000' => 'Pasay City',
                                                            '1381701000' => 'Pateros',
                                                            '1381500000' => 'Taguig City',
                                                        ];
                                                        break;
                                                    default:
                                                        return [
                                                            'Invalid' => 'Invalid'
                                                        ];
                                                }
                                            }
                                            
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
                                
                            Section::make('Nature of Business')
                                ->description('Based on Philippine Standard Industrial Classification')
                                ->columns(2)
                                ->schema([
                                    Forms\Components\Select::make('psic_section')
                                        ->required()
                                        ->native(false)
                                        ->searchable()
                                        ->label("Section")
                                        ->options(PsicSection::query()
                                            ->pluck('section_name', 'section_code')),
                                    Forms\Components\Select::make('psic_division')
                                        ->required()
                                        ->native(false)
                                        ->searchable()
                                        ->label("Division")
                                        ->options(function (Get $get){
                                            return PsicDivision::query()
                                                ->where('division_code', 'like', $get('psic_section') . '%')
                                                ->pluck('division_name', 'division_code');
                                        }),
                                    Forms\Components\Select::make('psic_group')
                                        ->required()
                                        ->native(false)
                                        ->searchable()
                                        ->label("Group")
                                        ->options(function (Get $get){
                                            return PsicGroup::query()
                                                ->where('group_code', 'like', $get('psic_division') . '%')
                                                ->pluck('group_name', 'group_code');
                                        }),
                                    Forms\Components\Select::make('psic_class')
                                        ->required()
                                        ->native(false)
                                        ->searchable()
                                        ->label("Class")
                                        ->options(function (Get $get){
                                            return PsicClass::query()
                                                ->where('class_code', 'like', $get('psic_group') . '%')
                                                ->pluck('class_name', 'class_code');
                                        }),
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
                                        ->native(false)
                                        ->label("Establishment Classification")
                                        ->options([
                                            1 => 'Head Office',
                                            2 => 'Branch',
                                            3 => 'Franchise',
                                        ]),
                                    Forms\Components\TextInput::make('est_tin')
                                        ->required()
                                        ->label("Company TIN")
                                        ->length(15)
                                        ->mask('999-999-999-999')
                                        ->placeholder('___-___-___-___'),
                                    Forms\Components\TextInput::make('est_sss')
                                        ->required()
                                        ->length(12)
                                        ->label("Company SSS")
                                        ->mask('99-9999999-9')
                                        ->placeholder('__-_______-_'),
                                    Forms\Components\Select::make('est_payment')
                                        ->required()
                                        ->native(false)
                                        ->label("Payment Method of Salary or other Benefits")
                                        ->options([
                                            'Banks' => 'Through Banks',
                                            'E-Money' => 'Through E-Money (e.g. Gcash, PayMaya, etc)',
                                            'Cash Agents' => 'Through Cash Agents (e.g. Remittance Centers, and other Retail Outlets',
                                            'Cash' => 'Through Cash',
                                            'Others' => 'Others'
                                        ]),
                                    Forms\Components\Select::make('est_yearImplemented')
                                        ->required()
                                        ->native(false)
                                        ->label("Year the payment method was implemented")
                                        ->options([
                                            'Since 2024' => 'Since 2024',
                                            'Since 2023' => 'Since 2023',
                                            'Since 2022' => 'Since 2022',
                                            'Since 2021' => 'Since 2021',
                                            'Since 2020' => 'Since 2020', 
                                            'Since 2019' => 'Since 2019',
                                            '2018 and prior years' => '2018 and prior years',
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
                                                ->live(onBlur: true)
                                                ->default(0)
                                                ->afterStateUpdated(function(Set $set, Get $get, ?string $state){
                                                    if($get('est_numworkFemale')){
                                                        $total = intval($state) + intval($get('est_numworkFemale'));
                                                        $set('est_subTotal1', $total);
                                                    }else{
                                                        $set('est_subTotal1', intval($state));
                                                    }
                                                })
                                                ->numeric(),
                                            Forms\Components\TextInput::make('est_numworkFemale')
                                                ->required()
                                                ->columnSpan(1)
                                                ->label("Female")
                                                ->live(onBlur: true)
                                                ->default(0)
                                                ->afterStateUpdated(function(Set $set, Get $get, ?string $state){
                                                    if($get('est_numworkMale')){
                                                        $total = intval($state) + intval($get('est_numworkMale'));
                                                        $set('est_subTotal1', $total);
                                                    }else{
                                                        $set('est_subTotal1', intval($state));
                                                    }
                                                })
                                                ->numeric(),
                                            Forms\Components\TextInput::make('est_subTotal1')
                                                ->required()
                                                ->disabled()
                                                ->same('est_subTotal2')
                                                ->label("Total")
                                                ->validationMessages([
                                                    'same' => 'Number of Employees doesn\'t match.',
                                                ]),
                                            // Forms\Components\Placeholder::make('est_subTotal1')
                                            //     ->content(function (Get $get): int {
                                            //         return intval($get('est_numworkMale')) + intval($get('est_numworkFemale'));
                                            //     })
                                            //     ->label('Total'),
                                        ]),
                                    Section::make()
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\TextInput::make('est_numworkManager')
                                                ->required()
                                                ->columnSpan(1)
                                                ->label("Managerial Employees")
                                                ->live(onBlur: true)
                                                ->default(0)
                                                ->afterStateUpdated(function(Set $set, Get $get, ?string $state){
                                                    $total = intval($state) + intval($get('est_numworkSupervisor')) + intval($get('est_numworkRanks'));
                                                    $set('est_subTotal2', $total);
                                                })
                                                ->numeric(),
                                            Forms\Components\TextInput::make('est_numworkSupervisor')
                                                ->required()
                                                ->columnSpan(1)
                                                ->label("Supervisory")
                                                ->live(onBlur: true)
                                                ->default(0)
                                                ->afterStateUpdated(function(Set $set, Get $get, ?string $state){
                                                    $total = intval($state) + intval($get('est_numworkManager')) + intval($get('est_numworkRanks'));
                                                    $set('est_subTotal2', $total);
                                                })
                                                ->numeric(),
                                            Forms\Components\TextInput::make('est_numworkRanks')
                                                ->required()
                                                ->columnSpan(1)
                                                ->label("Rank and File")
                                                ->live(onBlur: true)
                                                ->default(0)
                                                ->afterStateUpdated(function(Set $set, Get $get, ?string $state){
                                                    $total = intval($state) + intval($get('est_numworkManager')) + intval($get('est_numworkSupervisor'));
                                                    $set('est_subTotal2', $total);
                                                })
                                                ->numeric(),
                                            Forms\Components\TextInput::make('est_subTotal2')
                                                ->required()
                                                ->disabled()
                                                ->same('est_subTotal1')
                                                ->label("Total")
                                                ->validationMessages([
                                                    'same' => 'Number of Employees doesn\'t match.',
                                                ]),
                                        ]),
                                    Section::make()
                                        ->columnSpan(2)
                                        ->schema([
                                            Forms\Components\Placeholder::make('est_numworkTotal')
                                                ->content(function (Get $get): int {
                                                    return intval($get('est_numworkMale')) + intval($get('est_numworkFemale'));
                                                })
                                                ->label('Total Employees'),
                                        ]),
                                        
                                    
                                ]),
                            Section::make()
                                ->description(fn():Htmlable => new HtmlString("
                                        <div style=\"color: gray; font-size: 12px;\">Max File Size: 10mb</div>
                                        <div style=\"color: gray; font-size: 12px;\">Accepted File Types</div>
                                        <div style=\"color: gray; font-size: 12px;\">&nbsp; - PDF</div>
                                        <div style=\"color: gray; font-size: 12px;\">&nbsp; - JPEG</div>
                                        <div style=\"color: gray; font-size: 12px;\">&nbsp; - PNG</div>
                                    ")
                                )
                                ->columns(1)
                                ->schema([
                                    Forms\Components\FileUpload::make('est_permit')
                                        ->label("Business Permit")
                                        ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                                        ->required(),
                                    Forms\Components\FileUpload::make('est_govId')
                                        ->label("Government-Issued ID of Owner / Representative")
                                        ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
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
                                        ->label('Telephone Number'),
                                    Forms\Components\TextInput::make('est_contactNum')
                                        ->required()
                                        ->label('Contact No.')
                                        ->length(13)
                                        ->mask('0999-999-9999')
                                        ->placeholder('09XX-XXX-XXXX'),
                                    Forms\Components\TextInput::make('est_email')
                                        ->email()
                                        ->default(function (){
                                            return Auth::user()->email;
                                        })
                                        ->required()
                                        ->label('Email Address')
                                        ->maxLength(255),
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
            ->statePath('data')
            
            ;
    }

    
}
