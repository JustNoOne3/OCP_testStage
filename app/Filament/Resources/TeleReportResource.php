<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeleReportResource\Pages;
use App\Filament\Resources\TeleReportResource\RelationManagers;
use App\Models\TeleReport;
use App\Models\TeleReportHead;
use App\Models\TeleReportBranch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Livewire;

use Filament\Tables\Columns\TextColumn;
use App\Models\Establishment;

use App\Livewire\TeleHeadInfolist;

use App\Filament\Exports\Month13thExporter;
use Filament\Tables\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;

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

class TeleReportResource extends Resource
{
    protected static ?string $model = TeleReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $modelLabel = 'Telecommuting Report';

    protected static ?string $navigationLabel = 'Telecommuting Reports';

    protected static ?string $navigationGroup = 'Reports';

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
            ->query(function() {
                if(Auth::user()->authority == '20'){
                    return TeleReport::query()->where('created_at', '!=', null);
                }else{
                    $est_array = Establishment::query()->where('region_id', Auth::user()->authority)->pluck('est_id');
                    return TeleReport::query()->whereIn('tele_estabId',$est_array);
                }
            })
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date of Submission'),
                TextColumn::make('tele_reportType')
                    ->label('Type of Report')
                    ->toggleable(),
                TextColumn::make('tele_estabId')
                    ->label('Name of Establishment')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => (Establishment::query()->where('est_id', $state)->value('est_name'))),

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
            
                Tables\Actions\Action::make('edit-teleHead')
                    ->hidden(function (TeleReport $record){
                        return $record->tele_reportType != 'Head Report';
                    })
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->modalSubmitActionLabel('Update')
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
                                    Forms\Components\Select::make('teleHead_workspace')
                                        ->label('Select Alternative Workplace')
                                        ->native(false)
                                        ->multiple()
                                        ->options([
                                            'Branch Office (including Satellite Offices and Hubs)' => 'Branch Office (including Satellite Offices and Hubs) ',
                                            'Employee\'s Residence' => 'Employee\'s Residence',
                                            'Pre-selected by the company' => 'Pre-selected by the company',
                                            'At the discretion of the employee' => 'At the discretion of the employee ',
                                            'Others' => 'Others',
                                        ])
                                        ->live(),
                                    Forms\Components\TextInput::make('teleHead_workspace_others')
                                        ->label('Please Specify')
                                        ->hidden(function (Get $get){
                                            if ($get('teleHead_workspace') == 'Others'){
                                                return false;
                                            }else{
                                                return true;
                                            }
                                        }),
                                    
                                ]),
                            Section::make('Functional Areas Covered by the Telecommuting Program')
                                ->schema([
                                    Forms\Components\Select::make('teleHead_areasCovered')
                                        ->label('Select Covered Areas')
                                        ->multiple()
                                        ->native(false)
                                        ->options([
                                            'Research and Development' => 'Research and Development',
                                            'Product Design and Development' => 'Product Design and Development',
                                            'Sales and Customer Support' => 'Sales and Customer Support',
                                            'Marketing and Brand Management' => 'Marketing and Brand Management',
                                            'Corporate Communication and Social Media Marketing' => 'Corporate Communication and Social Media Marketing',
                                            'Finance and Administrative functions/task' => 'Finance and Administrative functions/task',
                                            'Financial Management, Accounting, Audit, Controllership' => 'Financial Management, Accounting, Audit, Controllership',
                                            'Human Resource Management' => 'Human Resource Management',
                                            'IT and related Works' => 'IT and related Works',
                                            'Executive functions/tasks' => 'Executive functions/tasks',
                                            'Materials Management / Procurement' => 'Materials Management / Procurement',
                                            'Engineering' => 'Engineering',
                                            'Others' => 'Others'
                                        ])
                                        // ->gridDirection('row')
                                        ->live(),
                                    Forms\Components\TextInput::make('teleHead_areasCovered_others')
                                        ->label('Please Specify')
                                        ->hidden(function (Get $get){
                                            if ($get('teleHead_areasCovered') == 'Others'){
                                                return false;
                                            }else{
                                                return true;
                                            } 
                                        }),
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
                    ])
                    ->action(function (array $data, TeleReport $tele) {
                        $record = TeleReportHead::query()->where('id', $tele->tele_reportId)->first();
                        $record->update($data);
                        return 
                            Notification::make()
                                ->title('Successfully Updated the Report!')
                                ->icon('heroicon-o-document-text')
                                ->iconColor('success')
                                ->send();
                    }),

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
            
                Tables\Actions\Action::make('edit-teleBranch')
                    ->hidden(function (TeleReport $record){
                        return $record->tele_reportType != 'Branch Report';
                    })
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->modalSubmitActionLabel('Update')
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
                                    Forms\Components\Select::make('teleBranch_workspace')
                                        ->label('Select Alternative Workplace')
                                        ->native(false)
                                        ->multiple()
                                        ->options([
                                            'Branch Office (including Satellite Offices and Hubs)' => 'Branch Office (including Satellite Offices and Hubs) ',
                                            'Employee\'s Residence' => 'Employee\'s Residence',
                                            'Pre-selected by the company' => 'Pre-selected by the company',
                                            'At the discretion of the employee' => 'At the discretion of the employee ',
                                            'Others' => 'Others',
                                        ])
                                        ->live(),
                                    Forms\Components\TextInput::make('teleBranch_workspace_others')
                                        ->label('Please Specify')
                                        ->hidden(function (Get $get){
                                            if ($get('teleBranch_workspace') == 'Others'){
                                                return false;
                                            }else{
                                                return true;
                                            }
                                        }),
                                    
                                ]),
                            Section::make('Functional Areas Covered by the Telecommuting Program')
                                ->schema([
                                    Forms\Components\Select::make('teleBranch_areasCovered')
                                        ->label('Select Covered Areas')
                                        ->native(false)
                                        ->multiple()
                                        ->options([
                                            'Research and Development' => 'Research and Development',
                                            'Product Design and Development' => 'Product Design and Development',
                                            'Sales and Customer Support' => 'Sales and Customer Support',
                                            'Marketing and Brand Management' => 'Marketing and Brand Management',
                                            'Corporate Communication and Social Media Marketing' => 'Corporate Communication and Social Media Marketing',
                                            'Finance and Administrative functions/task' => 'Finance and Administrative functions/task',
                                            'Financial Management, Accounting, Audit, Controllership' => 'Financial Management, Accounting, Audit, Controllership',
                                            'Human Resource Management' => 'Human Resource Management',
                                            'IT and related Works' => 'IT and related Works',
                                            'Executive functions/tasks' => 'Executive functions/tasks',
                                            'Materials Management / Procurement' => 'Materials Management / Procurement',
                                            'Engineering' => 'Engineering',
                                            'Others' => 'Others'
                                        ])
                                        ->live(),
                                    Forms\Components\TextInput::make('teleBranch_areasCovered_others')
                                        ->label('Please Specify')
                                        ->hidden(function (Get $get){
                                            if ($get('teleBranch_areasCovered') == 'Others'){
                                                return false;
                                            }else{
                                                return true;
                                            } 
                                        }),
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
                    ])
                    ->action(function (array $data, TeleReport $tele) {
                        $record = TeleReportBranch::query()->where('id', $tele->tele_reportId)->first();
                        $record->update($data);
                        return 
                            Notification::make()
                                ->title('Successfully Updated the Report!')
                                ->icon('heroicon-o-document-text')
                                ->iconColor('success')
                                ->send();
                    }),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(Month13thExporter::class)
                    ->label('Export to Excel')
                    ->formats([
                        ExportFormat::Xlsx,
                    ])
                    ->fileName(date('Y-m-d') . '- 13th Month Report'),
            ])
            ->emptyStateHeading('Empty')
            ->emptyStateDescription('There is no Report Data yet')
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
            'index' => Pages\ListTeleReports::route('/'),
            'create' => Pages\CreateTeleReport::route('/create'),
            // 'view' => Pages\TeleHeadView::route('/view/{record}'),
            // 'edit' => Pages\EditTeleReport::route('/{record}/edit'),
        ];
    }
}
