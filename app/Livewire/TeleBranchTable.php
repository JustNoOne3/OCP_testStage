<?php

namespace App\Livewire;

use Livewire\Component;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use App\Models\TeleReportTemp;
use Filament\Tables\Actions\Action;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Form;
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
use App\Livewire\TeleBranchTable;
use Filament\Notifications\Notification;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class TeleBranchTable extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(TeleReportTemp::query()->where('teleBranch_estabId', Auth::user()->est_id))
            ->columns([
                TextColumn::make('id')
                    ->label('Report ID'),
                TextColumn::make('created_at')
                    ->label('Date'),
                TextColumn::make('teleBranch_total')
                    ->label('Covered Workers'),
                // TextColumn::make('teleBranch_specialTotal')
                //     ->label('Covered Special Workers'),
            ])
            ->emptyStateHeading('Empty')
            ->emptyStateDescription('Add a new Record')
            ->emptyStateIcon('heroicon-o-bookmark')
            ->headerActions([
                Action::make('create')
                    ->label('Add Branch Report')
                    ->model(TeleReportTemp::class)
                    ->action(function (array $data, string $model): TeleReportTemp {
                        $uuid = Uuid::uuid4()->toString();
                        $microseconds = substr(explode('.', microtime(true))[1], 0, 6); // Limit microseconds to 6 digits
                        $uuid = 'branch-' . substr($uuid, 0, 9) . '-' . $microseconds;

                        $data['id'] = $uuid;
                        $data['teleBranch_estabId'] = User::query()->where('email', $data['teleBranch_estabId'])->value('est_id');
                        
                        $data['teleBranch_total'] = $data['teleBranch_manageMale'] + $data['teleBranch_manageFemale']
                        + $data['teleBranch_superMale'] + $data['teleBranch_superFemale'] 
                        + $data['teleBranch_rankMale'] + $data['teleBranch_rankFemale'];

                        $data['teleBranch_specialTotal'] = $data['teleBranch_disabMale'] + $data['teleBranch_disabFemale']
                        + $data['teleBranch_soloperMale'] + $data['teleBranch_soloperFemale']
                        + $data['teleBranch_immunoMale'] + $data['teleBranch_immunoFemale']
                        + $data['teleBranch_mentalMale'] + $data['teleBranch_mentalFemale']
                        + $data['teleBranch_seniorMale'] + $data['teleBranch_seniorFemale'];
                        // dd($data);
                        return $model::create($data);
                    })
                    ->form([
                        Section::make()
                            ->columns(4)
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('id')
                                            ->hidden(),
                                        Forms\Components\TextInput::make('teleBranch_estabId')
                                            ->required()
                                            ->label('Branch Email')
                                            ->placeholder('Input the email used on the branch account.')
                                            ->exists(table: User::class, column: 'email')
                                    ]),
                                Section::make('Worker\'s Covered')
                                    ->columnSpan(2)
                                    ->columns(2)
                                    ->schema([
                                        Section::make('Managerial Employees')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('teleBranch_manageMale')
                                                    // ->required()
                                                    ->label("Male")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('teleBranch_manageFemale')
                                                    // ->required()
                                                    ->label("Female")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                            ]),
                                        Section::make('Supervisory')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('teleBranch_superMale')
                                                    // ->required()
                                                    ->label("Male")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('teleBranch_superFemale')
                                                    // ->required()
                                                    ->label("Female")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                            ]),
                                        Section::make('Rank and File')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('teleBranch_rankMale')
                                                    // ->required()
                                                    ->label("Male")
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('teleBranch_rankFemale')
                                                    // ->required()
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
                                    ->columnSpan(2)
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
                                        // Forms\Components\TextInput::make('teleBranch_specialTotal')
                                        //     // ->required()
                                        //     ->columnSpan(2)
                                        //     ->label("Total")
                                        //     ->disabled()
                                        //     ->maxLength(255),
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
                            ]),
                        
                        Section::make('Telecommuting Workplace')
                            ->schema([
                                Forms\Components\Select::make('teleBranch_workspace')
                                    ->label('Alternative Workplace')
                                    ->native(false)
                                    ->options([
                                        'Branch Office (including Satellite Offices and Hubs)' => 'Branch Office (including Satellite Offices and Hubs) ',
                                        'Employee\'s Residence' => 'Employee\'s Residence',
                                        'Pre-selected by the company' => 'Pre-selected by the company',
                                        'At the discretion of the employee' => 'At the discretion of the employee ',
                                        'Others' => 'Others'
                                    ])
                                    ->live(),
                                // Forms\Components\CheckboxList::make('teleBranch_workspace_others')
                                //     ->label('')
                                //     ->options([
                                //         '5' => 'Pre-selected by the company',
                                //         '6' => 'At the discretion of the employee '
                                //     ])
                                //     ->hidden(function (Get $get){
                                //         if ($get('workplace') == '3'){
                                //             return false;
                                //         }else{
                                //             return true;
                                //         }
                                //     }),
                                Forms\Components\TextInput::make('teleBranch_workspace_others')
                                    ->label('Please Specify')
                                    ->hidden(function (Get $get){
                                        if ($get('teleBranch_workspace') == '5'){
                                            return false;
                                        }else{
                                            return true;
                                        }
                                    }),
                                
                            ]),
                        Section::make('Functional Areas Covered by the Telecommuting Program')
                            ->schema([
                                Forms\Components\Select::make('teleBranch_areasCovered')
                                    ->label('')
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
                                    ->columns(2)
                                    // ->gridDirection('row')
                                    ->live(),
                                Forms\Components\TextInput::make('teleBranch_areasCovered_others')
                                    ->label('Please Specify')
                                    ->live()
                                    ->hidden(function (Get $get){
                                        if ($get('teleBranch_areasCovered') === 'Others'){
                                            return false;
                                        }else{
                                            return true;
                                        } 
                                    }),
                            ])
                    ]),
                    
            ]);
    }
    public function render()
    {
        return view('livewire.tele-branch-table');
    }


}
