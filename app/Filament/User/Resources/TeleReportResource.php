<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\TeleReportResource\Pages;
use App\Filament\User\Resources\TeleReportResource\RelationManagers;
use App\Models\TeleReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\TeleReportHead;
use App\Models\TeleReportBranch;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;
use Filament\Forms\Set;
use Closure;
use App\Livewire\EmployeeTable;
use App\Livewire\EmployeeReviewTable;
use App\Models\TempEmp;
use App\Models\Employees;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Wizard;

use Filament\Tables\Columns\TextColumn;

class TeleReportResource extends Resource
{
    protected static ?string $model = TeleReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'Telecommuting Report';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tele_reportId')
                    ->searchable()
                    ->label('Report ID'),
                TextColumn::make('tele_reportType')
                    ->searchable()
                    ->label('Report Type'),
                TextColumn::make('created_at')
                    ->searchable()
                    ->label('Date Submitted'),
                TextColumn::make('updated_at')
                    ->searchable()
                    ->label('Edited at'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('view-teleHead')
                    ->hidden(function (TeleReport $record){
                        return $record->tele_reportType != 'Head Report';
                    })
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->modalSubmitActionLabel('Done')
                    ->modalCancelAction(false)
                    ->disabledForm()
                    ->fillForm(
                        function (TeleReport $tele): array {
                            $record = TeleReportHead::query()->where('id', $tele->tele_reportId)->first();
                            return [
                                'teleHead_manageMale' => $record->teleHead_manageMale ,
                                'teleHead_manageFemale' => $record->teleHead_manageFemale ,
                                'teleHead_superMale' => $record->teleHead_superMale ,
                                'teleHead_superFemale' => $record->teleHead_superFemale ,
                                'teleHead_rankMale' => $record->teleHead_rankMale ,
                                'teleHead_rankFemale' => $record->teleHead_rankFemale ,
                                'teleHead_total' => $record->teleHead_total ,

                                'teleHead_disabMale' => $record->teleHead_disabMale ,
                                'teleHead_disabFemale' => $record->teleHead_disabFemale ,
                                'teleHead_soloperMale' => $record->teleHead_soloperMale ,
                                'teleHead_soloperFemale' => $record->teleHead_soloperFemale ,
                                'teleHead_immunoMale' => $record->teleHead_immunoMale ,
                                'teleHead_immunoFemale' => $record->teleHead_immunoFemale ,
                                'teleHead_mentalMale' => $record->teleHead_mentalMale ,
                                'teleHead_mentalFemale' => $record->teleHead_mentalFemale ,
                                'teleHead_seniorMale' => $record->teleHead_seniorMale ,
                                'teleHead_seniorFemale' => $record->teleHead_seniorFemale ,
                                'teleHead_specialTotal' => $record->teleHead_specialTotal ,

                                'teleHead_workspace' => $record->teleHead_workspace ,
                                'teleHead_workspace_others' => $record->teleHead_workspace_others ,
                                'teleHead_areasCovered' => $record->teleHead_areasCovered ,
                                'teleHead_areasCovered_others' => $record->teleHead_areasCovered_others ,

                                'teleHead_program' => $record->teleHead_program ,
                                'teleHead_employer' => $record->teleHead_employer ,
                                'teleHead_designation' => $record->teleHead_designation ,
                                'teleHead_contact' => $record->teleHead_contact ,
                            ];
                        }
                    )
                    ->form([
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
                                                    // ->required()
                                                    ->label("Male")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('teleHead_disabFemale')
                                                    // ->required()
                                                    ->label("Female")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                            ]),
                                        Section::make('Solo Parent')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('teleHead_soloperMale')
                                                    // ->required()
                                                    ->label("Male")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('teleHead_soloperFemale')
                                                    // ->required()
                                                    ->label("Female")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                            ]),
                                        Section::make('Immunocompromised ')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('teleHead_immunoMale')
                                                    // ->required()
                                                    ->label("Male")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('teleHead_immunoFemale')
                                                    // ->required()
                                                    ->label("Female")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                            ]),
                                        Section::make('With Mental Health Condition')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('teleHead_mentalMale')
                                                    // ->required()
                                                    ->label("Male")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('teleHead_mentalFemale')
                                                    // ->required()
                                                    ->label("Female")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                            ]),
                                        Section::make('Senior Citizen')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('teleHead_seniorMale')
                                                    // ->required()
                                                    ->label("Male")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('teleHead_seniorFemale')
                                                    // ->required()
                                                    ->label("Female")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                            ]),
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
                                        Forms\Components\TextInput::make('teleHead_workspace')
                                            ->label('Select Alternative Workplace'),
                                        Forms\Components\TextInput::make('teleHead_workspace_others')
                                            ->label('Specify'),
                                        
                                    ]),
                                Section::make('Functional Areas Covered by the Telecommuting Program')
                                    ->schema([
                                        Forms\Components\TextInput::make('teleHead_areasCovered')
                                            ->label('Select Covered Areas'),
                                        Forms\Components\TextInput::make('teleHead_areasCovered_others')
                                            ->label('Specify'),
                                    ])
                                
                                
                            ]),
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
            
                
                    // Branch
                Tables\Actions\Action::make('view-teleBranch')
                    ->hidden(function (TeleReport $record){
                        return $record->tele_reportType != 'Branch Report';
                    })
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->modalSubmitActionLabel('Done')
                    ->modalCancelAction(false)
                    ->disabledForm()
                    ->fillForm(
                        function (TeleReport $tele): array {
                            $record = TeleReportBranch::query()->where('id', $tele->tele_reportId)->first();
                            return [
                                'teleBranch_manageMale' => $record->teleBranch_manageMale ,
                                'teleBranch_manageFemale' => $record->teleBranch_manageFemale ,
                                'teleBranch_superMale' => $record->teleBranch_superMale ,
                                'teleBranch_superFemale' => $record->teleBranch_superFemale ,
                                'teleBranch_rankMale' => $record->teleBranch_rankMale ,
                                'teleBranch_rankFemale' => $record->teleBranch_rankFemale ,
                                'teleBranch_total' => $record->teleBranch_total ,

                                'teleBranch_disabMale' => $record->teleBranch_disabMale ,
                                'teleBranch_disabFemale' => $record->teleBranch_disabFemale ,
                                'teleBranch_soloperMale' => $record->teleBranch_soloperMale ,
                                'teleBranch_soloperFemale' => $record->teleBranch_soloperFemale ,
                                'teleBranch_immunoMale' => $record->teleBranch_immunoMale ,
                                'teleBranch_immunoFemale' => $record->teleBranch_immunoFemale ,
                                'teleBranch_mentalMale' => $record->teleBranch_mentalMale ,
                                'teleBranch_mentalFemale' => $record->teleBranch_mentalFemale ,
                                'teleBranch_seniorMale' => $record->teleBranch_seniorMale ,
                                'teleBranch_seniorFemale' => $record->teleBranch_seniorFemale ,
                                'teleBranch_specialTotal' => $record->teleBranch_specialTotal ,

                                'teleBranch_workspace' => $record->teleBranch_workspace ,
                                'teleBranch_workspace_others' => $record->teleBranch_workspace_others ,
                                'teleBranch_areasCovered' => $record->teleBranch_areasCovered ,
                                'teleBranch_areasCovered_others' => $record->teleBranch_areasCovered_others ,

                                'teleBranch_program' => $record->teleBranch_program ,
                                'teleBranch_employer' => $record->teleBranch_employer ,
                                'teleBranch_designation' => $record->teleBranch_designation ,
                                'teleBranch_contact' => $record->teleBranch_contact ,
                            ];
                        }
                    )
                    ->form([
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
                                                Forms\Components\TextInput::make('teleBranch_manageMale')
                                                    ->required()
                                                    ->label("Male")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('teleBranch_manageFemale')
                                                    ->required()
                                                    ->label("Female")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                            ]),
                                        Section::make('Supervisory')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('teleBranch_superMale')
                                                    ->required()
                                                    ->label("Male")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('teleBranch_superFemale')
                                                    ->required()
                                                    ->label("Female")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                            ]),
                                        Section::make('Rank and File')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('teleBranch_rankMale')
                                                    ->required()
                                                    ->label("Male")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('teleBranch_rankFemale')
                                                    ->required()
                                                    ->label("Female")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                            ]),
                                        Forms\Components\Placeholder::make('teleBranch_total')
                                            ->content(function (Get $get): int {
                                                return intval($get('teleBranch_manageMale')) + 
                                                        intval($get('teleBranch_manageFemale')) + 
                                                        intval($get('teleBranch_superMale')) + 
                                                        intval($get('teleBranch_superFemale')) + 
                                                        intval($get('teleBranch_rankMale')) + 
                                                        intval($get('teleBranch_rankFemale'));
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
                                                Forms\Components\TextInput::make('teleBranch_disabMale')
                                                    // ->required()
                                                    ->label("Male")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('teleBranch_disabFemale')
                                                    // ->required()
                                                    ->label("Female")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                            ]),
                                        Section::make('Solo Parent')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('teleBranch_soloperMale')
                                                    // ->required()
                                                    ->label("Male")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('teleBranch_soloperFemale')
                                                    // ->required()
                                                    ->label("Female")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                            ]),
                                        Section::make('Immunocompromised ')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('teleBranch_immunoMale')
                                                    // ->required()
                                                    ->label("Male")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('teleBranch_immunoFemale')
                                                    // ->required()
                                                    ->label("Female")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                            ]),
                                        Section::make('With Mental Health Condition')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('teleBranch_mentalMale')
                                                    // ->required()
                                                    ->label("Male")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('teleBranch_mentalFemale')
                                                    // ->required()
                                                    ->label("Female")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                            ]),
                                        Section::make('Senior Citizen')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('teleBranch_seniorMale')
                                                    // ->required()
                                                    ->label("Male")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('teleBranch_seniorFemale')
                                                    // ->required()
                                                    ->label("Female")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                            ]),
                                        Forms\Components\Placeholder::make('teleBranch_specialTotal')
                                            ->content(function (Get $get): int {
                                                return intval($get('teleBranch_disabMale')) + 
                                                        intval($get('teleBranch_disabFemale')) + 
                                                        intval($get('teleBranch_soloperMale')) + 
                                                        intval($get('teleBranch_soloperFemale')) + 
                                                        intval($get('teleBranch_immunoMale')) + 
                                                        intval($get('teleBranch_immunoFemale')) + 
                                                        intval($get('teleBranch_mentalMale')) + 
                                                        intval($get('teleBranch_mentalFemale')) + 
                                                        intval($get('teleBranch_seniorMale')) + 
                                                        intval($get('teleBranch_seniorFemale'));
                                            })
                                            ->label('Total'),
                                    ]),
                                Section::make('Telecommuting Workplace')
                                    ->schema([
                                        Forms\Components\TextInput::make('teleBranch_workspace')
                                            ->label('Select Alternative Workplace'),
                                        Forms\Components\TextInput::make('teleBranch_workspace_others')
                                            ->label('Specify'),
                                        
                                    ]),
                                Section::make('Functional Areas Covered by the Telecommuting Program')
                                    ->schema([
                                        Forms\Components\TextInput::make('teleBranch_areasCovered')
                                            ->label('Select Covered Areas'),
                                        Forms\Components\TextInput::make('teleBranch_areasCovered_others')
                                            ->label('Please Specify'),
                                    ])
                                
                                
                            ]),
                            Section::make()
                                ->columns(2)
                                ->schema([
                                    Forms\Components\FileUpload::make('teleBranch_program')
                                        ->label("Upload Telecommuting Program")
                                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                                        ->columnSpan(2),
                                    Forms\Components\TextInput::make('teleBranch_employer')
                                        ->label("Owner / Employer")
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('teleBranch_designation')
                                        ->label("Designation")
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('teleBranch_contact')
                                        ->label("Contact Number:")
                                        ->maxLength(255)
                                        ->mask('0999-999-9999')
                                        ->placeholder('09XX-XXX-XXXX'),
                                        
                                ]),
                    ]),
                    
                Tables\Actions\Action::make('request')
                    ->label('Request for Edit')
                    ->icon('heroicon-o-chevron-double-right')
                    ->color('danger')
                    ->modalSubmitActionLabel('Request')
                    ->form([
                        Section::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('req_field')
                                    ->required()
                                    ->columnSpan(1)
                                    ->label("Field to Edit")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('req_fieldNew')
                                    ->required()
                                    ->columnSpan(1)
                                    ->label("Replace With")
                                    ->maxLength(255),
                                ]),
                        Section::make()
                            ->schema([
                                Forms\Components\Textarea::make('req_reason')
                                    ->required()
                                    ->columnSpan(2)
                                    ->label("Reason for Editing")
                                    ->maxLength(255),
                                ]),                            
                    ])
                    ->action(function (array $data, TeleReport $record) {
                        $uuid = Uuid::uuid4()->toString();
                        $microseconds = substr(explode('.', microtime(true))[1], 0, 6);
                        $uuid = 'req-' . substr($uuid, 0, 12) . '-' . $microseconds;

                        $est = Establishment::query()->where('est_id', Auth::user()->est_id)->first();

                        $req = Request::create([
                            'id' => $uuid,
                            'req_reportId' => $record->id,
                            'req_reportType' => 'Telecommuting - '.$record->tele_reportType,
                            'req_estabId' => $record->tele_estabId,
                            'req_estabName' => $est->est_name,
                            'req_region'  => $est->region_id,
                            'req_field' => $data['req_field'],
                            'req_fieldNew'  => $data['req_fieldNew'],
                            'req_reason'  => $data['req_reason'],
                            'req_status'  => 'Pending',
                        ]);
                        return 
                            Notification::make()
                                ->title('Successfully Sent the Request!')
                                ->icon('heroicon-o-document-text')
                                ->iconColor('success')
                                ->send();
                    }),
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
            'index' => Pages\ListTeleReports::route('/'),
            'create' => Pages\CreateTeleReport::route('/create'),
            'edit' => Pages\EditTeleReport::route('/{record}/edit'),
        ];
    }
}
