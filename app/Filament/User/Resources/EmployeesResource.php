<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\EmployeesResource\Pages;
use App\Filament\User\Resources\EmployeesResource\RelationManagers;
use App\Models\Employees;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\TempEmp;
use App\Models\Establishment;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\CreateAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Filament\Forms\Components\Section;
use App\Models\Geocode;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Carbon\Carbon;

use Filament\Tables\Columns\ToggleColumn;

class EmployeesResource extends Resource
{
    protected static ?string $model = Employees::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    // protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'Employees';

    protected static ?string $navigationLabel = 'My Employees';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('emp_estabId')
                    ->hidden(),
                Section::make()
                    ->columns(4)
                    ->schema([
                        Forms\Components\TextInput::make('emp_lastName')
                            ->columnSpan(1)
                            ->label('Last Name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_firstName')
                            ->columnSpan(1)
                            ->label(' First Name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_middleName')
                            ->columnSpan(1)
                            ->label('Middle Name')
                            ->maxLength(255),
                        Forms\Components\Select::make('emp_extensionName')
                            ->columnSpan(1)
                            ->required()
                            ->label('Extension Name')
                            ->options([
                                'N/A' => 'N/A',
                                'JR' => 'JR',
                                'SR' => 'SR',
                                'I' => 'I',
                                'II' => 'II',
                                'III' => 'III',
                                'IV' => 'IV',
                                'V' => 'V',
                            ]),
                        Forms\Components\DatePicker::make('emp_birthday')
                            ->columnSpan(2)
                            ->label('Birthdate'),
                        Forms\Components\Select::make('emp_sex')
                            ->columnSpan(1)
                            ->label('Sex')
                            ->native(false)
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female',
                                'Prefer not to say' => 'Prefer not to say',
                            ]),
                        Forms\Components\Select::make('emp_civilStatus')
                            ->columnSpan(1)
                            ->label('Civil Status')
                            ->native(false)
                            ->options([
                                'Single' => 'Single',
                                'Married' => 'Married',
                                'Widowed' => 'Widowed',
                                'Separated' => 'Separated',
                                'Divorced' => 'Divorced',
                                'Prefer not to say' => 'Prefer not to say',
                            ]),
                        Forms\Components\TextInput::make('emp_houseNum')
                            ->label('House Number/ Building Name')
                            ->required()
                            ->columnSpan(2)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_street')
                            ->label('Street')
                            ->required()
                            ->columnSpan(2)
                            ->maxLength(255),
                        Forms\Components\Select::make('emp_region')
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
                        Forms\Components\Select::make('emp_province')
                            ->required()
                            ->live()
                            ->searchable()
                            ->native(false)
                            ->options(function (Get $get){
                                $num = intval($get('emp_region'));
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
                        Forms\Components\Select::make('emp_city')
                            ->required()
                            ->live()
                            ->searchable()
                            ->native(false)
                            ->options(function (Get $get){ 
                                
                                if(intval($get('emp_province'))){
                                    $num = intval($get('emp_province'));
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
                                    switch($get('emp_province')){
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
                        Forms\Components\Select::make('emp_barangay')
                            ->required()
                            ->live()
                            ->searchable()
                            ->native(false)
                            ->options(function (Get $get){
                                $num = intval($get('emp_city'));
                                $limit = $num + 1000;
                                return Geocode::query()
                                            ->where('geo_id', '>', $num)
                                            ->where('geo_id', '<', $limit)
                                            ->pluck('geo_name', 'geo_id');
                            })
                            ->label("Select Barangay"),
                    ]),
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('emp_wage')
                            ->required()
                            ->columnSpan(1)
                            ->label('Average Weekly Wage'),
                        Forms\Components\TextInput::make('emp_numDependents')
                            ->required()
                            ->columnSpan(1)
                            ->label('No. of Dependents'),
                        Forms\Components\TextInput::make('emp_serviceLength')
                            ->required()
                            ->columnSpan(2)
                            ->label('Length of Service'), 
                        Forms\Components\TextInput::make('emp_occupation')
                            ->required()
                            ->columnSpan(2)
                            ->label('Occupation'),
                        Forms\Components\TextInput::make('emp_yearsExp')
                            ->required()
                            ->columnSpan(2)
                            ->label('Years of Work'),
                        Forms\Components\Select::make('emp_employmentStatus')
                            ->required()
                            ->native(false)
                            ->label('Employment Status')
                            ->options([
                                'Regular' => 'Regular',
                                'Probationary' => 'Probationary',
                                'Fixed Term / Project Based' => 'Fixed Term / Project Based',
                                'Casual' => 'Casual',
                                'Regular - Seasonal' => 'Regular - Seasonal',
                                'Contractor\'s Employee' => 'Contractor\'s Employee',
                            ]),
                        Forms\Components\TimePicker::make('emp_shiftStart')
                            ->required()
                            ->seconds(false)
                            ->minutesStep(5)
                            ->live()
                            ->label('Work Shift Start'),
                        Forms\Components\TimePicker::make('emp_shiftEnd')
                            ->required()
                            ->seconds(false)
                            ->minutesStep(5)
                            ->live()
                            ->label('Work Shift End'),
                        Forms\Components\TextInput::make('emp_workHours')
                            ->live()
                            ->label('Hours of Work per Day'), 
                        Forms\Components\TextInput::make('emp_workDays')
                            ->required()
                            ->label('Days of Work per Week'),
                        
                    ]),
            // ])
            // ->action(function (array $data, string $model): TempEmp {
            //     $uuid = Uuid::uuid4()->toString();
            //     $microseconds = substr(explode('.', microtime(true))[1], 0, 6); // Limit microseconds to 6 digits
            //     $uuid = 'emp-' . substr($uuid, 0, 12) . '-' . $microseconds;

            //     $data['id'] = $uuid;
            //     $data['emp_estabId'] = Auth::user()->est_id;
            //     return $model::create($data);
            // })
            ]);
    }

    public static function table(Table $table): Table
    {
        if(!Auth::user()->est_id){
            redirect()->route('register-est');
        }
        return $table
            ->query(fn (Employees $employees) => $employees
                ->when(true , 
                    fn ($query) => $query->where('emp_estabId', Auth::user()->est_id))
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_lastName')
                    ->searchable()
                    ->label('Last Name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('emp_firstName')
                    ->searchable()
                    ->label('First Name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('emp_middleName')
                    ->searchable()
                    ->label('Middle Name')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('emp_extensionName')
                    ->searchable()
                    ->label('Name Extension')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_birthday')
                    ->date()
                    ->sortable()
                    ->label('Birthday')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_sex')
                    ->searchable()
                    ->label('Sex')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_civilStatus')
                    ->searchable()
                    ->label('Civil Status')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_houseNum')
                    ->searchable()
                    ->label('House Number')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_street')
                    ->searchable()
                    ->label('Sreet')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_region')
                    ->searchable()
                    ->label('Region')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_province')
                    ->searchable()
                    ->label('Province')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_city')
                    ->searchable()
                    ->label('City')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_barangay')
                    ->searchable()
                    ->label('Barangay')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_wage')
                    ->searchable()
                    ->label('Wage')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_numDependents')
                    ->searchable()
                    ->label('Number of Dependents')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_serviceLength')
                    ->searchable()
                    ->label('Length of Service')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_occupation')
                    ->searchable()
                    ->label('Occupation')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_yearsExp')
                    ->searchable()
                    ->label('Years of Experience')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_employmentStatus')
                    ->searchable()
                    ->label('Employment Status')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_shiftStart')
                    ->searchable()
                    ->label('Start of Shift')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_shiftEnd')
                    ->searchable()
                    ->label('End of Shift')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_workHours')
                    ->searchable()
                    ->label('Hours of Work/Day')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emp_workDays')
                    ->searchable()
                    ->label('Days of Work/Week')
                    ->toggleable(isToggledHiddenByDefault: true),
                ToggleColumn::make('emp_isActive')
                    ->tooltip(function (Employees $emp){
                        if($emp->emp_isActive == '1'){
                            return 'Employee is Active';
                        }else{
                            return 'Employee is Inactive';
                        }
                    })
                    ->label('Employment'),
                Tables\Columns\TextColumn::make('emp_isActive1')
                    ->badge()
                    ->state( function (Employees $emp){
                        if($emp->emp_isActive == '1'){
                            return 'Active';
                        }else{
                            return 'Inactive';
                        }
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Inactive' => 'gray',
                        'Active' => 'primary',
                    })
                    ->label('Status')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Empty')
            ->emptyStateDescription('You don\'t have any Registered Employee right now')
            ->emptyStateIcon('heroicon-o-bookmark');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployees::route('/create'),
            'view' => Pages\ViewEmployees::route('/{record}'),
            'edit' => Pages\EditEmployees::route('/{record}/edit'),
        ];
    }
}
