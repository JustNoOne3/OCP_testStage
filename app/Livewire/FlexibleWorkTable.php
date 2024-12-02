<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\FlexibleWork;
use App\Models\FlexibleWorkTemp;
use App\Models\TempEmp;
use App\Models\Establishment;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\CreateAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Filament\Forms\Components\Section;
use App\Models\Geocode;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Carbon\Carbon;
use Filament\Forms\Components\Livewire;
use App\Livewire\EmployeeTable;

class FlexibleWorkTable extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function render()
    {
        return view('livewire.flexible-work-table');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(FlexibleWorkTemp::query()->where('fwa_estabId', Auth::user()->est_id))
            ->columns([
                TextColumn::make('fwa_startDate')
                    ->date()
                    ->label('Effectivity Date')
                    ->sortable(),
                TextColumn::make('fwa_endDate')
                    ->date()
                    ->label('End Date')
                    ->sortable(),
                TextColumn::make('fwa_type')
                    ->label('Type of FWA / AWS')
                    ->searchable(),
                TextColumn::make('fwa_reason')
                    ->label('Cause')
                    ->searchable(),
            ])
            ->emptyStateHeading('Empty')
            ->emptyStateDescription('Add a new Record')
            ->emptyStateIcon('heroicon-o-bookmark')
            ->headerActions([
                Action::make('create')
                    ->label('Add Record')
                    ->model(FlexibleWorkTemp::class)
                    ->form([
                        Section::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\DatePicker::make('fwa_startDate')
                                    ->columnSpan(1)
                                    ->label('Start Date')
                                    ->native(false),
                                Forms\Components\DatePicker::make('fwa_endDate')
                                ->columnSpan(1)
                                    ->label('End Date')
                                    ->native(false),
                                Forms\Components\Select::make('fwa_type')
                                    ->columnSpan(1)
                                    ->searchable()
                                    ->label('Select Type of FWA / AWS')
                                    ->native(false)
                                    ->live()
                                    ->options([
                                        'TOE' => 'Transfer of Employees to another branch of the same employer',
                                        'AOE' => 'Assignment  of Employees to ther function or position in the same or other branch or outlets of the same employer',
                                        'RWD' => 'Reduction of Workdays per week',
                                        'RWH' => 'Reduction of Workhours per day',
                                        'JR' =>'Job Rotation alternatively providing employees with work within the workweek or within the month',
                                        'PCE' =>'Partial Closure of Establishment where some unit or departments of the establishment are continued while other units or department are closed',
                                        'ROW' => 'Rotation of Workers',
                                        'FCL' => 'Forced Leave',
                                        'BTS' =>'Broken-Time Schedule',
                                        'CWW' => 'Compressed Work Week',
                                        'TWA' => 'Telecommuting Work Arrangement',
                                        'OTH' => 'Others',
                                    ]),
                                Forms\Components\TextInput::make('fwa_typeSpecify')
                                    ->columnSpan(1)
                                    ->label('Specify (Others)')
                                    ->hidden(function(Get $get){
                                        if($get('fwa_type') == 'OTH'){
                                            return false;
                                        }else{
                                            return true;
                                        }
                                    }),
                                Forms\Components\Select::make('fwa_reason')
                                    ->columnSpan(1)
                                    ->searchable()
                                    ->label('Select Primary Reason')
                                    ->native(false)
                                    ->live()
                                    ->options([
                                        'Economic Reasons' => 'Economic Reasons',
                                        'CI' => 'Competition from Imports',
                                        'CMM' => 'Change in Management/merger',
                                        'FL' => 'Financial Losses',
                                        'GR' => 'Government Regulation',
                                        'HCP' => 'High cost of Production',
                                        'LC' => 'Lack of Capital',
                                        'LM' => 'Lack of Market/ slump in demand/ cancellation of orders',
                                        'LRM' => 'Lack of raw materials',
                                        'MR' => 'Increase in minimum wage rate',
                                        'PD' => 'Peso depreciation',
                                        'UPP' => 'Incompetitive price of products Non-Economic Reasons',
                                        'INV' => 'Inventory',
                                        'NMC' => 'Natural or man-made calamity',
                                        'PC' => 'Project Completion',
                                        'RGM' => 'Repair or general maintenance',
                                        'WSO' => 'Work stoppage order/ cease and desist order',
                                        'OTH' => 'Others'
                                    ]),
                                Forms\Components\TextInput::make('fwa_reasonSpecify')
                                    ->columnSpan(1)
                                    ->label('Specify (Others)')
                                    ->hidden(function(Get $get){
                                        if($get('fwa_reason') == 'OTH'){
                                            return false;
                                        }else{
                                            return true;
                                        }
                                    }),
                            ]),
                        Section::make()
                            ->description(fn():Htmlable => new HtmlString("
                                    <div style=\"color: gray; font-size: 12px;\">Instructions:</div>
                                    <div style=\"color: gray; font-size: 12px; margin-left: 5px;\">1. Check the Employees to be Selected</div>
                                    <div style=\"color: gray; font-size: 12px; margin-left: 5px;\">2. Click the button 'ADD SELECTED'</div>
                                ")
                            )
                            ->schema([
                                Livewire::make(EmployeeTable::class)
                                    ->key('employee-table'),
                            ])
                        
                    ])
            ]);
        }
}
