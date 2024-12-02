<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstablishmentResource\Pages;
use App\Filament\Resources\EstablishmentResource\RelationManagers;
use App\Models\Establishment;
use App\Models\Geocode;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Tabs;

use Filament\Tables\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use App\Filament\Exports\EstablishmentExporter;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\DatePicker;
use App\Models\MeetSchedule;
use App\Models\User;
use HusamTariq\FilamentTimePicker\Forms\Components\TimePickerField;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMeeting;



class EstablishmentResource extends Resource
{
    protected static ?string $model = Establishment::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Establishment Details')
                            ->columnSpan(3)
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('est_name')
                                            ->required()
                                            ->columnSpan(3)
                                            ->label("Name of Establishment")
                                            ->maxLength(255),
                                    ]),
                                Section::make('Establishment Adress')
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
                                                1800000000 => 'Negros Island Region',
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
                        Tab::make('Certification')
                            //->description('This is to certify the accuracy of data provided in the registration form.')
                            ->schema([
                                Section::make()
                                    ->description('This is to certify the accuracy of data provided in the registration form.')
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
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function() {
                if(Auth::user()->authority == '20'){
                    return Establishment::query()->where('created_at', '!=', null);
                }else{
                    return Establishment::query()->where('region_id',Auth::user()->authority);
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('est_name')
                    ->searchable()
                    ->wrap()
                    ->label('Establishent Name'),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->wrap()
                    ->state(function (Establishment $record)
                    {
                        $region = Geocode::query()->where('geo_id', $record->region_id)->value('geo_name');
                        $province = Geocode::query()->where('geo_id', $record->province_id)->value('geo_name');
                        $city = Geocode::query()->where('geo_id', $record->city_id)->value('geo_name');
                        $barangay = Geocode::query()->where('geo_id', $record->barangay_id)->value('geo_name');
                        // $address = $record->est_street." ".$barangay." ".$city." ".$province." ".$region;
                        if($record->province_id == $record->city_id){
                            $address = $record->est_street." ".$barangay." ".$province;
                        }else{
                            $address = $record->est_street." ".$barangay." ".$city." ".$province;
                        }
                        return $address;
                    })
                    ->label('Address'),
                Tables\Columns\TextColumn::make('psic_section')
                    ->label('Nature of Business')
                    ->searchable(),
                Tables\Columns\TextColumn::make('est_products')
                    ->label('Products')
                    ->searchable(),
                Tables\Columns\TextColumn::make('est_class')
                    ->label('Classification')
                    ->searchable(),
                Tables\Columns\TextColumn::make('est_tin')
                    ->label('TIN')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('est_sss')
                    ->label('SSS')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('est_payment')
                    ->label('Salary Payment Method')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('est_yearImplemented')
                    ->label('Year Implemented')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('est_numworkMale')
                    ->label('Male Workers')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('est_numworkFemale')
                    ->label('Female Workers')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('est_numworkManager')
                    ->label('Managerial Employees')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('est_numworkSupervisor')
                    ->label('Supervisorial Employees')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('est_numworkRanks')
                    ->label('Ranks and File')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('est_numworkTotal')
                    ->label('Total Employees')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('est_owner')
                    ->label('Business Owner')
                    ->searchable(),
                Tables\Columns\TextColumn::make('est_designation')
                    ->label('Designation'),
                Tables\Columns\TextColumn::make('est_telNum')
                    ->label('Telephone No.')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('est_contactNum')
                    ->label('Contact Number')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('est_email')
                    ->label('Email Address')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At ')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('gen_cert')
                    ->label('Generate COR')
                    ->icon('heroicon-s-document-arrow-down')
                    ->button()
                    ->color('success')
                    ->hidden(function (Establishment $record){
                        if(!$record->est_certIssuance == null){
                            return true;
                        }else{ 
                            return false;
                        }
                    })
                    ->action(
                        function (Establishment $record): void{
                            $record->est_certIssuance = now()->format('Y-m-d');
                            $record->save();
                            
                            session()->put('est_id', $record->est_id);
                            //return redirect()->route('admin-certificate');
                        }
                    ),
                Tables\Actions\Action::make('view_cert')
                    ->label('View COR')
                    ->icon('heroicon-s-eye')
                    ->button()
                    ->color('primary')
                    ->hidden(function (Establishment $record){
                        if(!$record->est_certIssuance == null){
                            return false;
                        }else{ 
                            return true;
                        }
                    })
                    ->action(
                        function (Establishment $record){
                            $record->est_certIssuance = now()->format('Y-m-d');
                            $record->save();
                            
                            session()->put('est_id', $record->est_id);
                            return redirect()->route('admin-certificate');
                        }
                    ),
                // Tables\Actions\Action::make('remove_cert')
                //     ->label('Remove COR')
                //     ->icon('heroicon-s-minus-circle')
                //     ->button()
                //     ->color('danger')
                //     ->hidden(function (Establishment $record){
                //         if(!$record->est_certIssuance == null){
                //             return false;
                //         }else{ 
                //             return true;
                //         }
                //     })
                //     ->action(
                //         function (Establishment $record): void{
                //             $record->est_certIssuance = null;
                //             $record->save();
                //         }
                //     ),

                Tables\Actions\Action::make('sched')
                    ->label('Request for Verification')
                    ->icon('heroicon-s-document-magnifying-glass')
                    ->color('warning')
                    ->button()
                    ->modalHeading('Schedule your Meeting')
                    ->form([
                        DatePicker::make('meet_date')
                            ->required()
                            ->native(false)
                            ->label("Select Date for the Scheduled Verification"),
                        TimePickerField::make('meet_time')
                            ->required()
                            ->okLabel("Confirm")
                            ->cancelLabel("Cancel")
                            ->label("Select Desired Time"),
                    ])
                    ->action(
                        function (array $data, Establishment $record) {
                            $meetId = rand(1000000, 9999999);
                            MeetSchedule::create([
                                'id' => $meetId,
                                'meet_estabId' => $record->est_id,
                                'meet_estEmail'=> $record->est_email,
                                'meet_date' => $data['meet_date'],
                                'meet_time'=> $data['meet_time'],
                            ]);
                            $meet = MeetSchedule::query()->where('id', $meetId)->first();

                            // $user = User::query()->where('est_id', $record->est_id)->value('email');
                            $user = 'adrianbonaobra@gmail.com';
                            Mail::to($user)
                                ->send(new VerificationMeeting($meet));

                            return;
                        }
                    )
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(EstablishmentExporter::class)
                    ->label('Export to Excel')
                    ->formats([
                        ExportFormat::Xlsx,
                    ])
                    ->fileName(date('Y-m-d') . '- Establishments'),
            ])
            ->emptyStateHeading('Empty')
            ->emptyStateDescription('There is no Establishments data yet')
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
            'index' => Pages\ListEstablishments::route('/'),
            // 'create' => Pages\CreateEstablishment::route('/create'),
            // 'view' => Pages\ViewEstablishment::route('/{record}'),
            // 'edit' => Pages\EditEstablishment::route('/{record}/edit'),
            //'viewEst' => App\Filament\User\Resources\EstablishmentResource\Pages\EstablishmentView::route('/(record}/viewEst'),
        ];
    }
}
