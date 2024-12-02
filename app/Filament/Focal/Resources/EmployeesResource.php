<?php

namespace App\Filament\Focal\Resources;

use App\Filament\Resources\EmployeesResource\Pages;
use App\Filament\Resources\EmployeesResource\RelationManagers;
use App\Models\Employees;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;


use Filament\Tables\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use App\Filament\Exports\EmployeesExporter;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;

class EmployeesResource extends Resource
{
    protected static ?string $model = Employees::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass-circle';

    protected static ?int $navigationSort = 3;

    protected static ?string $heading = 'Employee Search';

    protected static ?string $navigationLabel = 'Employee Search';

    public static function form(Form $form): Form
    {
        return $form
        
            ->schema([
                Section::make()
                    ->columns(4)
                    ->schema([
                        Forms\Components\TextInput::make('emp_lastName')
                            ->label('Last Name')
                            ->columnSpan(1)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_firstName')
                            ->label('First Name')
                            ->columnSpan(1)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_middleName')
                            ->label('Middle Name')
                            ->columnSpan(1)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_extensionName')
                            ->label('Name Extansion')
                            ->columnSpan(1)
                            ->maxLength(255),
                        
                        Forms\Components\DatePicker::make('emp_birthday')
                            ->label('Birthdate')
                            ->columnSpan(2),
                        Forms\Components\Select::make('emp_sex')
                            ->label('Sex')
                            ->columnSpan(2)
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female',
                                'Prefer not to say' => 'Prefer not to say',
                            ]),
                        Forms\Components\TextInput::make('emp_civilStatus')
                            ->label('Civil Status')
                            ->maxLength(255),
                    ]),
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('emp_houseNum')
                            ->label("House Number")
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_street')
                            ->label('Street')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_region')
                            ->label('Region')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_province')
                            ->label('Province')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_city')
                            ->label('City')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_barangay')
                            ->label('Barangay')
                            ->maxLength(255),
                    ]),
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('emp_wage')
                            ->label('Wage')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_numDependents')
                            ->label('Number of Independents')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_serviceLength')
                            ->label('Length of Service')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_occupation')
                            ->label('Occupation')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_yearsExp')
                            ->label('Years of Experience')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_employmentStatus')
                            ->label('Employment Status')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_shiftStart')
                            ->label('Start of Shift')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_shiftEnd')
                            ->label('End of Shift')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_workHours')
                            ->label('Working Hours/Day')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emp_workDays')
                            ->label('Working Days/Week')
                            ->maxLength(255),
                    ]),    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function() {
                if(Auth::user()->authority == '20'){
                    return Employees::query()->all();
                }else{
                    $est_array = Establishment::query()->where('region_id', Auth::user()->authority)->pluck('est_id');
                    return Employees::query()->whereIn('emp_estabId', $est_array);
                }
            })
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
                    ->toggleable(),
                Tables\Columns\TextColumn::make('emp_extensionName')
                    ->searchable()
                    ->label('Name Extension')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('emp_birthday')
                    ->date()
                    ->sortable()
                    ->label('Birthday')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('emp_sex')
                    ->searchable()
                    ->label('Sex')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('emp_civilStatus')
                    ->searchable()
                    ->label('Civil Status')
                    ->toggleable(),
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
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(EmployeesExporter::class)
                    ->label('Export to Excel')
                    ->formats([
                        ExportFormat::Xlsx,
                        ExportFormat::Csv,
                    ])
                    ->fileName(date('Y-m-d') . '- Employees'),
            ])
            ->emptyStateHeading('Empty')
            ->emptyStateDescription('There is no Employee data yet')
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
            'edit' => Pages\EditEmployees::route('/{record}/edit'),
        ];
    }
}
