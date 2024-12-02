<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\MtprfResource\Pages;
use App\Filament\User\Resources\MtprfResource\RelationManagers;
use App\Models\Mtprf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Set;
use Closure;
use Filament\Forms\Components\Livewire;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Forms\Components\Textarea;
use App\Livewire\MtprfRepeater;

class MtprfResource extends Resource
{
    protected static ?string $model = Mtprf::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'EGL Report';

    protected static ?string $pluralModelLabel = 'EGL Report';

    protected static ?string $navigationLabel = 'Eddie Garcia Law';

    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('mtprf_companyName')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_companyType')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_director')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_representativeOwner')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_movieNamev')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_productionManager')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_pmEmail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_pmContactNum')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_projectDuration')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_numDays')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_15male')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_15female')
                    ->searchable(),
                Tables\Columns\TextColumn::make(' mtprf_18male')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_18female')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_19male')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_19female')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_60male')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_60female')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_total')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_childPermit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_contractorWorker')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_independentContractor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_safetyOfficer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_safetyOfficer_contact')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_firstAide')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_firstAide_contact')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_safeHealthCommittee')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_safeHealthCommittee_contact')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_hospitalMoa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_hospitalMoa_contact')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_safetyProgram')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_permits')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_riskClass')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_firearms')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_actionPlan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_animalHandling')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_emergencyTransport')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_others')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_decorumCommitee')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_representative')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_representativeAgent')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_representativeSupervisor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_representativeRankFile')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_policy_harrassment')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_policy_mentalHealth')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_remarks')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_gbv_affectedTotal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_gbv_affectedMale')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_gbv_affectedFemale')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_gbv_affectedLgbtq')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_gbv_offenderTotal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_gbv_offenderMale')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_gbv_offenderFemale')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_gbv_offenderLgbtq')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_preparedBy')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_designation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_submissionDate')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_estabId')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListMtprves::route('/'),
            'create' => Pages\CreateMtprf::route('/create'),
            'edit' => Pages\EditMtprf::route('/{record}/edit'),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            // Wizard::make([
            //     Wizard\Step::make('Report Details')
            //         ->description('Fill up the Form.')
            //         ->schema([
            //             Section::make('I. Establishment Profile')
            //                 ->columns(3)
            //                 ->schema([
            //                     Forms\Components\TextInput::make('mtprf_companyName')
            //                         ->label('Name of Production Outfit/Company')
            //                         ->columnSpan(1)
            //                         ->maxLength(255),
            //                     Forms\Components\Select::make('mtprf_companyType')
            //                         ->label('Type')
            //                         ->columnSpan(1)
            //                         ->native(false)
            //                         ->options([
            //                             'Employer' => 'Employer',
            //                             'Contractor' => 'Contractor',
            //                             'Principal' => 'Principal',
            //                         ]),
            //                     Forms\Components\TextInput::make('mtprf_representativeOwner')
            //                         ->label('Name of Authorized Representative')
            //                         ->columnSpan(1)
            //                         ->maxLength(255),
            //                     Forms\Components\TextInput::make('mtprf_director')
            //                         ->label('Name of Director/Production Manager')
            //                         ->columnSpan(2)
            //                         ->maxLength(255),
            //                     Forms\Components\TextInput::make('mtprf_email')
            //                         ->label('Email')
            //                         ->columnSpan(1)
            //                         ->email()
            //                         ->maxLength(255),
            //                     Forms\Components\TextInput::make('mtprf_address')
            //                         ->label('Principal Address')
            //                         ->columnSpan(2)
            //                         ->maxLength(255),
            //                     Forms\Components\TextInput::make('mtprf_number')
            //                         ->label('Contact Number')
            //                         ->columnSpan(1)
            //                         ->maxLength(255),
            //                 ]),


            //             Section::make('II. Production Profile')
            //                 ->columns(3)
            //                 ->schema([
            //                     Forms\Components\TextInput::make('mtprf_movieNamev')
            //                         ->label('Name of Movie or Television Project:')
            //                         ->columnSpan(3)
            //                         ->maxLength(255),
            //                     Forms\Components\TextInput::make('mtprf_productionManager')
            //                         ->label('Name of Production Manager/Focal Person')
            //                         ->columnSpan(1)
            //                         ->maxLength(255),
            //                     Forms\Components\TextInput::make('mtprf_pmEmail')
            //                         ->label('Email')
            //                         ->columnSpan(1)
            //                         ->maxLength(255),
            //                     Forms\Components\TextInput::make('mtprf_pmContactNum')
            //                         ->label('Mobile Number')
            //                         ->columnSpan(1)
            //                         ->maxLength(255),
            //                     Forms\Components\DatePicker::make('mtprf_projectDuration')
            //                         ->label('Project Duration')
            //                         ->columnSpan(1),
            //                     Forms\Components\TextInput::make('mtprf_numDays')
            //                         ->label('Estimated Number of days')
            //                         ->minValue(0)
            //                         ->default(0)
            //                         ->columnSpan(1)
            //                         ->integer(),
            //                 ]),
            //             Section::make('Workers\' Profile')
            //                 ->columns(3)
            //                 ->schema([
            //                     Section::make()
            //                         ->columns(2)
            //                         ->columnSpan(2)
            //                         ->schema([
            //                             Forms\Components\TextInput::make('mtprf_15male')
            //                                 ->label('<15 y/o Male')
            //                                 ->integer()
            //                                 ->default(0)
            //                                 ->minValue(0)
            //                                 ->maxLength(255),
            //                             Forms\Components\TextInput::make('mtprf_15female')
            //                                 ->label('<15 y/o Female')
            //                                 ->integer()
            //                                 ->default(0)
            //                                 ->minValue(0)
            //                                 ->maxLength(255),
            //                             Forms\Components\TextInput::make(' mtprf_18male')
            //                                 ->label('15-18 y/o Male')
            //                                 ->integer()
            //                                 ->default(0)
            //                                 ->minValue(0)
            //                                 ->maxLength(255),
            //                             Forms\Components\TextInput::make('mtprf_18female')
            //                                 ->label('15-18 y/o Female')
            //                                 ->integer()
            //                                 ->default(0)
            //                                 ->minValue(0)
            //                                 ->maxLength(255),
            //                             Forms\Components\TextInput::make('mtprf_19male')
            //                                 ->label('19-59 y/o Male')
            //                                 ->integer()
            //                                 ->default(0)
            //                                 ->minValue(0)
            //                                 ->maxLength(255),
            //                             Forms\Components\TextInput::make('mtprf_19female')
            //                                 ->label('19-59 y/o Female')
            //                                 ->integer()
            //                                 ->default(0)
            //                                 ->minValue(0)
            //                                 ->maxLength(255),
            //                             Forms\Components\TextInput::make('mtprf_60male')
            //                                 ->label('>59 y/o Male')
            //                                 ->integer()
            //                                 ->default(0)
            //                                 ->minValue(0)
            //                                 ->maxLength(255),
            //                             Forms\Components\TextInput::make('mtprf_60female')
            //                                 ->label('>59 y/o Female')
            //                                 ->integer()
            //                                 ->default(0)
            //                                 ->minValue(0)
            //                                 ->maxLength(255),
            //                         ]),
            //                     Section::make()
            //                         ->columnSpan(1)
            //                         ->schema([
            //                             Forms\Components\ToggleButtons::make('mtprf_childPermit')
            //                                 ->label('Child Permit')
            //                                 ->grouped()
            //                                 ->options([
            //                                     'Yes' => 'Yes',
            //                                     'No' => 'No',
            //                                 ])
            //                                 ->colors([
            //                                     'Yes' => 'success',
            //                                     'No' => 'danger',
            //                                 ])
            //                                 ->icons([
            //                                     'Yes' => 'heroicon-o-check',
            //                                     'No' => 'heroicon-o-x-mark',
            //                                 ])
            //                                 ,
            //                             Forms\Components\TextInput::make('mtprf_contractorWorker')
            //                                 ->label('No. of Contractor/s\' Workers:')
            //                                 ->minValue(0)
            //                                 ->default(0)
            //                                 ->integer(),
            //                             Forms\Components\TextInput::make('mtprf_independentContractor')
            //                                 ->label('No. of Independent Contractors:')
            //                                 ->minValue(0)
            //                                 ->default(0)
            //                                 ->integer(),
            //                         ]),
            //                 ])
            //         ]), //step
            //     Wizard\Step::make('Shoot Location')
            //         ->schema([
            //             Forms\Components\Repeater::make('mtprfShoot')
            //                 ->label(' ')
            //                 ->columns(3)
            //                 ->relationship()
            //                 ->addActionLabel('+ Additional Location Shoot')
            //                 ->schema([
            //                     Section::make('Location')
            //                         ->columnSpan(1)
            //                         ->schema([
            //                             Forms\Components\Textarea::make('shoot_address')
            //                                 ->label('Specific Address')
            //                                 ->maxLength(255),
            //                             Forms\Components\FileUpload::make('shoot_map')
            //                                 ->label('Vicinity Map'),
            //                             ]),
            //                     Forms\Components\Repeater::make('mtprf_workHours')
            //                         ->label(' ')
            //                         ->columnSpan(2)
            //                         ->addActionLabel('+ Additional Working Hours')
            //                         ->schema([
            //                             Section::make('Working Hours')
            //                                 ->columnSpan(1)
            //                                 ->columns(3)
            //                                 ->schema([
            //                                     Section::make('Start Date and Call Time ')
            //                                         ->columns(1)
            //                                         ->columnSpan(1)
            //                                         ->schema([
            //                                             Forms\Components\DatePicker::make('shoot_startDate')
            //                                                 ->label('Date'),
            //                                             Forms\Components\TimePicker::make('shoot_startTime')
            //                                                 ->label('Start Time')
            //                                                 ->seconds(false)
            //                                                 ->minutesStep(5),
            //                                         ]),
            //                                     Section::make('End Date and Time of Egress')
            //                                         ->columns(1)
            //                                         ->columnSpan(1)
            //                                         ->schema([
            //                                             Forms\Components\DatePicker::make('shoot_endDate')
            //                                                 ->label('Date'),
            //                                             Forms\Components\TimePicker::make('shoot_endTime')
            //                                                 ->label('End Time')
            //                                                 ->seconds(false)
            //                                                 ->minutesStep(5),
            //                                         ]),
            //                                     Section::make('Working Hours of Minor')
            //                                         ->columns(1)
            //                                         ->columnSpan(1)
            //                                         ->schema([
            //                                             Forms\Components\DatePicker::make('shoot_workHoursMinor_date')
            //                                                 ->label('Date'),
            //                                             Forms\Components\TimePicker::make('shoot_workHoursMinor_startTime')
            //                                                 ->label('From')
            //                                                 ->seconds(false)
            //                                                 ->minutesStep(5),
            //                                             Forms\Components\TimePicker::make('shoot_workHoursMinor_endTime')
            //                                                 ->label('To')
            //                                                 ->seconds(false)
            //                                                 ->minutesStep(5),
            //                                         ]),
            //                                 ]),
            //                         ]),
                                
                                
            //                 ]),
            //             Forms\Components\Repeater::make('mtprfCancel')
            //                 ->columnSpan(2)
            //                 ->columns(3)
            //                 ->label('Cancellation of Shoot')
            //                 ->relationship()
            //                 ->addActionLabel('+ Additional Shoot Cancellation')
            //                 ->schema([
            //                     Section::make(' ')
            //                         ->columns(1)
            //                         ->columnSpan(1)
            //                         ->schema([
            //                             Forms\Components\DatePicker::make('shoot_cancel_date')
            //                                 ->label('Cancellation Date'),
            //                         ]),
            //                     Section::make(' ')
            //                         ->columns(1)
            //                         ->columnSpan(1)
            //                         ->schema([
            //                             Forms\Components\TextInput::make('shoot_cancel_reason')
            //                                 ->label('Reason for Cancellation'),
            //                             Forms\Components\TextInput::make('shoot_cancel_affected')
            //                                 ->label('Number of Affected Workers')
            //                                 ->integer()
            //                                 ->minValue(0)
            //                                 ->default(0),
            //                         ]),
            //                     Section::make(' ')
            //                         ->columns(1)
            //                         ->columnSpan(1)
            //                         ->schema([
            //                             Forms\Components\ToggleButtons::make('shoot_cancel_commenced')
            //                                 ->label('Commenced Work')
            //                                 ->grouped()
            //                                 ->options([
            //                                     'Yes' => 'Yes',
            //                                     'No' => 'No',
            //                                 ])
            //                                 ->colors([
            //                                     'Yes' => 'success',
            //                                     'No' => 'danger',
            //                                 ])
            //                                 ->icons([
            //                                     'Yes' => 'heroicon-o-check',
            //                                     'No' => 'heroicon-o-x-mark',
            //                                 ]),
            //                             Forms\Components\ToggleButtons::make('shoot_cancel_notice')
            //                                 ->label('Notice of Cancellation')
            //                                 ->grouped()
            //                                 ->options([
            //                                     'Yes' => 'Yes',
            //                                     'No' => 'No',
            //                                 ])
            //                                 ->colors([
            //                                     'Yes' => 'success',
            //                                     'No' => 'danger',
            //                                 ])
            //                                 ->icons([
            //                                     'Yes' => 'heroicon-o-check',
            //                                     'No' => 'heroicon-o-x-mark',
            //                                 ]),
            //                         ]),
            //                 ]),
            //             Section::make()
            //                 ->schema([
            //                     Forms\Components\Textarea::make('mtprf_shoot-remarks')
            //                         ->label('Remarks')
            //                         ->maxLength(255),
            //                 ])
            //         ]),
            //     Wizard\Step::make('Service Provider/s Details')
            //         ->schema([
            //             Forms\Components\Repeater::make('mtprfContract')
            //                 ->columns(5)
            //                 ->label(' ')
            //                 ->relationship('mtprfContract')
            //                 ->addActionLabel('+ Additional Service Provider')
            //                 ->schema([
            //                     Section::make()
            //                         ->columnSpan(4)
            //                         ->columns(6)
            //                         ->schema([
            //                             Forms\Components\TextInput::make('mtprf_contractorName')
            //                                 ->columnSpan(2)
            //                                 ->label('Name of Contractor/s'),
            //                             Forms\Components\TextInput::make('mtprf_contractorPsic')
            //                                 ->columnSpan(2)
            //                                 ->label('Service/s Provided'),
            //                             Forms\Components\TextInput::make('mtprf_contractorAddress')
            //                                 ->columnSpan(2)
            //                                 ->label('Address'),
            //                             Forms\Components\TextInput::make('mtprf_contractorNum')
            //                                 ->columnSpan(3)
            //                                 ->label('Focal Person / Mobile Number'),
            //                             Forms\Components\TextInput::make('mtprf_contractorReg')
            //                                 ->columnSpan(3  )
            //                                 ->label('Registration Number under Department Order No. 174'),
            //                         ]),
            //                     Section::make('Number of Deployed Workers')
            //                         ->columnSpan(1)
            //                         ->schema([
            //                             Forms\Components\TextInput::make('mtprf_contractorMaleWork')
            //                                 ->label('Male'),
            //                             Forms\Components\TextInput::make('mtprf_contractorFemaleWork')
            //                                 ->label('Female'),
            //                         ]),
            //                 ]),
            //         ]),
            //     Wizard\Step::make('Occupational Safety and Health')
            //         ->schema([
            //             Section::make('OSH Personnel Requirement')
            //                 ->columns(3)
            //                 ->schema([
            //                     Forms\Components\TextInput::make('mtprf_safetyOfficer')
            //                         ->label('Name of Safety Officer/s (Principal Office) Name of Safety Officer/s (Onsite)')
            //                         ->columnSpan(2)
            //                         ->maxLength(255),
            //                     Forms\Components\TextInput::make('mtprf_safetyOfficer_contact')
            //                         ->label('Contact No.')
            //                         ->columnSpan(1)
            //                         ->maxLength(255),
            //                     Forms\Components\TextInput::make('mtprf_firstAide')
            //                         ->label('Name of First Aider/s (Principal Office) Name of First Aider/s (Onsite)')
            //                         ->columnSpan(2)
            //                         ->maxLength(255),
            //                     Forms\Components\TextInput::make('mtprf_firstAide_contact')
            //                         ->label('Contact No.')
            //                         ->columnSpan(1)
            //                         ->maxLength(255),
            //                     Forms\Components\ToggleButtons::make('mtprf_safeHealthCommittee')
            //                         ->label('Safety and Health Committee')
            //                         ->columnSpan(3)
            //                         ->grouped()
            //                         ->options([
            //                             'Yes' => 'Yes',
            //                             'No' => 'No',
            //                         ])
            //                         ->colors([
            //                             'Yes' => 'success',
            //                             'No' => 'danger',
            //                         ])
            //                         ->icons([
            //                             'Yes' => 'heroicon-o-check',
            //                             'No' => 'heroicon-o-x-mark',
            //                         ]),
            //                     Forms\Components\ToggleButtons::make('mtprf_hospitalMoa')
            //                         ->label('Memorandum of Agreement with a Hospital')
            //                         ->columnSpan(3)
            //                         ->grouped()
            //                         ->options([
            //                             'Yes' => 'Yes',
            //                             'No' => 'No',
            //                             'N/A' => 'N/A'
            //                         ])
            //                         ->colors([
            //                             'Yes' => 'success',
            //                             'No' => 'danger',
            //                             'N/A' => 'primary'
            //                         ])
            //                         ->icons([
            //                             'Yes' => 'heroicon-o-check',
            //                             'No' => 'heroicon-o-x-mark',
            //                         ]),

            //                 ]),
                        
                        
            //             Section::make('OSH Program')
            //                 ->columns(2)
            //                 ->schema([
            //                     Forms\Components\ToggleButtons::make('mtprf_safetyProgram')
            //                         ->columnSpan(1)
            //                         ->label('Safety Program')
            //                         ->grouped()
            //                         ->options([
            //                             'Yes' => 'Yes',
            //                             'No' => 'No',
            //                         ])
            //                         ->colors([
            //                             'Yes' => 'success',
            //                             'No' => 'danger',
            //                         ])
            //                         ->icons([
            //                             'Yes' => 'heroicon-o-check',
            //                             'No' => 'heroicon-o-x-mark',
            //                         ]),
            //                     Forms\Components\ToggleButtons::make('mtprf_permits')
            //                         ->columnSpan(1)
            //                         ->label('Permits')
            //                         ->grouped()
            //                         ->options([
            //                             'Yes' => 'Yes',
            //                             'No' => 'No',
            //                             'N/A' => 'N//A',
            //                         ])
            //                         ->colors([
            //                             'Yes' => 'success',
            //                             'No' => 'danger',
            //                             'N/A' => 'primary'
            //                         ])
            //                         ->icons([
            //                             'Yes' => 'heroicon-o-check',
            //                             'No' => 'heroicon-o-x-mark',
            //                         ]),
            //                     Forms\Components\ToggleButtons::make('mtprf_riskClass')
            //                         ->columnSpan(1)
            //                         ->label('Risk Classification')
            //                         ->options([
            //                             'Low' => 'Low',
            //                             'Medium' => 'Medium',
            //                             'High' => 'High',
            //                         ])
            //                         ->colors([
            //                             'Low' => 'success',
            //                             'Medium' => 'primary',
            //                             'High' => 'danger'
            //                         ]),
            //                     Forms\Components\ToggleButtons::make('mtprf_firearms')
            //                         ->columnSpan(1)
            //                         ->label('Firearms and Weaponry')
            //                         ->grouped()
            //                         ->options([
            //                             'Yes' => 'Yes',
            //                             'No' => 'No',
            //                             'N/A' => 'N//A',
            //                         ])
            //                         ->colors([
            //                             'Yes' => 'success',
            //                             'No' => 'danger',
            //                             'N/A' => 'primary'
            //                         ])
            //                         ->icons([
            //                             'Yes' => 'heroicon-o-check',
            //                             'No' => 'heroicon-o-x-mark',
            //                         ]),
            //                     Forms\Components\ToggleButtons::make('mtprf_emergencyTransport')
            //                         ->label('Emergency Transport Vehicle Available')
            //                         ->grouped()
            //                         ->options([
            //                             'Yes' => 'Yes',
            //                             'No' => 'No',
            //                         ])
            //                         ->colors([
            //                             'Yes' => 'success',
            //                             'No' => 'danger',
            //                         ])
            //                         ->icons([
            //                             'Yes' => 'heroicon-o-check',
            //                             'No' => 'heroicon-o-x-mark',
            //                         ]), 
                                
            //                     Forms\Components\ToggleButtons::make('mtprf_animalHandling')
            //                         ->columnSpan(1)
            //                         ->label('Animal Handling')
            //                         ->grouped()
            //                         ->options([
            //                             'Yes' => 'Yes',
            //                             'No' => 'No',
            //                             'N/A' => 'N//A',
            //                         ])
            //                         ->colors([
            //                             'Yes' => 'success',
            //                             'No' => 'danger',
            //                             'N/A' => 'primary'
            //                         ])
            //                         ->icons([
            //                             'Yes' => 'heroicon-o-check',
            //                             'No' => 'heroicon-o-x-mark',
            //                         ]),
            //                     Forms\Components\FileUpload::make('mtprf_actionPlan')
            //                         ->columnSpan(1)
            //                         ->label('Action Plan'),
            //                     Forms\Components\TextInput::make('mtprf_others')
            //                         ->label('Others')
            //                         ->maxLength(255), 
            //                 ]),
                        
                        
            //         ]),
            //     Wizard\Step::make('Standard Treatment')
            //         ->schema([
            //             Section::make()
            //                 ->columns(3)
            //                 ->schema([
            //                     Forms\Components\ToggleButtons::make('mtprf_decorumCommitee')
            //                         ->columnSpan(2)
            //                         ->label('Commitee on Decorum and  Investigation')
            //                         ->grouped()
            //                         ->options([
            //                             'Yes' => 'Yes',
            //                             'No' => 'No',
            //                         ])
            //                         ->colors([
            //                             'Yes' => 'success',
            //                             'No' => 'danger',
            //                         ])
            //                         ->icons([
            //                             'Yes' => 'heroicon-o-check',
            //                             'No' => 'heroicon-o-x-mark',
            //                         ]),
            //                     Forms\Components\ToggleButtons::make('mtprf_policy_harrassment')
            //                         ->columnSpan(1)
            //                         ->label('Policy on Anti-Sexual Harassment/Safe Spaces')
            //                         ->grouped()
            //                         ->options([
            //                             'Yes' => 'Yes',
            //                             'No' => 'No',
            //                         ])
            //                         ->colors([
            //                             'Yes' => 'success',
            //                             'No' => 'danger',
            //                         ])
            //                         ->icons([
            //                             'Yes' => 'heroicon-o-check',
            //                             'No' => 'heroicon-o-x-mark',
            //                         ]),

            //                     Forms\Components\TextInput::make('mtprf_representative')
            //                         ->label('Name of Employer\'s Representative')
            //                         ->columnSpan(2)
            //                         ->maxLength(255),
            //                     Forms\Components\ToggleButtons::make('mtprf_policy_mentalHealth')
            //                         ->columnSpan(1)
            //                         ->label('Policy on Anti-Sexual Harassment/Safe Spaces')
            //                         ->grouped()
            //                         ->options([
            //                             'Yes' => 'Yes',
            //                             'No' => 'No',
            //                         ])
            //                         ->colors([
            //                             'Yes' => 'success',
            //                             'No' => 'danger',
            //                         ])
            //                         ->icons([
            //                             'Yes' => 'heroicon-o-check',
            //                             'No' => 'heroicon-o-x-mark',
            //                         ]),

            //                     Forms\Components\TextInput::make('mtprf_representativeAgent')
            //                         ->label('Name of Workers\' Representative (Sole and Exclusive Bargaining Agent, if any):')
            //                         ->columnSpan(2)
            //                         ->maxLength(255),
            //                     Forms\Components\TextInput::make('mtprf_representativeSupervisor')
            //                         ->label('Name of Workers\' Representative (Supervisory):')
            //                         ->columnSpan(2)
            //                         ->maxLength(255),
            //                     Forms\Components\TextInput::make('mtprf_representativeRankFile')
            //                         ->label('Name of Workers\' Representative (Rank and File):')
            //                         ->columnSpan(2)
            //                         ->maxLength(255),
            //                     Forms\Components\Textarea::make('mtprf_remarks')
            //                         ->label('Remarks/Others:')
            //                         ->columnSpan(1)
            //                         ->maxLength(255),
            //                 ]),
            //             Section::make('Cases on Gender Based Violence')
            //                 ->schema([
            //                     Section::make()
            //                         ->columns(3)
            //                         ->schema([
            //                             Forms\Components\TextInput::make('mtprf_gbv_affectedTotal')
            //                                 ->label('Total No. of Affected Workers:')
            //                                 ->columnSpan(3)
            //                                 ->integer()
            //                                 ->default(0)
            //                                 ->minValue(0),
            //                             Forms\Components\TextInput::make('mtprf_gbv_affectedMale')  
            //                                 ->label('Male:')
            //                                 ->columnSpan(1)
            //                                 ->integer()
            //                                 ->default(0)
            //                                 ->minValue(0),
            //                             Forms\Components\TextInput::make('mtprf_gbv_affectedFemale')
            //                                 ->label('Female:')
            //                                 ->columnSpan(1)
            //                                 ->integer()
            //                                 ->default(0)
            //                                 ->minValue(0),
            //                             Forms\Components\TextInput::make('mtprf_gbv_affectedLgbtq')
            //                                 ->label('LGTBQIA+:')
            //                                 ->columnSpan(1)
            //                                 ->integer()
            //                                 ->default(0)
            //                                 ->minValue(0),
            //                         ]),
            //                     Section::make()
            //                         ->columns(3)
            //                         ->schema([
            //                             Forms\Components\TextInput::make('mtprf_gbv_offenderTotal')
            //                                 ->label('Total No. of Offenders:')
            //                                 ->columnSpan(3)
            //                                 ->integer()
            //                                 ->default(0)
            //                                 ->minValue(0),
            //                             Forms\Components\TextInput::make('mtprf_gbv_offenderMale')
            //                                 ->label('Male:')
            //                                 ->columnSpan(1)
            //                                 ->integer()
            //                                 ->default(0)
            //                                 ->minValue(0),
            //                             Forms\Components\TextInput::make('mtprf_gbv_offenderFemale')
            //                                 ->label('Female:')
            //                                 ->columnSpan(1)
            //                                 ->integer()
            //                                 ->default(0)
            //                                 ->minValue(0),
            //                             Forms\Components\TextInput::make('mtprf_gbv_offenderLgbtq')
            //                                 ->label('LGBTQIA+:')
            //                                 ->columnSpan(1)
            //                                 ->integer()
            //                                 ->default(0)
            //                                 ->minValue(0),
            //                         ]),
                                
                                
            //                 ]),
                        
                            
                        
            //         ]),
            //     Wizard\Step::make('Certification')
            //         ->schema([
            //             Section::make()
            //                 ->label('Prepared By')
            //                 ->columns(4)
            //                 ->schema([
            //                     Forms\Components\TextInput::make('mtprf_preparedBy')
            //                         ->label('Prepared By')
            //                         ->columnSpan(2)
            //                         ->maxLength(255),
            //                     Forms\Components\FileUpload::make('mtprf_preparedSign')
            //                         ->label('Signature over Printed Name')
            //                         ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
            //                         ->columnSpan(2),
            //                     Forms\Components\TextInput::make('mtprf_designation')
            //                         ->label('Designation')
            //                         ->columnSpan(2)
            //                         ->maxLength(255),
            //                 ])                                  
            //         ]),    
                
                
            // ])
            // ->submitAction(new HtmlString(Blade::render(<<<BLADE
            //     <x-filament::button color="success" icon="heroicon-o-check" tag="button" type="submit" size="lg" wire:click="create" >
            //         Submit
            //         <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="animate-spin fi-btn-icon transition duration-75 h-5 w-5 text-white" wire:loading.delay.default="" wire:target="dispatchFormEvent">
            //             <path clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
            //             <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
            //         </svg>
            //     </x-filament::button>
            // BLADE))),
        ]);
    }
}
